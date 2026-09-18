@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')

                    <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
                        <div class="reveal">
                            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-1.5">
                                <a href="#" class="hover:text-[#991b1b] transition-colors">Accueil</a>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                                <span class="text-slate-500 font-medium">Tableau de bord</span>
                            </nav>
                            <h2 class="text-2xl lg:text-[1.75rem] font-extrabold text-slate-900 tracking-tight">Aperçu général</h2>
                            <p class="text-sm text-slate-500 mt-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                {{ $dateFr }}
                            </p>                        </div>
                        <div class="flex items-center gap-2.5 reveal" style="transition-delay:.12s">
                            <button type="button" class="shine h-11 px-4 rounded-2xl bg-gradient-to-r from-[#7f1d1d] to-[#991b1b] text-white text-sm font-bold shadow-lg shadow-[#991b1b]/25 hover:shadow-xl hover:shadow-[#991b1b]/40 hover:brightness-110 active:scale-95 transition-all flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                Nouveau dossier
                            </button>
                        </div>
                    </div>

                    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-5">

                        <div class="reveal stat-tile bg-white rounded-3xl border border-slate-200/70 p-5 shadow-sm card-hover">
                            <div class="tile-glow bg-[#7f1d1d]"></div>
                            <div class="flex items-start justify-between">
                                <div class="w-12 h-12 rounded-2xl bg-[#7f1d1d]/10 text-[#7f1d1d] flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </div>
                                <div class="relative">
                                    <span class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-full px-2 py-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>+{{ round($growth) }}%</span>
                                </div>
                            </div>
                            <p class="mt-4 text-[13px] font-medium text-slate-400">Total Étudiants</p>
                            <div class="mt-1 flex items-end justify-between gap-2">
                                <p class="text-[1.9rem] font-extrabold text-slate-900 tracking-tight"><span class="count-up" data-count="{{ $totalStudents }}" data-decimals="0">0</span></p>
                                <svg class="spark w-16 h-9 overflow-visible -mb-1" viewBox="0 0 120 40" fill="none">
                                    <path class="spark-area" d="M2 34 C 22 30, 30 24, 44 24 S 66 16, 74 20 S 96 6, 118 8 L 118 40 L 2 40 Z" fill="#7f1d1d"/>
                                    <path class="spark-line" pathLength="100" d="M2 34 C 22 30, 30 24, 44 24 S 66 16, 74 20 S 96 6, 118 8" stroke="#7f1d1d" stroke-width="2.4" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="mt-3 h-1 w-full rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full w-3/4 rounded-full bg-gradient-to-r from-[#7f1d1d] to-[#b91c1c] transition-all duration-700"></div>
                            </div>
                            <p class="mt-2 text-[11px] text-slate-400">Contre <span class="font-semibold text-slate-600">{{ $fmt($previousCount) }}</span> l'an dernier</p>
                        </div>

                        <div class="reveal stat-tile bg-white rounded-3xl border border-slate-200/70 p-5 shadow-sm card-hover" style="transition-delay:.1s">
                            <div class="tile-glow bg-sky-500"></div>
                            <div class="flex items-start justify-between">
                                <div class="w-12 h-12 rounded-2xl bg-sky-500/10 text-sky-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                </div>
                                <span class="flex items-center gap-1.5 text-[11px] font-bold text-sky-700 bg-sky-50 border border-sky-100 rounded-full px-2 py-1"><span class="w-1.5 h-1.5 rounded-full bg-sky-500 pulse-dot"></span>Live</span>
                            </div>
                            <p class="mt-4 text-[13px] font-medium text-slate-400">Missions Actives</p>
                            <div class="mt-1 flex items-end justify-between gap-2">
                                <p class="text-[1.9rem] font-extrabold text-slate-900 tracking-tight"><span class="count-up" data-count="{{ $activeMissions }}" data-decimals="0">0</span></p>
                                <div class="h-9 flex items-center overflow-hidden rounded-lg">
                                    <div class="mission-ticker flex flex-col text-[11px] font-semibold text-sky-700 text-right leading-9">
                                        <span class="px-2 bg-sky-50 rounded-lg">En cours de contrôle</span>
                                        <span class="px-2 bg-sky-50 rounded-lg mt-1">Départ demain</span>
                                        <span class="px-2 bg-sky-50 rounded-lg mt-1">En cours de contrôle</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 grid grid-cols-3 gap-2">
                                <div class="rounded-xl bg-slate-50 border border-slate-100 px-2 py-2 text-center">
                                    <p class="text-sm font-extrabold text-slate-800">{{ $missionsEnCours }}</p>
                                    <p class="text-[9px] uppercase tracking-wide text-slate-400 font-semibold">Parties</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 border border-slate-100 px-2 py-2 text-center">
                                    <p class="text-sm font-extrabold text-slate-800">{{ $engagedInspectors }}</p>
                                    <p class="text-[9px] uppercase tracking-wide text-slate-400 font-semibold">Inspecteurs</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 border border-slate-100 px-2 py-2 text-center">
                                    <p class="text-sm font-extrabold text-slate-800">{{ $missionsFacultes }}</p>
                                    <p class="text-[9px] uppercase tracking-wide text-slate-400 font-semibold">Facultés</p>
                                </div>
                            </div>
                        </div>

                        <div class="reveal stat-tile bg-white rounded-3xl border border-slate-200/70 p-5 shadow-sm card-hover" style="transition-delay:.2s">
                            <div class="tile-glow bg-emerald-500"></div>
                            <div class="flex items-start justify-between">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <svg class="w-12 h-12 -mt-1" viewBox="0 0 48 48" fill="none">
                                    <circle class="ring-track" cx="24" cy="24" r="20" stroke-width="5"/>
                                    <circle class="ring-fg" id="homologation-ring" style="--ring-target:{{ number_format(100 - $homologationRate, 1, '.', '') }}" cx="24" cy="24" r="20" stroke="#059669" stroke-width="5" stroke-linecap="round" pathLength="100"/>
                                </svg>
                            </div>
                            <p class="mt-3 text-[13px] font-medium text-slate-400">Taux d'Homologation</p>
                            <div class="mt-1 flex items-end gap-2">
                                <p class="text-[1.9rem] font-extrabold text-slate-900 tracking-tight"><span class="count-up" data-count="{{ $homologationRate }}" data-decimals="1" data-suffix="%">0</span></p>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-[11px]">
                                <span class="text-slate-400"><span class="font-bold text-slate-700">{{ $fmt($favorable) }}</span> validés sur {{ $fmt($totalStudents) }}</span>
                                <span class="text-emerald-600 font-semibold">Excellent</span>
                            </div>
                        </div>

                        <div class="reveal stat-tile bg-white rounded-3xl border border-slate-200/70 p-5 shadow-sm card-hover" style="transition-delay:.3s">
                            <div class="tile-glow bg-amber-500"></div>
                            <div class="flex items-start justify-between">
                                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-4 text-[13px] font-medium text-slate-400">Coût Total Vacations</p>
                            <div class="mt-1 flex items-end justify-between gap-2">
                                <p class="text-[1.5rem] font-extrabold text-slate-900 tracking-tight leading-none"><span class="count-up" data-count="{{ $coutTotal }}" data-decimals="0" data-suffix=" FC">0</span></p>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-[11px] mb-1.5">
                                <span class="text-slate-400">Payé</span>
                                <span class="font-semibold text-slate-600">{{ $fmt($payeVacations) }} FC</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-amber-500 to-emerald-500 transition-all duration-1000" style="width:{{ $paidPct }}%"></div>
                            </div>
                            <p class="mt-2 text-[11px] text-rose-500 font-semibold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                                Reste à payer : {{ $fmt($resteVacations) }} FC
                            </p>
                        </div>
                    </section>

                    <section class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4 mt-4 lg:mt-5">

                        <div class="reveal bg-white rounded-2xl border border-slate-200/70 p-4 flex items-center gap-4 shadow-sm card-hover" style="transition-delay:.05s">
                            <div class="w-11 h-11 rounded-xl bg-blue-600/10 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xl font-extrabold text-slate-900 leading-tight"><span class="count-up" data-count="{{ $facultesCount }}" data-decimals="0">0</span></p>
                                <p class="text-xs text-slate-500 truncate">Facultés actives</p>
                            </div>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500 pulse-dot shrink-0"></span>
                        </div>

                        <div class="reveal bg-white rounded-2xl border border-slate-200/70 p-4 flex items-center gap-4 shadow-sm card-hover" style="transition-delay:.1s">
                            <div class="w-11 h-11 rounded-xl bg-green-600/10 text-green-600 flex items-center justify-center shrink-0">
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xl font-extrabold text-slate-900 leading-tight"><span class="count-up" data-count="{{ $nouveauxMois }}" data-decimals="0">0</span></p>
                                <p class="text-xs text-slate-500 truncate">Nouveaux dossiers (mois)</p>
                            </div>
                            <span class="text-[10px] font-bold text-green-600 bg-green-50 rounded-full px-1.5 py-0.5 ml-auto shrink-0">+8</span>
                        </div>

                        <div class="reveal bg-white rounded-2xl border border-slate-200/70 p-4 flex items-center gap-4 shadow-sm card-hover" style="transition-delay:.15s">
                            <div class="w-11 h-11 rounded-xl bg-sky-600/10 text-sky-600 flex items-center justify-center shrink-0">
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xl font-extrabold text-slate-900 leading-tight"><span class="count-up" data-count="{{ $inspecteursCount }}" data-decimals="0">0</span></p>
                                <p class="text-xs text-slate-500 truncate">Inspecteurs mobilisables</p>
                            </div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-50 rounded-full px-1.5 py-0.5 ml-auto shrink-0">{{ $inspecteursDispo }} dispo</span>
                        </div>

                        <div class="reveal bg-white rounded-2xl border border-slate-200/70 p-4 flex items-center gap-4 shadow-sm card-hover" style="transition-delay:.2s">
                            <div class="w-11 h-11 rounded-xl bg-emerald-600/10 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xl font-extrabold text-slate-900 leading-tight"><span class="count-up" data-count="{{ $equipesCount }}" data-decimals="0">0</span></p>
                                <p class="text-xs text-slate-500 truncate">Équipes en mission</p>
                            </div>
                            <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 rounded-full px-1.5 py-0.5 ml-auto shrink-0"><span class="w-1 h-1 rounded-full bg-emerald-500 pulse-dot"></span>Actives</span>
                        </div>
                    </section>

                    <section class="mt-6 lg:mt-7 grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-5">
                        <div class="lg:col-span-2 reveal bg-white rounded-3xl border border-slate-200/70 shadow-sm p-5 lg:p-6">
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-[15px]">Répartition des étudiants finalistes par Faculté</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Année académique {{ str_replace('-', ' - ', $currentYearLabel) }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" class="h-8 px-3 rounded-lg bg-[#7f1d1d]/[.06] text-[#7f1d1d] text-xs font-bold hover:bg-[#7f1d1d]/10 transition-colors">{{ $currentYearLabel }}</button>
                                    <button type="button" class="h-8 px-3 rounded-lg text-xs font-semibold text-slate-400 hover:bg-slate-100 transition-colors">{{ $previousYearLabel }}</button>
                                </div>
                            </div>

                            <div class="space-y-5">
                                @foreach ($facultes as $index => $faculte)
                                    @php
                                        $couleurs = $palette[$index % count($palette)];
                                        $pctAffiche = str_replace('.', ',', number_format($faculte['pct'], 1));
                                    @endphp
                                    <div class="reveal" style="transition-delay:{{ round(0.05 + $index * 0.1, 2) }}s">
                                        <div class="flex items-end justify-between gap-3 mb-2">
                                            <div class="flex items-center gap-2.5">
                                                <span class="w-3 h-3 rounded-md" style="background:linear-gradient(135deg, {{ $couleurs[0] }}, {{ $couleurs[1] }})"></span>
                                                <span class="text-sm font-semibold text-slate-700">{{ $faculte['nom'] }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-extrabold text-slate-900"><span class="count-up" data-count="{{ $faculte['total'] }}" data-decimals="0">0</span></span>
                                                <span class="text-[11px] font-semibold text-slate-400 bg-slate-100 rounded-full px-2 py-0.5">{{ $pctAffiche }}%</span>
                                            </div>
                                        </div>
                                        <div class="h-3 rounded-full bg-slate-100 overflow-hidden">
                                            <div class="h-full rounded-full h-bar-fill" style="width:{{ $faculte['pct'] }}%;background:linear-gradient(90deg, {{ $couleurs[0] }}, {{ $couleurs[1] }})"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                                    Total finalistes contrôlés
                                </div>
                                <p class="text-lg font-extrabold text-slate-900"><span class="count-up" data-count="{{ $totalStudents }}" data-decimals="0">0</span> <span class="text-xs font-semibold text-slate-400">étudiants</span></p>
                            </div>
                        </div>

                        <div class="space-y-4 lg:space-y-5">
                            <div class="reveal bg-white rounded-3xl border border-slate-200/70 shadow-sm p-5 lg:p-6" style="transition-delay:.1s">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-bold text-slate-900 text-[15px]">Donut de répartition</h3>
                                    <svg class="w-5 h-5 text-slate-300 animate-spin" style="animation-duration:14s" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.332.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/></svg>
                                </div>
                                <div class="relative w-40 h-40 mx-auto">
                                    <svg viewBox="0 0 100 100" class="w-full h-full">
                                        @php $offset = 0; @endphp
                                        @foreach ($facultes as $index => $faculte)
                                            @php
                                                $dash = $faculte['pct'];
                                                $segOff = -$offset;
                                                $offset += $dash;
                                            @endphp
                                            <circle class="seg" style="--dash:{{ $dash }};--off:{{ $segOff }};transition-delay:{{ round(0.4 * $index, 2) }}s" cx="50" cy="50" r="40" fill="none" stroke="{{ $foreground[$index % count($foreground)] }}" stroke-width="16" pathLength="100"/>
                                        @endforeach
                                    </svg>
                                    <div class="absolute inset-4 rounded-full bg-white flex flex-col items-center justify-center shadow-[inset_0_2px_8px_rgba(15,23,42,.06)]">
                                        <p class="text-2xl font-extrabold text-slate-900">{{ $fmt($totalStudents) }}</p>
                                        <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wide">Finalistes</p>
                                    </div>
                                </div>
                                <div class="mt-5 space-y-2.5">
                                    @foreach ($facultes as $index => $faculte)
                                        <div class="flex items-center justify-between text-[13px]">
                                            <span class="flex items-center gap-2 text-slate-500"><span class="w-2.5 h-2.5 rounded-full" style="background:{{ $foreground[$index % count($foreground)] }}"></span>{{ $faculte['nom'] }}</span>
                                            <span class="font-bold text-slate-800">{{ $fmt($faculte['total']) }} · {{ round($faculte['pct']) }}%</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="reveal bg-white rounded-3xl border border-slate-200/70 shadow-sm p-5 lg:p-6" style="transition-delay:.2s">
                                <h3 class="font-bold text-slate-900 text-[15px] mb-4">Statut des dossiers</h3>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex items-center justify-between text-[13px] mb-1.5">
                                            <span class="text-slate-500 font-medium">Favorables</span>
                                            <span class="font-bold text-slate-800">{{ $fmt($favorable) }}</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400" style="width:{{ round($favorable / max($totalStudents, 1) * 100) }}%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between text-[13px] mb-1.5">
                                            <span class="text-slate-500 font-medium">En attente</span>
                                            <span class="font-bold text-slate-800">{{ $fmt($enAttente) }}</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                            <div class="h-full rounded-full bg-gradient-to-r from-amber-500 to-amber-400" style="width:{{ round($enAttente / max($totalStudents, 1) * 100) }}%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between text-[13px] mb-1.5">
                                            <span class="text-slate-500 font-medium">Défavorables</span>
                                            <span class="font-bold text-slate-800">{{ $fmt($defavorable) }}</span>
                                        </div>
                                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                            <div class="h-full rounded-full bg-gradient-to-r from-rose-500 to-rose-400" style="width:{{ number_format($defavorable / max($totalStudents, 1) * 100, 1, '.', '') }}%"></div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="mt-5 w-full py-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs font-bold text-slate-500 hover:border-[#991b1b]/30 hover:text-[#991b1b] hover:bg-[#991b1b]/5 transition-colors">Voir tous les rapports</button>
                            </div>
                        </div>
                    </section>

                    <section class="mt-6 lg:mt-7 reveal bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden">
                        <div class="flex flex-wrap items-center justify-between gap-3 p-5 lg:p-6 pb-4">
                            <div>
                                <h3 class="font-bold text-slate-900 text-[15px]">Derniers dossiers d'étudiants enregistrés</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Les 6 dossiers les plus récents du registre</p>
                            </div>
                            <button type="button" class="flex items-center gap-2 h-9 px-3.5 rounded-xl text-xs font-bold text-[#991b1b] bg-[#991b1b]/[.06] hover:bg-[#991b1b]/10 transition-colors">
                                Liste complète
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-slate-50/80 border-y border-slate-100">
                                        <th class="text-left px-5 lg:px-6 py-3.5 text-[11px] font-bold uppercase tracking-wider text-slate-400 whitespace-nowrap">Matricule</th>
                                        <th class="text-left px-4 py-3.5 text-[11px] font-bold uppercase tracking-wider text-slate-400 whitespace-nowrap">Nom</th>
                                        <th class="text-left px-4 py-3.5 text-[11px] font-bold uppercase tracking-wider text-slate-400 whitespace-nowrap">Faculté</th>
                                        <th class="text-left px-4 py-3.5 text-[11px] font-bold uppercase tracking-wider text-slate-400 whitespace-nowrap">Promotion</th>
                                        <th class="text-right px-5 lg:px-6 py-3.5 text-[11px] font-bold uppercase tracking-wider text-slate-400 whitespace-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse ($recent as $i => $etudiant)
                                        @php
                                            $promotion = $etudiant->promotion;
                                            $faculte = $promotion?->faculte;
                                            $initiales = mb_strtoupper(mb_substr($etudiant->nom, 0, 1).mb_substr($etudiant->postnom ?? '', 0, 1));
                                            $avatarClasses = ['bg-[#7f1d1d]/10 text-[#7f1d1d]', 'bg-sky-500/10 text-sky-600', 'bg-emerald-500/10 text-emerald-600', 'bg-amber-500/10 text-amber-600', 'bg-indigo-500/10 text-indigo-600', 'bg-rose-500/10 text-rose-600'];
                                            $chipClass = $chipPalette[$i % count($chipPalette)];
                                        @endphp
                                        <tr class="t-row group hover:bg-[#991b1b]/[.03] transition-colors" style="animation-delay:{{ round(0.05 + $i * 0.07, 2) }}s">
                                            <td class="px-5 lg:px-6 py-4 font-mono text-[13px] font-semibold text-slate-500">{{ $etudiant->matricule }}</td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <span class="w-9 h-9 rounded-xl {{ $avatarClasses[$i % count($avatarClasses)] }} flex items-center justify-center text-xs font-bold shrink-0">
                                                        {{ $initiales }}
                                                    </span>
                                                    <div>
                                                        <p class="font-semibold text-slate-800 group-hover:text-[#991b1b] transition-colors">{{ $etudiant->nom_complet }}</p>
                                                        <p class="text-xs text-slate-400">{{ $etudiant->prenom }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-slate-500 whitespace-nowrap">{{ $faculte?->nom_faculte }}</td>
                                            <td class="px-4 py-4">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg {{ $chipClass }} text-xs font-bold border whitespace-nowrap">
                                                    {{ $promotion?->nom_promotion }}
                                                </span>
                                            </td>
                                            <td class="px-5 lg:px-6 py-4">
                                                <div class="flex items-center justify-end gap-2 opacity-90 group-hover:opacity-100 transition-opacity">
                                                    <button type="button" class="h-8 px-3 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all flex items-center gap-1.5">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                        Voir
                                                    </button>
                                                    <button type="button" class="h-8 px-3 rounded-lg bg-[#7f1d1d]/[.08] text-[#7f1d1d] text-xs font-bold hover:bg-[#7f1d1d] hover:text-white transition-all flex items-center gap-1.5">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                                        Modifier
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-5 lg:px-6 py-10 text-center text-sm text-slate-400">Aucun dossier enregistré.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3 px-5 lg:px-6 py-4 border-t border-slate-100">
                            <p class="text-xs text-slate-400">Affichage de <span class="font-bold text-slate-600">1 à {{ $recent->count() }}</span> sur <span class="font-bold text-slate-600">{{ $fmt($totalStudents) }}</span> dossiers</p>
                            <div class="flex items-center gap-1.5">
                                <button type="button" class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                                </button>
                                <button type="button" class="w-9 h-9 rounded-lg bg-[#7f1d1d]/[.08] text-[#7f1d1d] font-bold text-sm hover:bg-[#7f1d1d] hover:text-white transition-colors">1</button>
                                <button type="button" class="w-9 h-9 rounded-lg border border-slate-200 text-slate-500 font-semibold text-sm hover:bg-slate-50 transition-colors">2</button>
                                <button type="button" class="w-9 h-9 rounded-lg border border-slate-200 text-slate-500 font-semibold text-sm hover:bg-slate-50 transition-colors">3</button>
                                <span class="px-1 text-slate-400 text-sm">…</span>
                                <button type="button" class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                                </button>
                            </div>
                        </div>
                    </section>
@endsection
