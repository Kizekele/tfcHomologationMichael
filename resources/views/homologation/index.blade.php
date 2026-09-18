@extends('layouts.app')

@section('title', "Saisie des avis")

@section('content')
    <x-flash />

    <x-page-header title="Saisie des avis d'homologation" subtitle="Sélectionnez une mission puis saisissez l'avis pour chaque finaliste."
        :breadcrumb="['Homologation' => null, 'Saisie des avis' => null]">
        <x-slot:actions>
            <x-btn :href="route('homologation.rapports')" variant="secondary">Voir les rapports</x-btn>
        </x-slot:actions>
    </x-page-header>

    @if ($missions->isEmpty())
        <x-card><x-empty message="Aucune mission disponible. Créez d'abord un ordre de mission." /></x-card>
    @else
        <x-card class="mb-5" padding="p-4">
            <form method="GET" action="{{ route('homologation.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
                <x-select name="mission" :options="$missions->mapWithKeys(fn ($m) => [$m->id_mission => $m->numero_lettre.' · '.($m->faculte?->nom_faculte ?? '')])" :value="$mission?->id_mission" onchange="this.form.submit()" />
                <x-input name="q" :value="$q" placeholder="Matricule, nom, postnom ou prénom" />
                <x-select name="statut" :options="['attente' => 'Sans avis', 'traite' => 'Avis saisi']" :value="$statut" placeholder="Tous" />
                <x-btn type="submit" variant="secondary">Filtrer</x-btn>
            </form>
        </x-card>

        @if ($mission)
            <x-card :title="$mission->numero_lettre" :subtitle="$mission->motif" padding="p-0">
                @if (! $etudiants || $etudiants->isEmpty())
                    <x-empty message="Aucun étudiant ne correspond à ces critères pour cette mission." />
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                                    <th class="px-5 lg:px-6 py-3 font-semibold">Étudiant</th>
                                    <th class="px-5 lg:px-6 py-3 font-semibold">Promotion</th>
                                    <th class="px-5 lg:px-6 py-3 font-semibold">Avis actuel</th>
                                    <th class="px-5 lg:px-6 py-3 font-semibold">Saisir / modifier l'avis</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($etudiants as $etudiant)
                                    @php $avis = $avisMap->get($etudiant->matricule); @endphp
                                    <tr class="hover:bg-slate-50/60 transition-colors align-top">
                                        <td class="px-5 lg:px-6 py-3.5">
                                            <a href="{{ route('etudiants.show', $etudiant) }}" class="font-semibold text-slate-700 hover:text-[#991b1b] transition-colors">{{ $etudiant->nom_complet }}</a>
                                            <p class="text-xs text-slate-400 font-mono">{{ $etudiant->matricule }}</p>
                                        </td>
                                        <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $etudiant->promotion?->nom_promotion ?? '—' }}</td>
                                        <td class="px-5 lg:px-6 py-3.5">
                                            @if ($avis)
                                                <x-badge :color="$avis->avis === 'Favorable' ? 'emerald' : 'rose'">{{ $avis->avis }}</x-badge>
                                            @else
                                                <x-badge color="amber">En attente</x-badge>
                                            @endif
                                        </td>
                                        <td class="px-5 lg:px-6 py-3.5">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <form method="POST" action="{{ route('homologation.store') }}" class="flex flex-wrap items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="matricule" value="{{ $etudiant->matricule }}">
                                                    <input type="hidden" name="id_mission" value="{{ $mission->id_mission }}">
                                                    <select name="avis" class="h-9 px-3 rounded-lg border border-slate-200 text-sm text-slate-600 outline-none focus:border-[#991b1b]/40 focus:ring-2 focus:ring-[#991b1b]/10">
                                                        <option value="Favorable" @selected($avis?->avis === 'Favorable')>Favorable</option>
                                                        <option value="Défavorable" @selected($avis?->avis === 'Défavorable')>Défavorable</option>
                                                    </select>
                                                    <input type="text" name="observation" value="{{ $avis?->observation }}" placeholder="Observation (optionnel)"
                                                        class="h-9 px-3 rounded-lg border border-slate-200 text-sm text-slate-600 outline-none focus:border-[#991b1b]/40 focus:ring-2 focus:ring-[#991b1b]/10 w-56">
                                                    <button type="submit" class="h-9 px-3.5 rounded-lg bg-gradient-to-r from-[#7f1d1d] to-[#991b1b] text-white text-xs font-bold hover:brightness-110 transition-all">
                                                        Enregistrer
                                                    </button>
                                                </form>
                                                @if ($avis)
                                                    <form method="POST" action="{{ route('homologation.destroy', [$etudiant->matricule, $mission->id_mission]) }}" onsubmit="return confirm('Supprimer cet avis ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="h-9 px-3 rounded-lg text-xs font-bold text-rose-600 bg-rose-50 border border-rose-100 hover:bg-rose-100 transition-colors">
                                                            Retirer
                                                        </button>
                                                    </form>
                                                @endif
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
        @endif
    @endif
@endsection
