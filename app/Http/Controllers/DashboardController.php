<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcad;
use App\Models\Equipe;
use App\Models\Etudiant;
use App\Models\Faculte;
use App\Models\Homologuer;
use App\Models\Inspecteur;
use App\Models\Mission;
use App\Models\Promotion;
use App\Models\Vacation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now();

        $currentYear = AnneeAcad::orderByDesc('id_anneeacad')->first();
        $previousYear = $currentYear
            ? AnneeAcad::where('id_anneeacad', '!=', $currentYear->id_anneeacad)->orderByDesc('id_anneeacad')->first()
            : null;

        $totalStudents = Etudiant::count();
        $currentCount = $this->studentsForYear($currentYear);
        $previousCount = $previousYear ? $this->studentsForYear($previousYear) : 0;
        $growth = $previousCount > 0
            ? round(($currentCount - $previousCount) / $previousCount * 100, 1)
            : 0.0;

        $activeMissions = Mission::whereDate('periode_fin', '>=', $today)->count();
        $missionsEnCours = Mission::whereDate('periode_debut', '<=', $today)
            ->whereDate('periode_fin', '>=', $today)
            ->count();

        $activeEquipeIds = Mission::whereDate('periode_fin', '>=', $today)->pluck('id_equipe')->unique();
        $engagedInspectors = $activeEquipeIds->isEmpty()
            ? 0
            : DB::table('composer')->whereIn('id_equipe', $activeEquipeIds)->distinct()->count('matricule_inspecteur');
        $missionsFacultes = Mission::distinct()->count('id_faculte');

        $favorable = Homologuer::where('avis', 'Favorable')->count();
        $defavorable = Homologuer::where('avis', 'Défavorable')->count();
        $totalAvis = $favorable + $defavorable;
        $homologationRate = $totalStudents > 0 ? round($favorable / $totalStudents * 100, 1) : 0.0;
        $enAttente = max($totalStudents - $totalAvis, 0);

        $coutTotal = (float) Vacation::sum('montant');
        $paye = (float) Vacation::whereNotNull('date_paiement')->sum('montant');
        $reste = $coutTotal - $paye;
        $paidPct = $coutTotal > 0 ? round($paye / $coutTotal * 100) : 0;

        $facultes = Faculte::withCount('etudiants')->get()->map(function (Faculte $faculte) use ($totalStudents) {
            $total = (int) $faculte->etudiants_count;

            return [
                'nom' => $faculte->nom_faculte,
                'total' => $total,
                'pct' => $totalStudents > 0 ? round($total / $totalStudents * 100, 1) : 0.0,
            ];
        })->values();

        $recent = Etudiant::with(['promotion.faculte'])
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $stats = [
            'totalStudents' => $totalStudents,
            'currentCount' => $currentCount,
            'previousCount' => $previousCount,
            'growth' => $growth,
            'currentYearLabel' => $currentYear?->libelle ?? '2025-2026',
            'previousYearLabel' => $this->previousYearLabel($currentYear?->libelle ?? '2025-2026'),
            'activeMissions' => $activeMissions,
            'missionsEnCours' => $missionsEnCours,
            'engagedInspectors' => $engagedInspectors,
            'missionsFacultes' => $missionsFacultes,
            'favorable' => $favorable,
            'defavorable' => $defavorable,
            'totalAvis' => $totalAvis,
            'homologationRate' => $homologationRate,
            'enAttente' => $enAttente,
            'coutTotal' => $coutTotal,
            'payeVacations' => $paye,
            'resteVacations' => $reste,
            'paidPct' => $paidPct,
            'facultes' => $facultes,
            'recent' => $recent,
            'facultesCount' => Faculte::count(),
            'nouveauxMois' => Etudiant::where('created_at', '>=', $today->copy()->startOfMonth())->count(),
            'inspecteursCount' => Inspecteur::count(),
            'inspecteursDispo' => max(Inspecteur::count() - $engagedInspectors, 0),
            'equipesCount' => Equipe::count(),
        ];

        return view('dashboard', $stats);
    }

    private function previousYearLabel(string $label): string
    {
        $parts = explode('-', $label);

        if (count($parts) !== 2) {
            return $label;
        }

        return ((int) $parts[0] - 1).'-'.((int) $parts[1] - 1);
    }

    private function studentsForYear(?AnneeAcad $year): int
    {
        if (! $year) {
            return 0;
        }

        $promotionIds = DB::table('concerner')
            ->where('id_anneeacad', $year->id_anneeacad)
            ->pluck('id_promotion');

        if ($promotionIds->isEmpty()) {
            return 0;
        }

        return Etudiant::whereIn('id_promotion', $promotionIds)->count();
    }
}