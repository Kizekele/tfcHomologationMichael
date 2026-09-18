<?php

namespace App\Http\Controllers;

use App\Models\Inspecteur;
use App\Models\Mission;
use App\Models\Vacation;
use Illuminate\Http\Request;

class VacationController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->query('statut');
        $missionId = $request->integer('mission');
        $q = trim((string) $request->query('q', ''));

        $vacations = Vacation::with(['inspecteur', 'mission.faculte', 'mission.equipe'])
            ->when($statut === 'payees', fn ($query) => $query->payees())
            ->when($statut === 'impayees', fn ($query) => $query->impayees())
            ->when($missionId, fn ($query) => $query->where('id_mission', $missionId))
            ->when($q, fn ($query) => $query->whereHas('inspecteur', fn ($i) => $i->where('nom_inspecteur', 'like', "%{$q}%")))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $totaux = [
            'total' => Vacation::sum('montant'),
            'paye' => Vacation::payees()->sum('montant'),
            'impaye' => Vacation::impayees()->sum('montant'),
        ];

        return view('vacations.index', [
            'vacations' => $vacations,
            'missions' => Mission::with('faculte')->orderByDesc('date_lettre')->get(),
            'totaux' => $totaux,
            'statut' => $statut,
            'missionId' => $missionId,
            'q' => $q,
        ]);
    }

    public function create()
    {
        return view('vacations.create', [
            'missions' => Mission::with('faculte')->orderByDesc('date_lettre')->get(),
            'inspecteurs' => Inspecteur::orderBy('nom_inspecteur')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'montant' => ['required', 'numeric', 'min:0'],
            'date_paiement' => ['nullable', 'date'],
            'matricule_inspecteur' => ['required', 'exists:inspecteur,matricule_inspecteur'],
            'id_mission' => ['required', 'exists:mission,id_mission'],
        ]);

        Vacation::create($data);

        return redirect()->route('vacations.index')->with('success', 'Vacation enregistrée avec succès.');
    }

    public function payer(Vacation $vacation)
    {
        $vacation->update(['date_paiement' => now()->toDateString()]);

        return back()->with('success', 'Vacation marquée comme payée.');
    }

    public function destroy(Vacation $vacation)
    {
        $vacation->delete();

        return redirect()->route('vacations.index')->with('success', 'Vacation supprimée.');
    }
}
