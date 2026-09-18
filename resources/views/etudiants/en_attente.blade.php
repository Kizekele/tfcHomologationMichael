@extends('layouts.app')

@section('title', 'Dossiers en attente')

@section('content')
    <x-flash />

    <x-page-header title="Dossiers en attente" :subtitle="$fmt($etudiants->total()).' dossier(s) sans avis d\'homologation'"
        :breadcrumb="['Gestion des étudiants' => null, 'Dossiers en attente' => null]">
        <x-slot:actions>
            <x-btn :href="route('homologation.index')">Saisir des avis</x-btn>
        </x-slot:actions>
    </x-page-header>

    <x-card class="mb-5" padding="p-4">
        <form method="GET" action="{{ route('etudiants.en_attente') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
            <x-input name="q" :value="$q" placeholder="Matricule, nom, postnom ou prénom" />
            <x-select name="faculte" :options="$facultes->pluck('nom_faculte', 'id_faculte')" :value="$faculteId" placeholder="Toutes les facultés" />
            <x-btn type="submit" variant="secondary">Filtrer</x-btn>
        </form>
    </x-card>

    <x-card padding="p-0">
        @if ($etudiants->isEmpty())
            <x-empty message="Aucun dossier en attente. Tout est à jour !" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">Étudiant</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Promotion</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Faculté</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Enregistré le</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($etudiants as $etudiant)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5">
                                    <a href="{{ route('etudiants.show', $etudiant) }}" class="font-semibold text-slate-700 hover:text-[#991b1b] transition-colors">{{ $etudiant->nom_complet }}</a>
                                    <p class="text-xs text-slate-400 font-mono">{{ $etudiant->matricule }}</p>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $etudiant->promotion?->nom_promotion ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $etudiant->promotion?->faculte?->nom_faculte ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-500 text-xs">{{ $etudiant->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-right">
                                    <a href="{{ route('etudiants.show', $etudiant) }}" class="text-xs font-bold text-[#991b1b] hover:underline">Ouvrir le dossier</a>
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
