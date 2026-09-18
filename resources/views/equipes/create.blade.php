@extends('layouts.app')

@section('title', 'Nouvelle équipe')

@section('content')
    <x-flash />

    <x-page-header title="Nouvelle équipe d'inspection" :breadcrumb="['Ordres de mission' => null, 'Équipes d\'inspection' => route('equipes.index'), 'Nouvelle' => null]" />

    <x-card class="max-w-4xl">
        <form method="POST" action="{{ route('equipes.store') }}" class="space-y-5">
            @csrf
            <x-input name="moyen_transport" label="Moyen de transport" :value="old('moyen_transport')" placeholder="Ex. Toyota Hilux" />

            <div>
                <p class="text-[13px] font-semibold text-slate-700 mb-2">Membres de l'équipe</p>
                <div class="space-y-2">
                    @foreach ($inspecteurs as $inspecteur)
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 rounded-xl border border-slate-200 px-3.5 py-2.5">
                            <label class="flex items-center gap-2.5 flex-1 cursor-pointer">
                                <input type="checkbox" name="inspecteurs[]" value="{{ $inspecteur->matricule_inspecteur }}" @checked(in_array($inspecteur->matricule_inspecteur, old('inspecteurs', []))) class="w-4 h-4 rounded border-slate-300 text-[#991b1b] focus:ring-[#991b1b]/30">
                                <span class="text-sm text-slate-700 font-medium">{{ $inspecteur->nom_inspecteur }}</span>
                                <span class="text-xs text-slate-400 font-mono">{{ $inspecteur->matricule_inspecteur }}</span>
                            </label>
                            <input type="text" name="roles[{{ $inspecteur->matricule_inspecteur }}]" value="{{ old('roles.'.$inspecteur->matricule_inspecteur, 'Membre') }}"
                                class="h-9 px-3 rounded-lg border border-slate-200 text-sm text-slate-600 outline-none focus:border-[#991b1b]/40 focus:ring-2 focus:ring-[#991b1b]/10 sm:w-48" placeholder="Rôle">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Enregistrer</x-btn>
                <x-btn :href="route('equipes.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
