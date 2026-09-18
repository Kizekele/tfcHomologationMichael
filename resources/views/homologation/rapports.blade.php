@extends('layouts.app')

@section('title', "Rapports d'homologation")

@section('content')
    <x-flash />

    <x-page-header title="Rapports d'homologation" subtitle="Synthèse des avis par mission et par faculté."
        :breadcrumb="['Homologation' => null, 'Rapports d\'homologation' => null]">
        <x-slot:actions>
            <x-btn :href="route('homologation.index')" variant="secondary">Saisir des avis</x-btn>
        </x-slot:actions>
    </x-page-header>

    @php $taux = $totaux['total'] > 0 ? round($totaux['favorables'] / $totaux['total'] * 100, 1) : 0; @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Total avis</p>
            <p class="mt-1 text-[1.9rem] font-extrabold text-slate-900 tracking-tight">{{ $fmt($totaux['total']) }}</p>
        </x-card>
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Favorables</p>
            <p class="mt-1 text-[1.9rem] font-extrabold text-emerald-600 tracking-tight">{{ $fmt($totaux['favorables']) }}</p>
        </x-card>
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Défavorables</p>
            <p class="mt-1 text-[1.9rem] font-extrabold text-rose-600 tracking-tight">{{ $fmt($totaux['defavorables']) }}</p>
        </x-card>
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Taux d'homologation</p>
            <p class="mt-1 text-[1.9rem] font-extrabold text-slate-900 tracking-tight">{{ number_format($taux, 1, '.', ',') }}%</p>
        </x-card>
    </div>

    <x-card title="Détail par mission" padding="p-0" class="mb-5">
        @if ($missions->isEmpty())
            <x-empty message="Aucune mission enregistrée." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">Mission</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Faculté</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-center">Total</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-center">Favorables</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-center">Défavorables</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Taux</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($missions as $mission)
                            @php $t = $mission->total_avis > 0 ? round($mission->favorables / $mission->total_avis * 100, 1) : 0; @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5">
                                    <a href="{{ route('missions.show', $mission) }}" class="font-semibold text-slate-700 hover:text-[#991b1b] transition-colors">{{ $mission->numero_lettre }}</a>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $mission->faculte?->nom_faculte ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-center text-slate-600">{{ $fmt($mission->total_avis) }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-center text-emerald-600 font-semibold">{{ $fmt($mission->favorables) }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-center text-rose-600 font-semibold">{{ $fmt($mission->defavorables) }}</td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-24 rounded-full bg-slate-100 overflow-hidden">
                                            <div class="h-full rounded-full bg-gradient-to-r from-[#7f1d1d] to-[#b91c1c]" style="width:{{ $t }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-500">{{ number_format($t, 1, '.', ',') }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>

    <x-card title="Répartition par faculté" padding="p-0">
        @if ($parFaculte->isEmpty())
            <x-empty message="Aucun avis enregistré." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">Faculté</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-center">Total</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-center">Favorables</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-center">Défavorables</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($parFaculte as $ligne)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5 font-semibold text-slate-700">{{ $ligne->nom_faculte }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-center text-slate-600">{{ $fmt($ligne->total) }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-center text-emerald-600 font-semibold">{{ $fmt($ligne->favorables) }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-center text-rose-600 font-semibold">{{ $fmt($ligne->defavorables) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
@endsection
