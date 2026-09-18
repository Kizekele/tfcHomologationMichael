<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcad;
use App\Models\Faculte;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $faculteId = $request->integer('faculte');

        $promotions = Promotion::with('faculte')
            ->with('annees')
            ->withCount('etudiants')
            ->when($faculteId, fn ($q) => $q->where('id_faculte', $faculteId))
            ->orderBy('nom_promotion')
            ->get();

        $facultes = Faculte::orderBy('nom_faculte')->get();

        return view('promotions.index', compact('promotions', 'facultes', 'faculteId'));
    }

    public function create()
    {
        return view('promotions.create', [
            'facultes' => Faculte::orderBy('nom_faculte')->get(),
            'annees' => AnneeAcad::orderByDesc('libelle')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_promotion' => ['required', 'string', 'max:20'],
            'cycle' => ['nullable', 'string', 'max:20'],
            'id_faculte' => ['required', 'exists:faculte,id_faculte'],
            'annees' => ['array'],
            'annees.*' => ['exists:anneeacad,id_anneeacad'],
        ]);

        $promotion = Promotion::create([
            'nom_promotion' => $data['nom_promotion'],
            'cycle' => $data['cycle'] ?? null,
            'id_faculte' => $data['id_faculte'],
        ]);

        $promotion->annees()->sync($data['annees'] ?? []);

        return redirect()->route('promotions.index')->with('success', 'Promotion ajoutée avec succès.');
    }

    public function edit(Promotion $promotion)
    {
        return view('promotions.edit', [
            'promotion' => $promotion,
            'facultes' => Faculte::orderBy('nom_faculte')->get(),
            'annees' => AnneeAcad::orderByDesc('libelle')->get(),
        ]);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'nom_promotion' => ['required', 'string', 'max:20'],
            'cycle' => ['nullable', 'string', 'max:20'],
            'id_faculte' => ['required', 'exists:faculte,id_faculte'],
            'annees' => ['array'],
            'annees.*' => ['exists:anneeacad,id_anneeacad'],
        ]);

        $promotion->update([
            'nom_promotion' => $data['nom_promotion'],
            'cycle' => $data['cycle'] ?? null,
            'id_faculte' => $data['id_faculte'],
        ]);

        $promotion->annees()->sync($data['annees'] ?? []);

        return redirect()->route('promotions.index')->with('success', 'Promotion mise à jour.');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->etudiants()->exists()) {
            return back()->with('error', 'Suppression impossible : des étudiants sont inscrits dans cette promotion.');
        }

        $promotion->annees()->detach();
        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', 'Promotion supprimée.');
    }
}
