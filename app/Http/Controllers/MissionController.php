<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AnneeAcad;
use App\Models\Equipe;
use App\Models\Faculte;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MissionController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $faculteId = $request->integer('faculte');
        $statut = $request->query('statut');

        $missions = Mission::with(['equipe', 'faculte', 'anneeAcad'])
            ->withCount(['homologations', 'vacations'])
            ->when($q, fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('numero_lettre', 'like', "%{$q}%")
                    ->orWhere('motif', 'like', "%{$q}%");
            }))
            ->when($faculteId, fn ($query) => $query->where('id_faculte', $faculteId))
            ->when($statut === 'actives', fn ($query) => $query->actives())
            ->when($statut === 'terminees', fn ($query) => $query->where('periode_fin', '<', now()->toDateString()))
            ->orderByDesc('date_lettre')
            ->paginate(12)
            ->withQueryString();

        return view('missions.index', [
            'missions' => $missions,
            'facultes' => Faculte::orderBy('nom_faculte')->get(),
            'q' => $q,
            'faculteId' => $faculteId,
            'statut' => $statut,
        ]);
    }

    public function create()
    {
        return view('missions.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $mission = Mission::create($data);

        $this->syncAgents($mission, $request->input('agents', []));

        return redirect()->route('missions.show', $mission)->with('success', 'Ordre de mission créé avec succès.');
    }

    public function show(Mission $mission)
    {
        $mission->load(['equipe.inspecteurs', 'faculte', 'anneeAcad', 'agents']);

        $favorable = $mission->homologations()->where('avis', 'Favorable')->count();
        $defavorable = $mission->homologations()->where('avis', 'Défavorable')->count();
        $vacations = $mission->vacations()->with('inspecteur')->get();
        $totalVacations = $vacations->sum('montant');
        $payeVacations = $vacations->whereNotNull('date_paiement')->sum('montant');

        return view('missions.show', compact(
            'mission',
            'favorable',
            'defavorable',
            'vacations',
            'totalVacations',
            'payeVacations'
        ));
    }

    public function edit(Mission $mission)
    {
        $mission->load('agents');

        return view('missions.edit', array_merge($this->formData(), [
            'mission' => $mission,
            'agentsSelectionnes' => $mission->agents->pluck('matricule_agent')->all(),
        ]));
    }

    public function update(Request $request, Mission $mission)
    {
        $data = $this->validated($request);

        $mission->update($data);

        $this->syncAgents($mission, $request->input('agents', []));

        return redirect()->route('missions.show', $mission)->with('success', 'Ordre de mission mis à jour.');
    }

    public function destroy(Mission $mission)
    {
        if ($mission->homologations()->exists() || $mission->vacations()->exists()) {
            return back()->with('error', 'Suppression impossible : cette mission possède des avis ou des vacations.');
        }

        DB::table('presenter')->where('id_mission', $mission->id_mission)->delete();
        $mission->delete();

        return redirect()->route('missions.index')->with('success', 'Ordre de mission supprimé.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'numero_lettre' => ['required', 'string', 'max:30'],
            'date_lettre' => ['required', 'date'],
            'motif' => ['nullable', 'string', 'max:250'],
            'periode_debut' => ['nullable', 'date'],
            'periode_fin' => ['nullable', 'date', 'after_or_equal:periode_debut'],
            'id_equipe' => ['required', 'exists:equipe,id_equipe'],
            'id_faculte' => ['required', 'exists:faculte,id_faculte'],
            'id_anneeacad' => ['required', 'exists:anneeacad,id_anneeacad'],
        ]);
    }

    private function syncAgents(Mission $mission, array $agents): void
    {
        DB::table('presenter')->where('id_mission', $mission->id_mission)->delete();

        foreach ($agents as $matricule) {
            DB::table('presenter')->insert([
                'matricule_agent' => $matricule,
                'id_mission' => $mission->id_mission,
                'date_presentation' => $mission->date_lettre?->toDateString() ?? now()->toDateString(),
            ]);
        }
    }

    private function formData(): array
    {
        return [
            'equipes' => Equipe::orderBy('id_equipe')->get(),
            'facultes' => Faculte::orderBy('nom_faculte')->get(),
            'annees' => AnneeAcad::orderByDesc('libelle')->get(),
            'agents' => Agent::orderBy('nom_agent')->get(),
            'agentsSelectionnes' => [],
        ];
    }
}
