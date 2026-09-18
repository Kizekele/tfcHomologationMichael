<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Faculte;
use App\Models\Homologuer;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EtudiantController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $faculteId = $request->integer('faculte');
        $promotionId = $request->integer('promotion');
        $statut = $request->query('statut');

        $etudiants = Etudiant::query()
            ->with('promotion.faculte')
            ->withCount('homologations')
            ->addSelect(['dernier_avis' => Homologuer::query()
                ->select('avis')
                ->whereColumn('homologuer.matricule', 'etudiant.matricule')
                ->orderByDesc('date_avis')
                ->limit(1)])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('matricule', 'like', "%{$q}%")
                        ->orWhere('nom', 'like', "%{$q}%")
                        ->orWhere('postnom', 'like', "%{$q}%")
                        ->orWhere('prenom', 'like', "%{$q}%");
                });
            })
            ->when($faculteId, fn ($query) => $query->whereHas('promotion', fn ($p) => $p->where('id_faculte', $faculteId)))
            ->when($promotionId, fn ($query) => $query->where('id_promotion', $promotionId))
            ->when($statut === 'homologue', fn ($query) => $query->has('homologations'))
            ->when($statut === 'attente', fn ($query) => $query->doesntHave('homologations'))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('etudiants.index', [
            'etudiants' => $etudiants,
            'facultes' => Faculte::orderBy('nom_faculte')->get(),
            'promotions' => Promotion::with('faculte')->orderBy('nom_promotion')->get(),
            'q' => $q,
            'faculteId' => $faculteId,
            'promotionId' => $promotionId,
            'statut' => $statut,
        ]);
    }

    public function create()
    {
        return view('etudiants.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if (empty($data['matricule'])) {
            $data['matricule'] = $this->nextMatricule();
        }

        $etudiant = Etudiant::create($data);

        return redirect()->route('etudiants.show', $etudiant)->with('success', 'Dossier étudiant enregistré avec succès.');
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load(['promotion.faculte', 'homologations.mission.faculte']);

        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        return view('etudiants.edit', array_merge($this->formData(), compact('etudiant')));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $data = $this->validated($request, $etudiant);

        if (empty($data['matricule'])) {
            $data['matricule'] = $etudiant->matricule;
        }

        $etudiant->update($data);

        return redirect()->route('etudiants.show', $etudiant)->with('success', 'Dossier étudiant mis à jour.');
    }

    public function destroy(Etudiant $etudiant)
    {
        if ($etudiant->homologations()->exists()) {
            return back()->with('error', "Suppression impossible : cet étudiant possède des avis d'homologation.");
        }

        $etudiant->delete();

        return redirect()->route('etudiants.index')->with('success', 'Dossier étudiant supprimé.');
    }

    public function enAttente(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $faculteId = $request->integer('faculte');

        $etudiants = Etudiant::query()
            ->with('promotion.faculte')
            ->doesntHave('homologations')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('matricule', 'like', "%{$q}%")
                        ->orWhere('nom', 'like', "%{$q}%")
                        ->orWhere('postnom', 'like', "%{$q}%")
                        ->orWhere('prenom', 'like', "%{$q}%");
                });
            })
            ->when($faculteId, fn ($query) => $query->whereHas('promotion', fn ($p) => $p->where('id_faculte', $faculteId)))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('etudiants.en_attente', [
            'etudiants' => $etudiants,
            'facultes' => Faculte::orderBy('nom_faculte')->get(),
            'q' => $q,
            'faculteId' => $faculteId,
        ]);
    }

    private function validated(Request $request, ?Etudiant $etudiant = null): array
    {
        return $request->validate([
            'matricule' => ['nullable', 'string', 'max:20', Rule::unique('etudiant', 'matricule')->ignore($etudiant?->matricule, 'matricule')],
            'nom' => ['required', 'string', 'max:50'],
            'postnom' => ['nullable', 'string', 'max:50'],
            'prenom' => ['nullable', 'string', 'max:50'],
            'sexe' => ['required', 'in:M,F'],
            'lieu_naissance' => ['nullable', 'string', 'max:100'],
            'date_naissance' => ['nullable', 'date'],
            'etat_civil' => ['nullable', 'string', 'max:20'],
            'nationalite' => ['nullable', 'string', 'max:50'],
            'nom_pere' => ['nullable', 'string', 'max:100'],
            'nom_mere' => ['nullable', 'string', 'max:100'],
            'province_origine' => ['nullable', 'string', 'max:50'],
            'adresse' => ['nullable', 'string', 'max:150'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'diplome_acces' => ['nullable', 'string', 'max:100'],
            'pourcentage_diplome' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'section' => ['nullable', 'string', 'max:50'],
            'option_etude' => ['nullable', 'string', 'max:50'],
            'lieu_delivrance' => ['nullable', 'string', 'max:100'],
            'date_delivrance' => ['nullable', 'date'],
            'ecole_provenance' => ['nullable', 'string', 'max:150'],
            'code_ecole' => ['nullable', 'string', 'max:20'],
            'province_ecole' => ['nullable', 'string', 'max:50'],
            'mention' => ['nullable', 'string', 'max:30'],
            'pourcentage_bulletin' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'id_promotion' => ['required', 'exists:promotion,id_promotion'],
        ]);
    }

    private function nextMatricule(): string
    {
        $last = Etudiant::query()
            ->where('matricule', 'like', 'ESU-%')
            ->orderByDesc('matricule')
            ->value('matricule');

        $numero = $last ? ((int) substr($last, -4)) + 1 : 1;

        return 'ESU-'.date('Y').'-'.str_pad((string) $numero, 4, '0', STR_PAD_LEFT);
    }

    private function formData(): array
    {
        return [
            'facultes' => Faculte::orderBy('nom_faculte')->get(),
            'promotions' => Promotion::with('faculte')->orderBy('nom_promotion')->get(),
        ];
    }
}
