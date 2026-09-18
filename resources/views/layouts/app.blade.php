<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Tableau de bord') - ESU</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --sidebar-w: 18rem;
                --sidebar-w-min: 5.5rem;
                --bordeaux-900: #7f1d1d;
                --bordeaux-800: #991b1b;
                --bordeaux-700: #b91c1c;
                --accent: #f59e0b;
            }

            html, body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                -webkit-font-smoothing: antialiased;
            }

            ::selection {
                background: #fbbf24;
                color: #1e293b;
            }

            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 999px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            .app-shell {
                display: flex;
                min-height: 100vh;
            }

            .sidebar {
                width: var(--sidebar-w);
                transition: width .45s cubic-bezier(.22, 1, .36, 1);
            }
            @media (max-width: 1023.98px) {
                .sidebar {
                    position: fixed;
                    inset: 0 auto 0 0;
                    z-index: 60;
                    transform: translateX(-100%);
                    transition: transform .45s cubic-bezier(.22, 1, .36, 1);
                    width: var(--sidebar-w) !important;
                }
                body.mobile-sidebar-open .sidebar {
                    transform: translateX(0);
                }
            }
            @media (min-width: 1024px) {
                .sidebar {
                    position: sticky;
                    top: 0;
                    height: 100vh;
                    flex-shrink: 0;
                }
                body.sidebar-collapsed .sidebar {
                    width: var(--sidebar-w-min);
                }
            }

            .sidebar-inner {
                display: flex;
                flex-direction: column;
                height: 100%;
                overflow: hidden;
            }
            .sidebar-nav {
                flex: 1;
                overflow-y: auto;
                overflow-x: hidden;
            }

            .menu-label,
            .logo-text,
            .sidebar .s-chip,
            .sidebar .collapse-hint {
                transition: opacity .25s ease, transform .35s ease, width .35s ease;
            }
            @media (min-width: 1024px) {
                body.sidebar-collapsed .menu-label,
                body.sidebar-collapsed .logo-text,
                body.sidebar-collapsed .s-chip,
                body.sidebar-collapsed .collapse-hint {
                    opacity: 0;
                    width: 0;
                    pointer-events: none;
                }
                body.sidebar-collapsed .avatar-ring {
                    display: none;
                }
                body.sidebar-collapsed .nav-group .nav-sub {
                    display: none;
                }
            }

            .nav-group > .nav-sub {
                max-height: 0;
                overflow: hidden;
                transition: max-height .5s cubic-bezier(.22, 1, .36, 1);
            }
            .nav-group.open > .nav-sub {
                max-height: 420px;
            }
            .nav-group.open > .nav-toggle .nav-chevron {
                transform: rotate(180deg);
            }
            .nav-chevron {
                transition: transform .4s cubic-bezier(.22, 1, .36, 1);
            }

            .nav-link {
                position: relative;
                transition: background .3s ease, color .3s ease, transform .2s ease, box-shadow .3s ease;
            }
            .nav-link::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                width: 3px;
                height: 0;
                border-radius: 0 3px 3px 0;
                background: var(--accent);
                transform: translateY(-50%);
                transition: height .35s cubic-bezier(.22, 1, .36, 1), box-shadow .3s;
            }
            .nav-link:hover::before {
                height: 50%;
            }
            .nav-link.active {
                background: linear-gradient(90deg, rgba(127, 29, 29, .95), rgba(153, 27, 27, .75));
                color: #fff;
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .06);
            }
            .nav-link.active::before {
                height: 60%;
                box-shadow: 0 0 12px 2px rgba(245, 158, 11, .55);
            }
            .nav-link.active .nav-icon {
                filter: drop-shadow(0 0 6px rgba(245, 158, 11, .4));
            }

            .nav-dot {
                width: 5px;
                height: 5px;
                border-radius: 999px;
                background: #64748b;
                transition: background .3s, transform .3s, box-shadow .3s;
            }
            .nav-sub-link:hover .nav-dot {
                background: #fbbf24;
                transform: scale(1.4);
                box-shadow: 0 0 8px rgba(245, 158, 11, .6);
            }

            .page-bg-blob {
                position: fixed;
                border-radius: 9999px;
                filter: blur(90px);
                pointer-events: none;
                z-index: 0;
                opacity: .5;
                animation: floatY 14s ease-in-out infinite;
            }
            .page-bg-blob.b1 {
                width: 480px;
                height: 480px;
                right: -160px;
                top: -120px;
                background: radial-gradient(circle, rgba(153, 27, 27, .10), transparent 70%);
            }
            .page-bg-blob.b2 {
                width: 420px;
                height: 420px;
                left: -140px;
                bottom: -140px;
                background: radial-gradient(circle, rgba(245, 158, 11, .09), transparent 70%);
                animation-delay: -6s;
            }

            @keyframes floatY {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-22px) rotate(6deg); }
            }

            .reveal {
                opacity: 0;
                transform: translateY(26px);
                transition: opacity .8s cubic-bezier(.22, 1, .36, 1), transform .8s cubic-bezier(.22, 1, .36, 1), box-shadow .4s ease, border-color .3s;
            }
            .reveal.is-in {
                opacity: 1;
                transform: none;
            }

            @keyframes rowIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: none; }
            }
            .t-row {
                opacity: 0;
                animation: rowIn .7s cubic-bezier(.22, 1, .36, 1) forwards;
            }

            .h-bar-fill {
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 1.4s cubic-bezier(.22, 1, .36, 1);
            }
            .is-in .h-bar-fill {
                transform: scaleX(1);
            }

            .spark-line {
                stroke-dasharray: 100;
                stroke-dashoffset: 100;
            }
            .spark-area {
                opacity: 0;
                transition: opacity .9s ease 1.1s;
            }
            .is-in .spark-line {
                animation: drawLine 1.8s cubic-bezier(.22, 1, .36, 1) forwards .5s;
            }
            .is-in .spark-area {
                opacity: .22;
            }
            @keyframes drawLine {
                to { stroke-dashoffset: 0; }
            }

            .ring-track {
                stroke: #f1f5f9;
            }
            .ring-fg {
                stroke-dasharray: 100;
                stroke-dashoffset: 100;
                transition: stroke-dashoffset 2s cubic-bezier(.22, 1, .36, 1) .4s;
                transform: rotate(-90deg);
                transform-origin: center;
            }
            .is-in .ring-fg {
                stroke-dashoffset: var(--ring-target);
            }

            .seg {
                stroke-dasharray: 0 100;
                transform: rotate(-90deg);
                transform-origin: center;
                transition: stroke-dasharray 1.5s cubic-bezier(.22, 1, .36, 1), stroke-dashoffset 1.5s cubic-bezier(.22, 1, .36, 1);
            }
            .is-in .seg {
                stroke-dasharray: var(--dash) calc(100 - var(--dash));
                stroke-dashoffset: var(--off);
            }

            .bell-ring {
                animation: bellRing 1.6s ease-in-out;
            }
            @keyframes bellRing {
                0%, 100% { transform: rotate(0); }
                10% { transform: rotate(14deg); }
                20% { transform: rotate(-12deg); }
                30% { transform: rotate(10deg); }
                40% { transform: rotate(-8deg); }
                50% { transform: rotate(5deg); }
                60% { transform: rotate(-3deg); }
                70% { transform: rotate(0deg); }
            }

            .pulse-dot::after {
                content: none;
            }

            @keyframes shimmer {
                0% { background-position: -400px 0; }
                100% { background-position: 400px 0; }
            }
            .shine {
                position: relative;
                overflow: hidden;
            }
            .shine::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(110deg, transparent 30%, rgba(255, 255, 255, .35) 50%, transparent 70%);
                background-size: 400px 100%;
                animation: shimmer 3.2s linear infinite;
                pointer-events: none;
            }

            .card-hover {
                transition: transform .45s cubic-bezier(.22, 1, .36, 1), box-shadow .45s ease, border-color .3s;
            }
            .card-hover:hover {
                transform: translateY(-6px);
                box-shadow: 0 18px 40px -16px rgba(15, 23, 42, .18);
            }

            .dropdown-panel {
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px) scale(.98);
                transition: opacity .3s ease, transform .35s cubic-bezier(.22, 1, .36, 1), visibility .3s;
                transform-origin: top;
            }
            .dropdown.open .dropdown-panel {
                opacity: 1;
                visibility: visible;
                transform: none;
            }

            .search-wrap:focus-within {
                box-shadow: 0 0 0 3px rgba(127, 29, 29, .12), 0 10px 24px -12px rgba(15, 23, 42, .25);
            }

            @keyframes slideDown {
                from { opacity: 0; transform: translateY(-8px); }
                to { opacity: 1; transform: none; }
            }
            .mobile-search-panel {
                display: none;
                animation: slideDown .35s cubic-bezier(.22, 1, .36, 1);
            }
            .mobile-search-panel.open {
                display: block;
            }

            .stat-tile {
                position: relative;
                overflow: hidden;
            }
            .stat-tile .tile-glow {
                position: absolute;
                width: 120px;
                height: 120px;
                right: -40px;
                top: -40px;
                border-radius: 999px;
                opacity: 0;
                transition: opacity .5s ease, transform .5s ease;
                transform: scale(.5);
            }
            .stat-tile:hover .tile-glow {
                opacity: .18;
                transform: scale(1);
            }

            @keyframes ticker {
                0% { transform: translateY(0); }
                25% { transform: translateY(-33.333%); }
                50% { transform: translateY(-66.666%); }
                75% { transform: translateY(-33.333%); }
                100% { transform: translateY(0); }
            }
            .mission-ticker {
                animation: ticker 6s ease-in-out infinite;
            }

            /* ---------- Écran de chargement ---------- */
            .chargement {
                position: fixed;
                inset: 0;
                z-index: 300;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(248, 250, 252, .75);
                backdrop-filter: blur(3px);
                -webkit-backdrop-filter: blur(3px);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity .25s ease, visibility .25s ease;
            }
            .chargement.is-active {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }
            .chargement__box {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: .9rem;
            }
            .chargement__boule {
                display: block;
                width: 3.25rem;
                height: 3.25rem;
                border-radius: 999px;
                border: 4px solid rgba(153, 27, 27, .18);
                border-top-color: #991b1b;
                animation: chargementSpin .8s linear infinite;
            }
            .chargement__txt {
                font-size: .85rem;
                font-weight: 700;
                letter-spacing: .02em;
                color: #7f1d1d;
            }
            @keyframes chargementSpin {
                to { transform: rotate(360deg); }
            }
            @media (prefers-reduced-motion: reduce) {
                .chargement__boule { animation-duration: 2s; }
            }
        </style>
    </head>
    <body class="bg-[#f1f5f9] text-slate-800 antialiased">
        <div id="chargement" class="chargement is-active" aria-hidden="false" role="status" aria-live="polite" aria-label="Chargement en cours">
            <div class="chargement__box">
                <span class="chargement__boule"></span>
                <p class="chargement__txt">Chargement…</p>
            </div>
        </div>
        <noscript><style>.chargement { display: none !important; }</style></noscript>

        <div class="page-bg-blob b1"></div>
        <div class="page-bg-blob b2"></div>

        <div class="app-shell relative z-10">

            <div id="sidebar-overlay" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

            <aside class="sidebar" aria-label="Navigation principale">
                <div class="sidebar-inner bg-gradient-to-b from-[#182335] via-[#1e293b] to-[#1a2436] text-slate-300">
                    <div class="relative h-1.5 shrink-0 bg-gradient-to-r from-[#7f1d1d] via-[#b91c1c] to-[#f59e0b]"></div>

                    <div class="flex items-center gap-3 px-4 lg:px-5 pt-5 pb-4 shrink-0">
                        <div class="relative shrink-0">
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-slate-900 shadow-lg shadow-amber-500/30">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                </svg>
                            </div>
                            <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-emerald-400 border-2 border-[#1e293b] pulse-dot"></span>
                        </div>
                        <div class="leading-tight">
                            <p class="logo-text font-extrabold text-white text-[15px] tracking-tight whitespace-nowrap">TABLEAU DE BORD</p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <p class="logo-text text-[11px] font-semibold tracking-[.22em] text-amber-400/90 whitespace-nowrap">- ESU -</p>
                                <span class="s-chip text-[9px] font-bold px-1.5 py-px rounded bg-white/10 text-slate-300 border border-white/10">UOO</span>
                            </div>
                        </div>
                    </div>

                    <p class="px-4 lg:px-6 mt-1 mb-2 text-[10px] font-bold tracking-[.18em] uppercase text-slate-500 whitespace-nowrap">Menu principal</p>

                    @php
                        $linkClass = fn (bool $active) => 'nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium '.($active ? 'active bg-gradient-to-r from-[#7f1d1d] to-[#991b1b] text-white' : 'text-slate-300 hover:text-white hover:bg-white/[.06]');
                        $subClass = fn (bool $active) => 'nav-sub-link group flex items-center gap-3 py-2 rounded-lg text-[13px] '.($active ? 'text-amber-300 font-semibold' : 'text-slate-400 hover:text-amber-300');
                        $toggleClass = fn (bool $active) => 'nav-toggle nav-link w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium '.($active ? 'text-white' : 'text-slate-300 hover:text-white hover:bg-white/[.06]');
                    @endphp
                    <nav class="sidebar-nav px-3 pb-3 space-y-1">

                        <a href="{{ route('dashboard') }}" class="{{ $linkClass(request()->routeIs('dashboard')) }}">
                            <svg class="nav-icon w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                            </svg>
                            <span class="menu-label">Tableau de bord</span>
                        </a>

                        @php $acadActive = request()->routeIs('facultes.*', 'promotions.*', 'annees.*'); @endphp
                        <div class="nav-group {{ $acadActive ? 'open' : '' }}">
                            <button type="button" class="{{ $toggleClass($acadActive) }}">
                                <svg class="nav-icon w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                <span class="menu-label flex-1 text-left">Paramètres Académiques</span>
                                <svg class="nav-chevron w-4 h-4 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="nav-sub pl-[2.35rem]">
                                <a href="{{ route('facultes.index') }}" class="{{ $subClass(request()->routeIs('facultes.*')) }}">
                                    <span class="nav-dot"></span>Facultés
                                </a>
                                <a href="{{ route('promotions.index') }}" class="{{ $subClass(request()->routeIs('promotions.*')) }}">
                                    <span class="nav-dot"></span>Promotions
                                </a>
                                <a href="{{ route('annees.index') }}" class="{{ $subClass(request()->routeIs('annees.*')) }}">
                                    <span class="nav-dot"></span>Années académiques
                                </a>
                            </div>
                        </div>

                        @php $etuActive = request()->routeIs('etudiants.*'); @endphp
                        <div class="nav-group {{ $etuActive ? 'open' : '' }}">
                            <button type="button" class="{{ $toggleClass($etuActive) }}">
                                <svg class="nav-icon w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                <span class="menu-label flex-1 text-left">Gestion des Étudiants</span>
                                <svg class="nav-chevron w-4 h-4 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="nav-sub pl-[2.35rem]">
                                <a href="{{ route('etudiants.index') }}" class="{{ $subClass(request()->routeIs('etudiants.index', 'etudiants.show', 'etudiants.edit')) }}">
                                    <span class="nav-dot"></span>Liste des finalistes
                                </a>
                                <a href="{{ route('etudiants.create') }}" class="{{ $subClass(request()->routeIs('etudiants.create')) }}">
                                    <span class="nav-dot"></span>Ajouter un dossier
                                </a>
                                <a href="{{ route('etudiants.en_attente') }}" class="{{ $subClass(request()->routeIs('etudiants.en_attente')) }} justify-between">
                                    <span class="flex items-center gap-3"><span class="nav-dot"></span>Dossiers en attente</span>
                                    <span class="text-[10px] font-bold px-1.5 py-px rounded-full bg-amber-500/20 text-amber-300">{{ $fmt($layoutEnAttente) }}</span>
                                </a>
                            </div>
                        </div>

                        @php $missionActive = request()->routeIs('missions.*', 'equipes.*', 'inspecteurs.*'); @endphp
                        <div class="nav-group {{ $missionActive ? 'open' : '' }}">
                            <button type="button" class="{{ $toggleClass($missionActive) }}">
                                <svg class="nav-icon w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                                <span class="menu-label flex-1 text-left">Ordres de Mission</span>
                                <svg class="nav-chevron w-4 h-4 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="nav-sub pl-[2.35rem]">
                                <a href="{{ route('missions.create') }}" class="{{ $subClass(request()->routeIs('missions.create')) }}">
                                    <span class="nav-dot"></span>Créer un ordre
                                </a>
                                <a href="{{ route('missions.index') }}" class="{{ $subClass(request()->routeIs('missions.index', 'missions.show', 'missions.edit')) }}">
                                    <span class="nav-dot"></span>Consulter les ordres
                                </a>
                                <a href="{{ route('equipes.index') }}" class="{{ $subClass(request()->routeIs('equipes.*', 'inspecteurs.*')) }}">
                                    <span class="nav-dot"></span>Équipes d'inspection
                                </a>
                            </div>
                        </div>

                        @php $homoActive = request()->routeIs('homologation.*'); @endphp
                        <div class="nav-group {{ $homoActive ? 'open' : '' }}">
                            <button type="button" class="{{ $toggleClass($homoActive) }}">
                                <svg class="nav-icon w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="menu-label flex-1 text-left">Homologation</span>
                                <svg class="nav-chevron w-4 h-4 shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="nav-sub pl-[2.35rem]">
                                <a href="{{ route('homologation.index') }}" class="{{ $subClass(request()->routeIs('homologation.index')) }}">
                                    <span class="nav-dot"></span>Saisie des avis
                                </a>
                                <a href="{{ route('homologation.rapports') }}" class="{{ $subClass(request()->routeIs('homologation.rapports')) }}">
                                    <span class="nav-dot"></span>Rapports d'homologation
                                </a>
                            </div>
                        </div>

                        <div class="my-3 mx-3 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

                        <a href="{{ route('vacations.index') }}" class="{{ $linkClass(request()->routeIs('vacations.*')) }}">
                            <svg class="nav-icon w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                            <span class="menu-label">Finances &amp; Vacations</span>
                        </a>

                        <a href="{{ route('configuration.agents.index') }}" class="{{ $linkClass(request()->routeIs('configuration.*')) }}">
                            <svg class="nav-icon w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="menu-label">Configuration du Système</span>
                        </a>
                    </nav>

                    <div class="px-4 lg:px-5 py-4 shrink-0 border-t border-white/[.06]">
                        <div class="s-chip flex items-center gap-3 rounded-2xl bg-white/[.05] border border-white/[.07] px-3 py-3">
                            <svg class="w-5 h-5 text-white/50 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <div class="leading-tight">
                                <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Année académique</p>
                                <p class="text-sm font-bold text-white mt-0.5">{{ str_replace('-', ' - ', $layoutAnnee) }}</p>
                            </div>
                            <span class="ml-auto w-2 h-2 rounded-full bg-emerald-400 pulse-dot"></span>
                        </div>

                        <div class="flex items-center justify-between mt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] font-medium text-slate-400 hover:text-rose-300 hover:bg-rose-500/10 transition-colors">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    <span class="menu-label">Déconnexion</span>
                                </button>
                            </form>
                            <button type="button" id="collapse-btn" title="Réduire la barre latérale" class="collapse-hint w-8 h-8 rounded-xl flex items-center justify-center text-slate-500 hover:text-white hover:bg-white/10 transition-colors group">
                                <svg class="w-4 h-4 transition-transform duration-500 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="flex-1 min-w-0 flex flex-col">

                <header class="sticky top-0 z-40 bg-white/85 backdrop-blur-xl border-b border-slate-200/80 shadow-[0_1px_20px_-12px_rgba(15,23,42,.18)]">
                    <div class="flex items-center gap-3 px-4 lg:px-7 h-16 lg:h-[4.5rem]">

                        <button type="button" id="hamburger-btn" aria-label="Ouvrir le menu" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>

                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="lg:hidden relative">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-slate-900">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                    </svg>
                                </div>
                            </div>
                            <h1 class="hidden lg:block font-extrabold text-slate-800 text-lg tracking-tight whitespace-nowrap">TABLEAU DE BORD <span class="text-[#991b1b]">- ESU</span></h1>
                            <div class="lg:hidden">
                                <p class="font-extrabold text-slate-800 text-sm tracking-tight leading-tight">TABLEAU DE BORD</p>
                                <p class="text-[10px] font-semibold tracking-[.2em] text-[#991b1b]">ESU · UOO</p>
                            </div>
                        </div>

                        <div class="hidden md:block flex-1 max-w-xl mx-auto">
                            <form method="GET" action="{{ route('etudiants.index') }}" class="search-wrap relative group transition-shadow duration-300" role="search">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-[#991b1b] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                                <input type="text" name="q" placeholder="Rechercher un étudiant (matricule, nom, postnom ou prénom)" autocomplete="off" class="w-full h-11 pl-11.5 pr-12 rounded-2xl bg-slate-100/90 border border-transparent focus:bg-white focus:border-[#991b1b]/30 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition-all duration-300">
                                <kbd class="absolute right-3.5 top-1/2 -translate-y-1/2 hidden lg:inline-flex items-center px-1.5 h-6 rounded-md bg-white border border-slate-200 text-[10px] font-semibold text-slate-400 group-focus-within:opacity-0 transition-opacity">Ctrl K</kbd>
                            </form>
                        </div>

                        <button type="button" id="mobile-search-btn" aria-label="Rechercher" class="md:hidden ml-auto w-10 h-10 rounded-xl flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors">
                            <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>

                        <div class="flex items-center gap-1.5 md:gap-3 ml-auto md:ml-0">

                            <div class="relative dropdown" id="notif-dropdown">
                                <button type="button" class="notif-btn relative w-10 h-10 rounded-xl flex items-center justify-center text-slate-600 hover:bg-slate-100 hover:text-[#991b1b] transition-colors" aria-label="Notifications">
                                    <svg class="notif-bell w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                    <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 rounded-full bg-rose-500 ring-2 ring-white pulse-dot"></span>
                                </button>
                                <div class="dropdown-panel absolute right-0 mt-3 w-[20.5rem] max-w-[calc(100vw-2rem)] bg-white rounded-2xl border border-slate-200/80 shadow-2xl shadow-slate-900/10 overflow-hidden z-50">
                                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                                        <p class="font-bold text-slate-800 text-sm">Notifications</p>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#991b1b]/10 text-[#991b1b]">3 nouvelles</span>
                                    </div>
                                    <div class="divide-y divide-slate-50">
                                        <a href="#" class="flex gap-3 px-5 py-3.5 hover:bg-slate-50 transition-colors">
                                            <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-[13px] font-semibold text-slate-700">Avis favorable enregistré</p>
                                                <p class="text-xs text-slate-400 mt-0.5">Le dossier ES-2025-014 a été homologué.</p>
                                                <p class="text-[10px] text-slate-300 mt-1">Il y a 12 min</p>
                                            </div>
                                        </a>
                                        <a href="#" class="flex gap-3 px-5 py-3.5 hover:bg-slate-50 transition-colors">
                                            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-[13px] font-semibold text-slate-700">Mission assignée</p>
                                                <p class="text-xs text-slate-400 mt-0.5">Équipe 2 envoyée à l'Économie pour contrôle.</p>
                                                <p class="text-[10px] text-slate-300 mt-1">Il y a 1 h</p>
                                            </div>
                                        </a>
                                        <a href="#" class="flex gap-3 px-5 py-3.5 hover:bg-slate-50 transition-colors">
                                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-[13px] font-semibold text-slate-700">Vacation à rappeler</p>
                                                <p class="text-xs text-slate-400 mt-0.5">2 vacations en attente de paiement.</p>
                                                <p class="text-[10px] text-slate-300 mt-1">Hier, 16:00</p>
                                            </div>
                                        </a>
                                    </div>
                                    <button type="button" class="w-full py-3 text-xs font-bold text-[#991b1b] hover:bg-[#991b1b]/5 transition-colors border-t border-slate-100">Voir toutes les notifications</button>
                                </div>
                            </div>

                            <div class="h-8 w-px bg-slate-200 mx-1 hidden sm:block"></div>

                            <div class="relative dropdown" id="profile-dropdown">
                                <button type="button" class="flex items-center gap-3 pl-1.5 pr-1.5 py-1.5 rounded-2xl hover:bg-slate-100 transition-colors group">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-br from-[#7f1d1d] to-[#b91c1c] text-white text-sm font-bold ring-2 ring-white shadow-md shadow-[#991b1b]/25 avatar-ring">{{ $layoutUser?->initiales ?? 'AD' }}</div>
                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white"></span>
                                    </div>
                                    <div class="hidden sm:block text-left leading-tight mr-1.5">
                                        <p class="text-[13px] font-bold text-slate-800">{{ $layoutUser?->nom_agent ?? 'Administrateur' }}</p>
                                        <p class="text-[11px] text-slate-400 font-medium">{{ $layoutUser?->fonction_agent ?: ucfirst($layoutUser?->role ?? 'Agent') }}</p>
                                    </div>
                                    <svg class="hidden sm:block w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <div class="dropdown-panel absolute right-0 mt-3 w-56 bg-white rounded-2xl border border-slate-200/80 shadow-2xl shadow-slate-900/10 overflow-hidden z-50">
                                    <div class="px-5 py-4 bg-gradient-to-br from-[#7f1d1d] to-[#991b1b] text-white">
                                        <p class="text-sm font-bold">{{ $layoutUser?->nom_agent ?? 'Administrateur' }}</p>
                                        <p class="text-xs text-white/70 mt-0.5">{{ $layoutUser?->email ?? 'admin@esu.cd' }}</p>
                                    </div>
                                    <div class="py-2">
                                        <a href="#" class="flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Mon profil
                                        </a>
                                        <a href="#" class="flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.332.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Paramètres
                                        </a>
                                        <div class="my-1.5 h-px bg-slate-100"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-3 px-5 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                                </svg>
                                                Déconnexion
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="mobile-search-panel" class="mobile-search-panel px-4 pb-4 md:hidden">
                        <form method="GET" action="{{ route('etudiants.index') }}" class="relative" role="search">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <input type="text" name="q" placeholder="Rechercher un étudiant (matricule, nom, postnom ou prénom)" autocomplete="off" class="search-wrap w-full h-11 pl-11.5 pr-4 rounded-2xl bg-slate-100 border border-transparent focus:bg-white focus:border-[#991b1b]/30 text-sm outline-none transition-all">
                        </form>
                    </div>
                </header>
                <main class="px-4 lg:px-7 py-6 lg:py-8 flex-1">
@yield('content')
                    <footer class="mt-8 pb-2 text-center text-xs text-slate-400">
                        <p>Contrôle de la scolarité &amp; homologation des diplômes — <span class="font-semibold text-slate-500">ESU · UOO</span> © 2026. Tous droits réservés.</p>
                    </footer>
                </main>
            </div>
        </div>

        <script>
            (function () {
                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                const observe = function (els, cb) {
                    if (!('IntersectionObserver' in window)) {
                        els.forEach(cb);
                        return;
                    }
                    const io = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                cb(entry.target);
                                io.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.18 });
                    els.forEach(function (el) { io.observe(el); });
                };

                observe(document.querySelectorAll('.reveal'), function (el) {
                    if (reduceMotion) { el.classList.add('is-in'); return; }
                    setTimeout(function () { el.classList.add('is-in'); }, 40);
                });

                observe(document.querySelectorAll('.count-up'), function (el) {
                    const target = parseFloat(el.dataset.count);
                    const decimals = parseInt(el.dataset.decimals || 0, 10);
                    const prefix = el.dataset.prefix || '';
                    const suffix = el.dataset.suffix || '';
                    const fmt = function (v) {
                        return prefix + v.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }) + suffix;
                    };
                    if (reduceMotion) { el.textContent = fmt(target); return; }
                    const duration = 1700;
                    const start = performance.now();
                    (function tick(now) {
                        const p = Math.min((now - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - p, 3);
                        const val = Math.round(target * eased * Math.pow(10, decimals)) / Math.pow(10, decimals);
                        el.textContent = fmt(val);
                        if (p < 1) requestAnimationFrame(tick);
                    })(start);
                });

                const navGroups = document.querySelectorAll('.nav-toggle');
                navGroups.forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        const group = btn.closest('.nav-group');
                        const opened = group.classList.contains('open');
                        document.querySelectorAll('.nav-group.open').forEach(function (g) {
                            if (g !== group) g.classList.remove('open');
                        });
                        group.classList.toggle('open', !opened);
                    });
                });

                const hamburger = document.getElementById('hamburger-btn');
                const overlay = document.getElementById('sidebar-overlay');
                const closeSidebar = function () {
                    document.body.classList.remove('mobile-sidebar-open');
                    overlay.classList.remove('opacity-100', 'pointer-events-auto');
                };
                if (hamburger) {
                    hamburger.addEventListener('click', function () {
                        document.body.classList.add('mobile-sidebar-open');
                        overlay.classList.add('opacity-100', 'pointer-events-auto');
                    });
                }
                if (overlay) overlay.addEventListener('click', closeSidebar);

                const collapseBtn = document.getElementById('collapse-btn');
                if (collapseBtn) {
                    collapseBtn.addEventListener('click', function () {
                        document.body.classList.toggle('sidebar-collapsed');
                        document.querySelectorAll('.nav-group.open').forEach(function (g) { g.classList.remove('open'); });
                    });
                }

                const mobileSearchBtn = document.getElementById('mobile-search-btn');
                const mobileSearchPanel = document.getElementById('mobile-search-panel');
                if (mobileSearchBtn && mobileSearchPanel) {
                    mobileSearchBtn.addEventListener('click', function () {
                        mobileSearchPanel.classList.toggle('open');
                        if (mobileSearchPanel.classList.contains('open')) {
                            mobileSearchPanel.querySelector('input').focus();
                        }
                    });
                }

                const bell = document.querySelector('.notif-bell');
                if (bell && !reduceMotion) {
                    setTimeout(function () {
                        bell.parentElement.querySelector('.notif-btn, .notif-bell:not(.parent)');
                        bell.classList.add('bell-ring');
                        setTimeout(function () { bell.classList.remove('bell-ring'); }, 1800);
                    }, 1200);
                }

                document.querySelectorAll('.dropdown').forEach(function (dd) {
                    const btn = dd.querySelector('button');
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const open = dd.classList.contains('open');
                        document.querySelectorAll('.dropdown.open').forEach(function (el) { el.classList.remove('open'); });
                        dd.classList.toggle('open', !open);
                    });
                });
                document.addEventListener('click', function () {
                    document.querySelectorAll('.dropdown.open').forEach(function (dd) { dd.classList.remove('open'); });
                });

                document.addEventListener('keydown', function (e) {
                    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                        e.preventDefault();
                        const input = document.querySelector('input[type=text][placeholder*="Rechercher"]');
                        if (input) input.focus();
                    }
                });
            })();
        </script>
