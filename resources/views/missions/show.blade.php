@extends('layouts.app')

@section('title', 'Détail de la mission')

@section('content')
    <x-flash />

    @php $active = $mission->periode_fin && $mission->periode_fin->isFuture(); @endphp

    <x-page-header :title="$mission->numero_lettre" :subtitle="$mission->motif"
        :breadcrumb="['Ordres de mission' => null, 'Consulter les ordres' => route('missions.index'), $mission->numero_lettre => null]">
        <x-slot:actions>
            <x-btn :href="route('missions.edit', $mission)" variant="secondary">Modifier</x-btn>
            <x-btn :href="route('homologation.index', ['mission' => $mission->id_mission])">Saisir des avis</x-btn>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Avis favorables</p>
            <p class="mt-1 text-[1.9rem] font-extrabold text-emerald-600 tracking-tight">{{ $fmt($favorable) }}</p>
        </x-card>
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Avis défavorables</p>
            <p class="mt-1 text-[1.9rem] font-extrabold text-rose-600 tracking-tight">{{ $fmt($defavorable) }}</p>
        </x-card>
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Coût vacations</p>
            <p class="mt-1 text-[1.5rem] font-extrabold text-slate-900 tracking-tight leading-tight">{{ $money($totalVacations) }}</p>
        </x-card>
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Déjà payé</p>
            <p class="mt-1 text-[1.5rem] font-extrabold text-slate-900 tracking-tight leading-tight">{{ $money($payeVacations) }}</p>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
        <x-card title="Informations" class="lg:col-span-2">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div>
                    <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Numéro de lettre</dt>
                    <dd class="mt-1 font-semibold text-slate-700">{{ $mission->numero_lettre }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Date de lettre</dt>
                    <dd class="mt-1 text-slate-700">{{ $mission->date_lettre?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Faculté</dt>
                    <dd class="mt-1 text-slate-700">{{ $mission->faculte?->nom_faculte ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Année académique</dt>
                    <dd class="mt-1 text-slate-700">{{ $mission->anneeAcad?->libelle ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Période</dt>
                    <dd class="mt-1 text-slate-700">
                        {{ $mission->periode_debut?->format('d/m/Y') ?? '—' }} → {{ $mission->periode_fin?->format('d/m/Y') ?? '—' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Statut</dt>
                    <dd class="mt-1"><x-badge :color="$active ? 'emerald' : 'slate'">{{ $active ? 'En cours' : 'Terminée' }}</x-badge></dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Équipe déployée" :subtitle="$mission->equipe?->moyen_transport">
            <div class="space-y-2">
                @forelse ($mission->equipe?->inspecteurs ?? [] as $inspecteur)
                    <div class="flex items-center gap-2.5 rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
                        <div class="w-8 h-8 rounded-lg bg-white text-slate-600 text-[10px] font-bold flex items-center justify-center border border-slate-200">
                            {{ mb_substr($inspecteur->nom_inspecteur, 0, 2) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[13px] font-semibold text-slate-700 truncate">{{ $inspecteur->nom_inspecteur }}</p>
                            <p class="text-[10px] text-slate-400">{{ $inspecteur->pivot->role }}</p>
                        </div>
                    </div>
                @empty
                    <x-empty message="Aucun inspecteur affecté." />
                @endforelse
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <x-card title="Agents présentateurs">
            <div class="space-y-2">
                @forelse ($mission->agents as $agent)
                    <div class="flex items-center gap-2.5 text-sm text-slate-600">
                        <span class="w-2 h-2 rounded-full bg-[#991b1b]"></span>
                        {{ $agent->nom_agent }}
                        @if ($agent->pivot->date_presentation)
                            <span class="ml-auto text-xs text-slate-400">{{ \Illuminate\Support\Carbon::parse($agent->pivot->date_presentation)->format('d/m/Y') }}</span>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Aucun agent rattaché.</p>
                @endforelse
            </div>
        </x-card>

        <x-card title="Vacations de la mission" class="lg:col-span-2" padding="p-0">
            @if ($vacations->isEmpty())
                <x-empty message="Aucune vacation enregistrée pour cette mission." />
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                                <th class="px-5 lg:px-6 py-3 font-semibold">Inspecteur</th>
                                <th class="px-5 lg:px-6 py-3 font-semibold text-right">Montant</th>
                                <th class="px-5 lg:px-6 py-3 font-semibold">Paiement</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($vacations as $vacation)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-5 lg:px-6 py-3.5 text-slate-700">{{ $vacation->inspecteur?->nom_inspecteur ?? '—' }}</td>
                                    <td class="px-5 lg:px-6 py-3.5 text-right font-semibold text-slate-700">{{ $money($vacation->montant) }}</td>
                                    <td class="px-5 lg:px-6 py-3.5">
                                        <x-badge :color="$vacation->date_paiement ? 'emerald' : 'amber'">{{ $vacation->date_paiement ? 'Payée le '.$vacation->date_paiement->format('d/m/Y') : 'En attente' }}</x-badge>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-card>
    </div>
@endsection
