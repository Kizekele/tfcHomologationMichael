<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AnneeAcadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\FaculteController;
use App\Http\Controllers\HomologationController;
use App\Http\Controllers\InspecteurController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\VacationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:agent')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:agent')->group(function () {
    Route::redirect('/', '/dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('facultes', FaculteController::class)->except('show');
    Route::resource('promotions', PromotionController::class)->except('show');
    Route::resource('annees', AnneeAcadController::class)->except('show');

    Route::get('etudiants/en-attente', [EtudiantController::class, 'enAttente'])->name('etudiants.en_attente');
    Route::resource('etudiants', EtudiantController::class);

    Route::resource('missions', MissionController::class);
    Route::resource('equipes', EquipeController::class)->except('show');
    Route::resource('inspecteurs', InspecteurController::class)->except('show');

    Route::get('homologation', [HomologationController::class, 'index'])->name('homologation.index');
    Route::post('homologation', [HomologationController::class, 'store'])->name('homologation.store');
    Route::get('homologation/rapports', [HomologationController::class, 'rapports'])->name('homologation.rapports');
    Route::delete('homologation/{matricule}/{mission}', [HomologationController::class, 'destroy'])->name('homologation.destroy');

    Route::get('vacations', [VacationController::class, 'index'])->name('vacations.index');
    Route::get('vacations/create', [VacationController::class, 'create'])->name('vacations.create');
    Route::post('vacations', [VacationController::class, 'store'])->name('vacations.store');
    Route::post('vacations/{vacation}/payer', [VacationController::class, 'payer'])->name('vacations.payer');
    Route::delete('vacations/{vacation}', [VacationController::class, 'destroy'])->name('vacations.destroy');

    Route::get('configuration', [ConfigurationController::class, 'index'])->name('configuration.index');
    Route::resource('configuration/agents', AgentController::class)->names('configuration.agents')->except('show');
});
