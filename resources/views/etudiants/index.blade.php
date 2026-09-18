@extends('layouts.app')

@section('title', 'Liste des finalistes')

@section('content')
    <x-flash />

    <x-page-header title="Liste des finalistes" :subtitle="$fmt($etudiants->total()).' dossier(s) enregistré(s)'"
        :breadcrumb="['Gestion des étudiants' => null, 'Liste des finalistes' => null]">
        <x-slot:actions>
            <x-btn :href="route('etudiants.create')">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Ajouter un dossier
            </x-btn>
        </x-slot:actions>
    </x-page-header>

    <x-card class="mb-5" padding="p-4">
        <form method="GET" action="{{ route('etudiants.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <x-input name="q" :value="$q" placeholder="Matricule, nom, postnom ou prénom" />
            <x-select name="faculte" :options="$facultes->pluck('nom_faculte', 'id_faculte')" :value="$faculteId" placeholder="Toutes les facultés" />
            <x-select name="promotion" :options="$promotions->pluck('nom_promotion', 'id_promotion')" :value="$promotionId" placeholder="Toutes les promotions" />
            <x-select name="statut" :options="['homologue' => 'Homologué', 'attente' => 'En attente']" :value="$statut" placeholder="Tous les statuts" />
            <x-btn type="submit" variant="secondary">Filtrer</x-btn>
        </form>
    </x-card>

    <x-card padding="p-0">
        @if ($etudiants->isEmpty())
            <x-empty message="Aucun étudiant ne correspond à ces critères." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">Étudiant</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Promotion</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Faculté</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Avis</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($etudiants as $etudiant)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 text-[11px] font-bold flex items-center justify-center">
                                            {{ $etudiant->initiales }}
                                        </div>
                                        <div>
                                            <a href="{{ route('etudiants.show', $etudiant) }}" class="font-semibold text-slate-700 hover:text-[#991b1b] transition-colors">{{ $etudiant->nom_complet }}</a>
                                            <p class="text-xs text-slate-400 font-mono">{{ $etudiant->matricule }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $etudiant->promotion?->nom_promotion ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $etudiant->promotion?->faculte?->nom_faculte ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    @if ($etudiant->dernier_avis === 'Favorable')
                                        <x-badge color="emerald">Favorable</x-badge>
                                    @elseif ($etudiant->dernier_avis === 'Défavorable')
                                        <x-badge color="rose">Défavorable</x-badge>
                                    @else
                                        <x-badge color="amber">En attente</x-badge>
                                    @endif
                                </td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('etudiants.show', $etudiant) }}" title="Voir" class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#991b1b] hover:bg-[#991b1b]/5 transition-colors">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </a>
                                        <a href="{{ route('etudiants.edit', $etudiant) }}" title="Modifier" class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#991b1b] hover:bg-[#991b1b]/5 transition-colors">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 lg:px-6 py-4 border-t border-slate-100">{{ $etudiants->links() }}</div>
        @endif
    </x-card>
@endsection
