@extends('layouts.app')

@section('title', 'Configuration du système')

@section('content')
    <x-flash />

    <x-page-header title="Configuration du système" subtitle="Vue d'ensemble des paramètres et des données de la plateforme."
        :breadcrumb="['Configuration du Système' => null]">
        <x-slot:actions>
            <x-btn :href="route('configuration.agents.index')">Gérer les agents</x-btn>
        </x-slot:actions>
    </x-page-header>

    @php $activeYear = $annees->first(); @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
        <x-card class="lg:col-span-2" title="Données de la plateforme">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                @foreach ([
                    'Facultés' => $stats['facultes'],
                    'Promotions' => $stats['promotions'],
                    'Années' => $stats['annees'],
                    'Étudiants' => $stats['etudiants'],
                    'Agents' => $stats['agents'],
                    'Inspecteurs' => $stats['inspecteurs'],
                    'Équipes' => $stats['equipes'],
                    'Missions' => $stats['missions'],
                    'Vacations' => $stats['vacations'],
                    'Avis' => $stats['homologations'],
                ] as $label => $value)
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 px-3 py-3.5 text-center">
                        <p class="text-xl font-extrabold text-slate-800 tracking-tight">{{ $fmt($value) }}</p>
                        <p class="text-[10px] uppercase tracking-wide text-slate-400 font-semibold mt-1">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </x-card>

        <x-card title="Année académique active">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[#7f1d1d]/10 text-[#7f1d1b] flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#7f1d1d]" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                </div>
                <div>
                    <p class="text-lg font-extrabold text-slate-900">{{ $activeYear ? str_replace('-', ' - ', $activeYear->libelle) : 'Non définie' }}</p>
                    <p class="text-xs text-slate-400">Dernière année enregistrée</p>
                </div>
            </div>
            <x-btn :href="route('annees.index')" variant="secondary" class="w-full mt-4">Gérer les années académiques</x-btn>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <x-card title="Raccourcis" class="lg:col-span-1">
            <div class="space-y-2">
                <a href="{{ route('facultes.index') }}" class="flex items-center gap-3 rounded-xl border border-slate-100 px-3.5 py-3 text-sm font-medium text-slate-600 hover:border-[#991b1b]/30 hover:text-[#991b1b] transition-colors">Facultés</a>
                <a href="{{ route('promotions.index') }}" class="flex items-center gap-3 rounded-xl border border-slate-100 px-3.5 py-3 text-sm font-medium text-slate-600 hover:border-[#991b1b]/30 hover:text-[#991b1b] transition-colors">Promotions</a>
                <a href="{{ route('inspecteurs.index') }}" class="flex items-center gap-3 rounded-xl border border-slate-100 px-3.5 py-3 text-sm font-medium text-slate-600 hover:border-[#991b1b]/30 hover:text-[#991b1b] transition-colors">Inspecteurs</a>
                <a href="{{ route('equipes.index') }}" class="flex items-center gap-3 rounded-xl border border-slate-100 px-3.5 py-3 text-sm font-medium text-slate-600 hover:border-[#991b1b]/30 hover:text-[#991b1b] transition-colors">Équipes d'inspection</a>
            </div>
        </x-card>

        <x-card title="Agents du système" class="lg:col-span-2" padding="p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">Agent</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Rôle</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Dernière connexion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($agents as $agent)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5">
                                    <p class="font-semibold text-slate-700">{{ $agent->nom_agent }}</p>
                                    <p class="text-xs text-slate-400">{{ $agent->email ?? '—' }}</p>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <x-badge :color="$agent->isAdmin() ? 'indigo' : 'slate'">{{ ucfirst($agent->role) }}</x-badge>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-500 text-xs">{{ $agent->last_login_at?->format('d/m/Y H:i') ?? 'Jamais' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
