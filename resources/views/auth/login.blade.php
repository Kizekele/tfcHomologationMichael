<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Connexion — Portail de pilotage académique</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html,
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                -webkit-font-smoothing: antialiased;
            }
            ::selection {
                background: #fbbf24;
                color: #1e293b;
            }
        </style>
    </head>
    <body class="min-h-screen bg-[#faf8f3]">
        <div class="min-h-screen grid lg:grid-cols-2">

            {{-- ============ SECTION GAUCHE — Ambiance universitaire ============ --}}
            <div class="relative hidden lg:flex flex-col justify-between overflow-hidden p-10 xl:p-14 text-white isolate">

                {{-- Fond bordeaux profond texturé --}}
                <div class="absolute inset-0 z-0" style="background:
                    radial-gradient(120% 90% at 18% 8%, #4d0f14 0%, #3a0a0e 45%, #1d0406 100%);"></div>

                <div class="absolute inset-0 z-10" style="background-image:url('data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20width=%2264%22%20height=%2264%22%3E%3Cpath%20d=%22M32%200v64M0%2032h64%22%20stroke=%22%23ffffff%22%20stroke-opacity=%220.035%22%20stroke-width=%221%22/%3E%3C/svg%3E'); background-size:64px 64px;"></div>

                <div class="absolute inset-0 z-10 opacity-40 [mask-image:radial-gradient(ellipse_at_bottom_right,#000_0%,transparent_70%)]" style="background-image:url('data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20width=%2226%22%20height=%2226%22%3E%3Ccircle%20cx=%221%22%20cy=%221%22%20r=%221%22%20fill=%22%23fde68a%22/%3E%3C/svg%3E'); background-size:26px 26px;"></div>

                <div class="absolute inset-0 z-10 rounded-[inherit] opacity-25 mix-blend-overlay" style="background:linear-gradient(115deg, transparent 40%, #b45309 60%, transparent 62%); background-size:300% 300%; background-position:0 0;"></div>

                {{-- Illustration artistique floutée --}}
                <div class="absolute z-20 w-[720px] -right-16 top-[42%] translate-y-[-50%] opacity-60 blur-[1px] pointer-events-none animate-float motion-reduce:animate-none">
                    <svg viewBox="0 0 860 640" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                        <defs>
                            <radialGradient id="glow" cx="0.5" cy="0.42" r="0.55">
                                <stop offset="0" stop-color="#fcd34d" stop-opacity="0.30" />
                                <stop offset="0.55" stop-color="#fbbf24" stop-opacity="0.10" />
                                <stop offset="1" stop-color="#fbbf24" stop-opacity="0" />
                            </radialGradient>
                            <linearGradient id="gold" x1="300" y1="210" x2="560" y2="330" gradientUnits="userSpaceOnUse">
                                <stop offset="0" stop-color="#fde68a" />
                                <stop offset="0.55" stop-color="#f59e0b" />
                                <stop offset="1" stop-color="#b45309" />
                            </linearGradient>
                            <linearGradient id="goldSoft" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0" stop-color="#fde68a" stop-opacity="0.92" />
                                <stop offset="1" stop-color="#b45309" stop-opacity="0.45" />
                            </linearGradient>
                        </defs>

                        <circle cx="430" cy="300" r="250" stroke="#ffffff" stroke-opacity="0.05" />
                        <circle cx="430" cy="290" r="205" stroke="#ffffff" stroke-opacity="0.08" stroke-width="1.4" />
                        <circle cx="430" cy="285" r="150" fill="url(#glow)" />

                        <g fill="#fcd34d" transform="translate(140 175) scale(1.05)">
                            <path d="M0 -11 Q1.6 -1.7 11 0 Q1.6 1.7 0 11 Q-1.6 1.7 -11 0 Q-1.6 -1.7 0 -11 Z" opacity="0.85" />
                        </g>
                        <g fill="#fcd34d" transform="translate(715 250) scale(0.8)">
                            <path d="M0 -11 Q1.6 -1.7 11 0 Q1.6 1.7 0 11 Q-1.6 1.7 -11 0 Q-1.6 -1.7 0 -11 Z" opacity="0.7" />
                        </g>
                        <g fill="#fcd34d" transform="translate(120 470) scale(0.6)">
                            <path d="M0 -11 Q1.6 -1.7 11 0 Q1.6 1.7 0 11 Q-1.6 1.7 -11 0 Q-1.6 -1.7 0 -11 Z" opacity="0.6" />
                        </g>
                        <g fill="#fcd34d" transform="translate(740 520) scale(0.95)">
                            <path d="M0 -11 Q1.6 -1.7 11 0 Q1.6 1.7 0 11 Q-1.6 1.7 -11 0 Q-1.6 -1.7 0 -11 Z" opacity="0.7" />
                        </g>

                        {{-- Toque de diplôme --}}
                        <path d="M300 268 L430 326 L430 342 L300 284 Z" fill="#8a4b0b" opacity="0.9" />
                        <path d="M560 268 L430 326 L430 342 L560 284 Z" fill="#6d3a07" opacity="0.9" />
                        <path d="M430 210 L560 268 L430 326 L300 268 Z" fill="url(#gold)" />
                        <rect x="360" y="322" width="140" height="82" rx="32" fill="url(#goldSoft)" />
                        <rect x="360" y="360" width="140" height="12" rx="6" fill="#78350f" opacity="0.35" />
                        <circle cx="430" cy="268" r="9" fill="#78350f" />
                        <circle cx="430" cy="268" r="3.5" fill="#fde68a" opacity="0.8" />
                        <path d="M430 268 C472 300 505 362 536 404" stroke="#f59e0b" stroke-width="3" stroke-linecap="round" />
                        <circle cx="540" cy="412" r="8" fill="#f59e0b" />
                        <circle cx="537" cy="409" r="3" fill="#fde68a" opacity="0.9" />

                        {{-- Livre ouvert --}}
                        <path d="M430 478 C398 452 352 448 310 464 C322 480 388 494 430 490 Z" fill="#fef3c7" fill-opacity="0.12" stroke="#fde68a" stroke-opacity="0.35" stroke-width="1.2" />
                        <path d="M430 478 C462 452 508 448 550 464 C538 480 472 494 430 490 Z" fill="#fef3c7" fill-opacity="0.12" stroke="#fde68a" stroke-opacity="0.35" stroke-width="1.2" />
                        <path d="M408 470 L404 487 M454 470 L458 487" stroke="#fde68a" stroke-opacity="0.25" stroke-width="1" />

                        <circle cx="210" cy="360" r="5" fill="#ffffff" fill-opacity="0.08" />
                        <circle cx="655" cy="160" r="7" fill="#ffffff" fill-opacity="0.06" />
                    </svg>
                </div>

                {{-- Voile sombre pour la lisibilité du texte --}}
                <div class="absolute inset-0 z-30" style="background:linear-gradient(180deg, rgba(10,2,3,0.62) 0%, rgba(10,2,3,0.12) 34%, rgba(10,2,3,0.28) 66%, rgba(8,1,2,0.82) 100%);"></div>

                {{-- Contenu --}}
                <div class="relative z-40">

                    <div class="flex items-center gap-3 animate-fade-in-down motion-reduce:animate-none">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-300 to-amber-600 flex items-center justify-center text-[#4a0c10] shadow-lg shadow-black/30 ring-1 ring-white/20">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <div class="leading-tight">
                            <p class="font-bold text-lg tracking-tight">ESU · UOO</p>
                            <p class="text-xs text-white/55 font-medium">Ministère de l'Enseignement Supérieur</p>
                        </div>
                    </div>

                    <div class="mt-16 max-w-lg animate-fade-in-up [animation-delay:90ms] motion-reduce:animate-none">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-[11px] font-semibold uppercase tracking-[0.18em] text-amber-200/90 backdrop-blur-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            Portail de pilotage académique
                        </span>

                        <h1 class="mt-6 text-4xl xl:text-[2.75rem] font-bold tracking-tight leading-[1.1]">
                            Bienvenue sur votre portail de pilotage académique
                        </h1>
                        <p class="mt-5 text-[15px] text-white/70 leading-relaxed">
                            Un espace pensé pour les équipes qui accompagnent la scolarité,
                            les missions d'inspection et l'homologation des diplômes —
                            simple, chaleureux et fait pour durer.
                        </p>

                        <ul class="mt-8 space-y-3.5 text-sm text-white/75">
                            <li class="flex items-center gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 ring-1 ring-white/15">
                                    <svg class="w-3.5 h-3.5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke-width="2.4" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                </span>
                                Suivi des missions d'inspection et de contrôle
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 ring-1 ring-white/15">
                                    <svg class="w-3.5 h-3.5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke-width="2.4" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                </span>
                                Traitement des dossiers des étudiants finalistes
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 ring-1 ring-white/15">
                                    <svg class="w-3.5 h-3.5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke-width="2.4" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                </span>
                                Validation et homologation des diplômes universitaires
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Badge officiel bas --}}
                <div class="relative z-40 flex flex-wrap items-center gap-4 text-xs text-white/50 animate-fade-in-up [animation-delay:200ms] motion-reduce:animate-none">
                    <span class="rounded-md border border-red-400/25 bg-red-500/10 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-red-200/80">Session {{ date('Y') }}</span>
                    <span>© {{ date('Y') }} ESU · UOO</span>
                    <span class="w-1 h-1 rounded-full bg-white/30"></span>
                    <span>République Démocratique du Congo — Enseignement Supérieur et Universitaire</span>
                </div>
            </div>

            {{-- ============ SECTION DROITE — Formulaire ============ --}}
            <div class="relative flex items-center justify-center p-6 sm:p-12">

                {{-- Texture papier / blanc cassé --}}
                <div class="absolute inset-0 pointer-events-none" style="background-image:url('data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20width=%2224%22%20height=%2224%22%3E%3Ccircle%20cx=%221%22%20cy=%221%22%20r=%221.1%22%20fill=%22%23e8dfd0%22/%3E%3C/svg%3E'); background-size:24px 24px;"></div>
                <div class="absolute inset-y-0 right-0 w-px bg-gradient-to-b from-transparent via-stone-200 to-transparent"></div>

                <div class="relative w-full max-w-md">

                    <div class="lg:hidden flex items-center gap-3 mb-10 animate-fade-in-down motion-reduce:animate-none">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#7f1d1d] to-[#991b1b] flex items-center justify-center text-amber-300 ring-1 ring-[#991b1b]/20">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-stone-800">ESU · UOO</p>
                            <p class="text-[11px] text-stone-400 font-medium">Portail de pilotage académique</p>
                        </div>
                    </div>

                    <div class="animate-fade-in-up motion-reduce:animate-none">
                        <h2 class="text-2xl font-bold text-stone-900 tracking-tight">Connexion à votre espace</h2>
                        <p class="text-sm text-stone-500 mt-1.5">Ravi de vous revoir — saisissez vos identifiants pour continuer.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mt-6 flex items-start gap-3 rounded-xl border border-rose-100 bg-rose-50/80 px-4 py-3.5 text-sm text-rose-700 animate-fade-in motion-reduce:animate-none">
                            <svg class="w-5 h-5 shrink-0 mt-px" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5 animate-fade-in-up [animation-delay:120ms] motion-reduce:animate-none">
                        @csrf

                        <div>
                            <label for="identifiant" class="block text-[13px] font-semibold text-stone-700 mb-1.5">Matricule ou adresse email</label>
                            <div class="relative">
                                <input id="identifiant" name="identifiant" type="text" value="{{ old('identifiant') }}" required autofocus autocomplete="username" placeholder="AG-001 ou admin@esu.cd"
                                    class="peer w-full h-12 pl-11 pr-4 rounded-xl bg-stone-100/70 border border-stone-200/80 focus:bg-white focus:border-[#991b1b]/50 focus:ring-2 focus:ring-red-800/50 text-sm text-stone-800 placeholder:text-stone-400 outline-none transition-all duration-300 [&:not(:placeholder-shown)]:border-[#991b1b]/35 [&:not(:placeholder-shown)]:bg-white">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-stone-400 peer-focus:text-[#991b1b] peer-[&:not(:placeholder-shown)]:text-[#991b1b] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-[13px] font-semibold text-stone-700 mb-1.5">Mot de passe</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••"
                                    class="peer w-full h-12 pl-11 pr-12 rounded-xl bg-stone-100/70 border border-stone-200/80 focus:bg-white focus:border-[#991b1b]/50 focus:ring-2 focus:ring-red-800/50 text-sm text-stone-800 placeholder:text-stone-400 outline-none transition-all duration-300 [&:not(:placeholder-shown)]:border-[#991b1b]/35 [&:not(:placeholder-shown)]:bg-white">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-stone-400 peer-focus:text-[#991b1b] peer-[&:not(:placeholder-shown)]:text-[#991b1b] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                <button type="button" data-password-toggle="#password"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 flex h-8 w-8 items-center justify-center rounded-lg text-stone-400 transition-colors duration-300 hover:text-stone-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-800/40"
                                    aria-label="Afficher ou masquer le mot de passe">
                                    <svg data-icon="off" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <svg data-icon="on" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                </button>
                            </div>
                        </div>

                        <label class="flex items-center gap-2.5 text-sm text-stone-600 select-none cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-stone-300 text-[#7f1d1d] accent-[#7f1d1d] focus:ring-[#7f1d1d]/30">
                            Se souvenir de moi
                        </label>

                        <button type="submit"
                            class="group w-full h-12 rounded-xl bg-gradient-to-r from-[#7f1d1d] to-[#991b1b] text-white text-sm font-bold tracking-wide shadow-lg shadow-red-900/20 hover:shadow-xl hover:shadow-red-900/35 hover:brightness-110 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                            Se connecter
                        </button>
                    </form>

                    {{-- Compte de démonstration — discret --}}
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-x-2 gap-y-1 rounded-xl border border-dashed border-stone-300/70 bg-white/50 px-4 py-2.5 text-[11px] text-stone-400 animate-fade-in-up [animation-delay:240ms] motion-reduce:animate-none">
                        <span class="inline-flex items-center gap-1 rounded-md bg-stone-100 px-1.5 py-0.5 text-[9px] font-semibold uppercase tracking-widest text-stone-500">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" /></svg>
                            Mode test
                        </span>
                        <span class="font-mono font-semibold text-stone-500">AG-001</span>
                        <span class="text-stone-300">·</span>
                        <span class="font-mono">admin@esu.cd</span>
                        <span class="text-stone-300">·</span>
                        <span class="font-mono font-semibold text-stone-500">password</span>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('[data-password-toggle]').forEach(function (btn) {
                var input = document.querySelector(btn.dataset.passwordToggle);
                if (!input) return;
                var iconOff = btn.querySelector('[data-icon="off"]');
                var iconOn = btn.querySelector('[data-icon="on"]');
                btn.addEventListener('click', function () {
                    var show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    iconOn.classList.toggle('hidden', !show);
                    iconOff.classList.toggle('hidden', show);
                });
            });
        </script>
    </body>
</html>