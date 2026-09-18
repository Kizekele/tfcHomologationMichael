<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use Illuminate\Http\Request;

class FaculteController extends Controller
{
    public function index()
    {
        $facultes = Faculte::withCount(['promotions', 'etudiants'])
            ->orderBy('nom_faculte')
            ->get();

        return view('facultes.index', compact('facultes'));
    }

    public function create()
    {
        return view('facultes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_faculte' => ['required', 'string', 'max:150'],
        ]);

        Faculte::create($data);

        return redirect()->route('facultes.index')->with('success', 'Faculté ajoutée avec succès.');
    }

    public function edit(Faculte $faculte)
    {
        return view('facultes.edit', compact('faculte'));
    }

    public function update(Request $request, Faculte $faculte)
    {
        $data = $request->validate([
            'nom_faculte' => ['required', 'string', 'max:150'],
        ]);

        $faculte->update($data);

        return redirect()->route('facultes.index')->with('success', 'Faculté mise à jour.');
    }

    public function destroy(Faculte $faculte)
    {
        if ($faculte->promotions()->exists()) {
            return back()->with('error', 'Suppression impossible : cette faculté contient des promotions.');
        }

        $faculte->delete();

        return redirect()->route('facultes.index')->with('success', 'Faculté supprimée.');
    }
}
