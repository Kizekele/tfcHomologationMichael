<?php

namespace App\Providers;

use App\Models\AnneeAcad;
use App\Models\Etudiant;
use App\Models\Homologuer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $moisFr = [1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'];
        $joursFr = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
        $maintenant = now();

        View::share('fmt', fn ($n) => number_format((float) $n, 0, '.', ','));
        View::share('money', fn ($n) => number_format((float) $n, 0, '.', ',').' FC');
        View::share('palette', [['#7f1d1d', '#991b1b'], ['#9f1239', '#be123c'], ['#b91c1c', '#dc2626']]);
        View::share('foreground', ['#7f1d1d', '#9f1239', '#b91c1c']);
        View::share('chipPalette', ['bg-amber-50 text-amber-700 border-amber-100', 'bg-emerald-50 text-emerald-700 border-emerald-100', 'bg-sky-50 text-sky-700 border-sky-100', 'bg-indigo-50 text-indigo-700 border-indigo-100', 'bg-rose-50 text-rose-700 border-rose-100', 'bg-teal-50 text-teal-700 border-teal-100']);
        View::share('dateFr', ucfirst($joursFr[$maintenant->dayOfWeek]).' '.$maintenant->day.' '.$moisFr[$maintenant->month].' '.$maintenant->year);

        View::composer('layouts.app', function ($view) {
            $nombreEtudiants = Etudiant::count();
            $nombreAvis = Homologuer::count();

            $view->with([
                'layoutUser' => Auth::guard('agent')->user(),
                'layoutAnnee' => AnneeAcad::orderByDesc('id_anneeacad')->value('libelle') ?? '2025-2026',
                'layoutEnAttente' => max($nombreEtudiants - $nombreAvis, 0),
                'layoutNotifications' => [],
            ]);
        });
    }
}
