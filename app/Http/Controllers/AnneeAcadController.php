<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcad;
use App\Models\Concerned;
use Illuminate\Http\Request;

class AnneeAcadController extends Controller
{
    public function index()
    {
        $annees = AnneeAcad::withCount('missions')
            ->withCount(['promotions'])
            ->orderByDesc('libelle')
            ->get();

        return view('annees.index', compact('annees'));
    }

    public function create()
    {
        return view('annees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => ['required', 'string', 'max:20', 'unique:anneeacad,libelle'],
        ]);

        AnneeAcad::create($data);

        return redirect()->route('annees.index')->with('success', 'Année académique ajoutée.');
    }

    public function edit(AnneeAcad $annee)
    {
        return view('annees.edit', compact('annee'));
    }

    public function update(Request $request, AnneeAcad $annee)
    {
        $data = $request->validate([
            'libelle' => ['required', 'string', 'max:20', 'unique:anneeacad,libelle,'.$annee->id_anneeacad.',id_anneeacad'],
        ]);

        $annee->update($data);

        return redirect()->route('annees.index')->with('success', 'Année académique mise à jour.');
    }

    public function destroy(AnneeAcad $annee)
    {
        if ($annee->missions()->exists()) {
            return back()->with('error', 'Suppression impossible : des missions sont rattachées à cette année.');
        }

        Concerned::where('id_anneeacad', $annee->id_anneeacad)->delete();
        $annee->delete();

        return redirect()->route('annees.index')->with('success', 'Année académique supprimée.');
    }
}
