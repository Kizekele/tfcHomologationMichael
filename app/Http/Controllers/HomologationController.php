<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Faculte;
use App\Models\Homologuer;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomologationController extends Controller
{
    public function index(Request $request)
    {
        $missions = Mission::with('faculte')->orderByDesc('date_lettre')->get();
        $mission = $missions->firstWhere('id_mission', $request->integer('mission')) ?? $missions->first();

        $q = trim((string) $request->query('q', ''));
        $statut = $request->query('statut');

        $etudiants = null;
        $avisMap = collect();

        if ($mission) {
            $etudiants = Etudiant::query()
                ->with('promotion')
                ->whereHas('promotion', fn ($p) => $p->where('id_faculte', $mission->id_faculte))
                ->when($q, function ($query) use ($q) {
                    $query->where(function ($w) use ($q) {
                        $w->where('matricule', 'like', "%{$q}%")
                            ->orWhere('nom', 'like', "%{$q}%")
                            ->orWhere('postnom', 'like', "%{$q}%")
                            ->orWhere('prenom', 'like', "%{$q}%");
                    });
                })
                ->when($statut === 'attente', fn ($query) => $query->whereDoesntHave('homologations', fn ($h) => $h->where('id_mission', $mission->id_mission)))
                ->when($statut === 'traite', fn ($query) => $query->whereHas('homologations', fn ($h) => $h->where('id_mission', $mission->id_mission)))
                ->orderBy('nom')
                ->paginate(15)
                ->withQueryString();

            $avisMap = Homologuer::where('id_mission', $mission->id_mission)->get()->keyBy('matricule');
        }

        return view('homologation.index', compact('missions', 'mission', 'etudiants', 'avisMap', 'q', 'statut'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricule' => ['required', 'exists:etudiant,matricule'],
            'id_mission' => ['required', 'exists:mission,id_mission'],
            'avis' => ['required', 'in:Favorable,Défavorable'],
            'observation' => ['nullable', 'string', 'max:250'],
            'numero_fiche' => ['nullable', 'string', 'max:30'],
        ]);

        $payload = [
            'avis' => $data['avis'],
            'date_avis' => now()->toDateString(),
            'observation' => $data['observation'] ?? null,
        ];

        $payload['numero_fiche'] = ($data['numero_fiche'] ?? null) ?: 'FH-'.now()->format('Y').'-'.str_pad((string) (Homologuer::count() + 1), 4, '0', STR_PAD_LEFT);

        $exists = Homologuer::where('matricule', $data['matricule'])
            ->where('id_mission', $data['id_mission'])
            ->exists();

        if ($exists) {
            Homologuer::where('matricule', $data['matricule'])
                ->where('id_mission', $data['id_mission'])
                ->update($payload);
        } else {
            DB::table('homologuer')->insert(array_merge($payload, [
                'matricule' => $data['matricule'],
                'id_mission' => $data['id_mission'],
            ]));
        }

        return back()->with('success', "Avis enregistré pour le dossier {$data['matricule']}.");
    }

    public function rapports(Request $request)
    {
        $missions = Mission::with('faculte')
            ->withCount([
                'homologations as total_avis',
                'homologations as favorables' => fn ($q) => $q->where('avis', 'Favorable'),
                'homologations as defavorables' => fn ($q) => $q->where('avis', 'Défavorable'),
            ])
            ->orderByDesc('date_lettre')
            ->get();

        $parFaculte = DB::table('homologuer')
            ->join('mission', 'mission.id_mission', '=', 'homologuer.id_mission')
            ->join('faculte', 'faculte.id_faculte', '=', 'mission.id_faculte')
            ->select(
                'faculte.nom_faculte',
                DB::raw('count(*) as total'),
                DB::raw("sum(case when homologuer.avis = 'Favorable' then 1 else 0 end) as favorables"),
                DB::raw("sum(case when homologuer.avis = 'Défavorable' then 1 else 0 end) as defavorables")
            )
            ->groupBy('faculte.nom_faculte')
            ->orderByDesc('total')
            ->get();

        $totaux = [
            'total' => $parFaculte->sum('total'),
            'favorables' => $parFaculte->sum('favorables'),
            'defavorables' => $parFaculte->sum('defavorables'),
        ];

        return view('homologation.rapports', compact('missions', 'parFaculte', 'totaux'));
    }

    public function destroy(string $matricule, int $mission)
    {
        Homologuer::where('matricule', $matricule)->where('id_mission', $mission)->delete();

        return back()->with('success', 'Avis supprimé.');
    }
}
