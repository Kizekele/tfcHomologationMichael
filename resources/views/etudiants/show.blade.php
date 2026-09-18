@extends('layouts.app')

@section('title', "Dossier de l'étudiant")

@section('content')
    <x-flash />

    <x-page-header :title="$etudiant->nom_complet" :subtitle="$etudiant->matricule"
        :breadcrumb="['Gestion des étudiants' => null, 'Liste des finalistes' => route('etudiants.index'), $etudiant->matricule => null]">
        <x-slot:actions>
            <x-btn :href="route('etudiants.edit', $etudiant)" variant="secondary">Modifier</x-btn>
            <form method="POST" action="{{ route('etudiants.destroy', $etudiant) }}" onsubmit="return confirm('Supprimer ce dossier ?');">
                @csrf
                @method('DELETE')
                <x-btn type="submit" variant="danger">Supprimer</x-btn>
            </form>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">
            <x-card title="Identité">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Nom complet</dt><dd class="mt-1 text-slate-700">{{ $etudiant->nom }} {{ $etudiant->postnom }} {{ $etudiant->prenom }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Sexe</dt><dd class="mt-1 text-slate-700">{{ $etudiant->sexe === 'M' ? 'Masculin' : 'Féminin' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Lieu de naissance</dt><dd class="mt-1 text-slate-700">{{ $etudiant->lieu_naissance ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Date de naissance</dt><dd class="mt-1 text-slate-700">{{ $etudiant->date_naissance ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">État civil</dt><dd class="mt-1 text-slate-700">{{ $etudiant->etat_civil ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Nationalité</dt><dd class="mt-1 text-slate-700">{{ $etudiant->nationalite ?? '—' }}</dd></div>
                </dl>
            </x-card>

            <x-card title="Filiation &amp; contact">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Nom du père</dt><dd class="mt-1 text-slate-700">{{ $etudiant->nom_pere ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Nom de la mère</dt><dd class="mt-1 text-slate-700">{{ $etudiant->nom_mere ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Province d'origine</dt><dd class="mt-1 text-slate-700">{{ $etudiant->province_origine ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Téléphone</dt><dd class="mt-1 text-slate-700">{{ $etudiant->telephone ?? '—' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Adresse</dt><dd class="mt-1 text-slate-700">{{ $etudiant->adresse ?? '—' }}</dd></div>
                </dl>
            </x-card>

            <x-card title="Parcours académique">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Promotion</dt><dd class="mt-1 text-slate-700">{{ $etudiant->promotion?->nom_promotion ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Faculté</dt><dd class="mt-1 text-slate-700">{{ $etudiant->promotion?->faculte?->nom_faculte ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Option</dt><dd class="mt-1 text-slate-700">{{ $etudiant->option_etude ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Diplôme d'accès</dt><dd class="mt-1 text-slate-700">{{ $etudiant->diplome_acces ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Mention</dt><dd class="mt-1 text-slate-700">{{ $etudiant->mention ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">% bulletin</dt><dd class="mt-1 text-slate-700">{{ $etudiant->pourcentage_bulletin ? $etudiant->pourcentage_bulletin.'%' : '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">École de provenance</dt><dd class="mt-1 text-slate-700">{{ $etudiant->ecole_provenance ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Code école</dt><dd class="mt-1 text-slate-700">{{ $etudiant->code_ecole ?? '—' }}</dd></div>
                </dl>
            </x-card>
        </div>

        <div class="space-y-5">
            <x-card title="Historique des avis" :subtitle="$fmt($etudiant->homologations->count()).' avis'">
                @if ($etudiant->homologations->isEmpty())
                    <x-empty message="Aucun avis enregistré pour cet étudiant." />
                @else
                    <div class="space-y-3">
                        @foreach ($etudiant->homologations->sortByDesc('date_avis') as $avis)
                            <div class="rounded-2xl border border-slate-100 bg-slate-50/60 px-4 py-3">
                                <div class="flex items-center justify-between gap-2">
                                    <x-badge :color="$avis->avis === 'Favorable' ? 'emerald' : 'rose'">{{ $avis->avis }}</x-badge>
                                    <span class="text-[11px] text-slate-400">{{ $avis->date_avis?->format('d/m/Y') }}</span>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">{{ $avis->mission?->numero_lettre }} · {{ $avis->mission?->faculte?->nom_faculte }}</p>
                                @if ($avis->numero_fiche)
                                    <p class="text-[11px] text-slate-400 mt-1 font-mono">{{ $avis->numero_fiche }}</p>
                                @endif
                                @if ($avis->observation)
                                    <p class="mt-1.5 text-xs text-slate-500 italic">« {{ $avis->observation }} »</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-card>
        </div>
    </div>
@endsection
