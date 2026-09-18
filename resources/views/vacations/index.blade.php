@extends('layouts.app')

@section('title', 'Finances & Vacations')

@section('content')
    <x-flash />

    <x-page-header title="Finances &amp; Vacations" subtitle="Suivi des frais de vacation payés et en attente."
        :breadcrumb="['Finances & Vacations' => null]">
        <x-slot:actions>
            <x-btn :href="route('vacations.create')">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Nouvelle vacation
            </x-btn>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Montant total</p>
            <p class="mt-1 text-[1.6rem] font-extrabold text-slate-900 tracking-tight leading-tight">{{ $money($totaux['total']) }}</p>
        </x-card>
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">Payé</p>
            <p class="mt-1 text-[1.6rem] font-extrabold text-emerald-600 tracking-tight leading-tight">{{ $money($totaux['paye']) }}</p>
        </x-card>
        <x-card padding="p-5">
            <p class="text-[13px] font-medium text-slate-400">En attente</p>
            <p class="mt-1 text-[1.6rem] font-extrabold text-amber-600 tracking-tight leading-tight">{{ $money($totaux['impaye']) }}</p>
        </x-card>
    </div>

    <x-card class="mb-5" padding="p-4">
        <form method="GET" action="{{ route('vacations.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
            <x-select name="statut" :options="['payees' => 'Payées', 'impayees' => 'En attente']" :value="$statut" placeholder="Tous les statuts" />
            <x-select name="mission" :options="$missions->mapWithKeys(fn ($m) => [$m->id_mission => $m->numero_lettre])" :value="$missionId" placeholder="Toutes les missions" />
            <x-input name="q" :value="$q" placeholder="Nom de l'inspecteur" />
            <x-btn type="submit" variant="secondary">Filtrer</x-btn>
        </form>
    </x-card>

    <x-card padding="p-0">
        @if ($vacations->isEmpty())
            <x-empty message="Aucune vacation trouvée." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">Inspecteur</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Mission</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-right">Montant</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Statut</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($vacations as $vacation)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5">
                                    <p class="font-semibold text-slate-700">{{ $vacation->inspecteur?->nom_inspecteur ?? '—' }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ $vacation->matricule_inspecteur }}</p>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <a href="{{ $vacation->mission ? route('missions.show', $vacation->mission) : '#' }}" class="text-slate-600 hover:text-[#991b1b] transition-colors">{{ $vacation->mission?->numero_lettre ?? '—' }}</a>
                                    <p class="text-xs text-slate-400">{{ $vacation->mission?->faculte?->nom_faculte }}</p>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-right font-semibold text-slate-700">{{ $money($vacation->montant) }}</td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <x-badge :color="$vacation->date_paiement ? 'emerald' : 'amber'">
                                        {{ $vacation->date_paiement ? 'Payée le '.$vacation->date_paiement->format('d/m/Y') : 'En attente' }}
                                    </x-badge>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-2">
                                        @if (! $vacation->date_paiement)
                                            <form method="POST" action="{{ route('vacations.payer', $vacation) }}">
                                                @csrf
                                                <button type="submit" class="h-9 px-3 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-bold hover:bg-emerald-100 transition-colors">
                                                    Marquer payée
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('vacations.destroy', $vacation) }}" onsubmit="return confirm('Supprimer cette vacation ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="h-9 px-3 rounded-lg text-xs font-bold text-rose-600 bg-rose-50 border border-rose-100 hover:bg-rose-100 transition-colors">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 lg:px-6 py-4 border-t border-slate-100">{{ $vacations->links() }}</div>
        @endif
    </x-card>
@endsection
