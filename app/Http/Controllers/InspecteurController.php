<?php

namespace App\Http\Controllers;

use App\Models\Inspecteur;
use Illuminate\Http\Request;

class InspecteurController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $inspecteurs = Inspecteur::withCount('vacations')
            ->with('equipes')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nom_inspecteur', 'like', "%{$q}%")
                        ->orWhere('matricule_inspecteur', 'like', "%{$q}%");
                });
            })
            ->orderBy('nom_inspecteur')
            ->paginate(15)
            ->withQueryString();

        return view('inspecteurs.index', compact('inspecteurs', 'q'));
    }

    public function create()
    {
        return view('inspecteurs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricule_inspecteur' => ['required', 'string', 'max:20', 'unique:inspecteur,matricule_inspecteur'],
            'nom_inspecteur' => ['required', 'string', 'max:100'],
            'fonction_inspecteur' => ['nullable', 'string', 'max:100'],
            'telephone_inspecteur' => ['nullable', 'string', 'max:20'],
        ]);

        Inspecteur::create($data);

        return redirect()->route('inspecteurs.index')->with('success', 'Inspecteur ajouté avec succès.');
    }

    public function edit(Inspecteur $inspecteur)
    {
        return view('inspecteurs.edit', compact('inspecteur'));
    }

    public function update(Request $request, Inspecteur $inspecteur)
    {
        $data = $request->validate([
            'matricule_inspecteur' => ['required', 'string', 'max:20', 'unique:inspecteur,matricule_inspecteur,'.$inspecteur->matricule_inspecteur.',matricule_inspecteur'],
            'nom_inspecteur' => ['required', 'string', 'max:100'],
            'fonction_inspecteur' => ['nullable', 'string', 'max:100'],
            'telephone_inspecteur' => ['nullable', 'string', 'max:20'],
        ]);

        $inspecteur->update($data);

        return redirect()->route('inspecteurs.index')->with('success', 'Inspecteur mis à jour.');
    }

    public function destroy(Inspecteur $inspecteur)
    {
        if ($inspecteur->vacations()->exists() || $inspecteur->equipes()->exists()) {
            return back()->with('error', 'Suppression impossible : cet inspecteur est affecté à une équipe ou possède des vacations.');
        }

        $inspecteur->delete();

        return redirect()->route('inspecteurs.index')->with('success', 'Inspecteur supprimé.');
    }
}