@stack('scripts')
        <script>
            (function () {
                var overlay = document.getElementById('chargement');
                if (!overlay) return;

                var MIN_VISIBLE = 450;
                var hideTimer = null;
                var safety = null;
                var shownAt = Date.now();

                function forceHide() {
                    if (hideTimer) { clearTimeout(hideTimer); hideTimer = null; }
                    if (safety) { clearTimeout(safety); safety = null; }
                    overlay.classList.remove('is-active');
                    overlay.setAttribute('aria-hidden', 'true');
                }

                function scheduleHide() {
                    var wait = Math.max(0, MIN_VISIBLE - (Date.now() - shownAt));
                    if (hideTimer) clearTimeout(hideTimer);
                    hideTimer = setTimeout(forceHide, wait);
                }

                function show() {
                    if (!overlay.classList.contains('is-active')) {
                        shownAt = Date.now();
                    }
                    overlay.classList.add('is-active');
                    overlay.setAttribute('aria-hidden', 'false');
                    if (safety) clearTimeout(safety);
                    safety = setTimeout(forceHide, 15000);
                    scheduleHide();
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', scheduleHide);
                } else {
                    scheduleHide();
                }
                window.addEventListener('load', scheduleHide);

                document.addEventListener('click', function (e) {
                    if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
                    if (!(e.target instanceof Element)) return;

                    var a = e.target.closest('a');
                    if (!a || a.hasAttribute('download')) return;
                    if (a.target && a.target !== '_self') return;

                    var href = a.getAttribute('href');
                    if (!href || href.charAt(0) === '#') return;

                    var url;
                    try {
                        url = new URL(a.href, window.location.href);
                    } catch (err) {
                        return;
                    }

                    if (url.origin !== window.location.origin) return;
                    if (url.pathname === window.location.pathname && url.search === window.location.search) return;

                    show();
                });

                document.addEventListener('submit', function (e) {
                    var form = e.target;
                    if (!(form instanceof HTMLFormElement)) return;

                    setTimeout(function () {
                        if (e.defaultPrevented) return;
                        if (typeof form.checkValidity === 'function' && !form.checkValidity()) return;
                        show();
                    }, 0);
                });

                window.addEventListener('pageshow', function (e) {
                    if (e.persisted) {
                        shownAt = Date.now() - MIN_VISIBLE;
                        forceHide();
                    }
                });
            })();
        </script>
    </body>
</html>
