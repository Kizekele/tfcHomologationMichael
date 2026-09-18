<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AnneeAcad;
use App\Models\Equipe;
use App\Models\Etudiant;
use App\Models\Faculte;
use App\Models\Homologuer;
use App\Models\Inspecteur;
use App\Models\Mission;
use App\Models\Promotion;
use App\Models\Vacation;

class ConfigurationController extends Controller
{
    public function index()
    {
        $stats = [
            'facultes' => Faculte::count(),
            'promotions' => Promotion::count(),
            'annees' => AnneeAcad::count(),
            'etudiants' => Etudiant::count(),
            'agents' => Agent::count(),
            'inspecteurs' => Inspecteur::count(),
            'equipes' => Equipe::count(),
            'missions' => Mission::count(),
            'vacations' => Vacation::count(),
            'homologations' => Homologuer::count(),
        ];

        return view('configuration.index', [
            'stats' => $stats,
            'annees' => AnneeAcad::orderByDesc('libelle')->get(),
            'agents' => Agent::orderBy('nom_agent')->get(),
        ]);
    }
}
