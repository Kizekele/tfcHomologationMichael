<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Inspecteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipeController extends Controller
{
    public function index()
    {
        $equipes = Equipe::with('inspecteurs')
            ->withCount('missions')
            ->orderBy('id_equipe')
            ->get();

        return view('equipes.index', compact('equipes'));
    }

    public function create()
    {
        return view('equipes.create', [
            'inspecteurs' => Inspecteur::orderBy('nom_inspecteur')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'moyen_transport' => ['nullable', 'string', 'max:50'],
            'inspecteurs' => ['array'],
            'inspecteurs.*' => ['exists:inspecteur,matricule_inspecteur'],
            'roles' => ['array'],
        ]);

        $equipe = Equipe::create(['moyen_transport' => $data['moyen_transport'] ?? null]);

        foreach ($data['inspecteurs'] ?? [] as $matricule) {
            DB::table('composer')->insert([
                'matricule_inspecteur' => $matricule,
                'id_equipe' => $equipe->id_equipe,
                'role' => $request->input("roles.{$matricule}") ?: 'Membre',
            ]);
        }

        return redirect()->route('equipes.index')->with('success', 'Équipe créée avec succès.');
    }

    public function edit(Equipe $equipe)
    {
        $equipe->load('inspecteurs');

        return view('equipes.edit', [
            'equipe' => $equipe,
            'inspecteurs' => Inspecteur::orderBy('nom_inspecteur')->get(),
        ]);
    }

    public function update(Request $request, Equipe $equipe)
    {
        $data = $request->validate([
            'moyen_transport' => ['nullable', 'string', 'max:50'],
            'inspecteurs' => ['array'],
            'inspecteurs.*' => ['exists:inspecteur,matricule_inspecteur'],
            'roles' => ['array'],
        ]);

        $equipe->update(['moyen_transport' => $data['moyen_transport'] ?? null]);

        DB::table('composer')->where('id_equipe', $equipe->id_equipe)->delete();

        foreach ($data['inspecteurs'] ?? [] as $matricule) {
            DB::table('composer')->insert([
                'matricule_inspecteur' => $matricule,
                'id_equipe' => $equipe->id_equipe,
                'role' => $request->input("roles.{$matricule}") ?: 'Membre',
            ]);
        }

        return redirect()->route('equipes.index')->with('success', 'Équipe mise à jour.');
    }

    public function destroy(Equipe $equipe)
    {
        if ($equipe->missions()->exists()) {
            return back()->with('error', 'Suppression impossible : cette équipe est affectée à des missions.');
        }

        DB::table('composer')->where('id_equipe', $equipe->id_equipe)->delete();
        $equipe->delete();

        return redirect()->route('equipes.index')->with('success', 'Équipe supprimée.');
    }
}
