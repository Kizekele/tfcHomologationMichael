@extends('layouts.app')

@section('title', 'Modifier une équipe')

@section('content')
    <x-flash />

    <x-page-header :title="'Modifier l\'équipe ' . $equipe->id_equipe" :breadcrumb="['Ordres de mission' => null, 'Équipes d\'inspection' => route('equipes.index'), 'Modifier' => null]" />

    @php
        $selection = old('inspecteurs', $equipe->inspecteurs->pluck('matricule_inspecteur')->all());
        $roles = old('roles', $equipe->inspecteurs->pluck('pivot.role', 'matricule_inspecteur')->all());
    @endphp

    <x-card class="max-w-4xl">
        <form method="POST" action="{{ route('equipes.update', $equipe) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <x-input name="moyen_transport" label="Moyen de transport" :value="$equipe->moyen_transport" />

            <div>
                <p class="text-[13px] font-semibold text-slate-700 mb-2">Membres de l'équipe</p>
                <div class="space-y-2">
                    @foreach ($inspecteurs as $inspecteur)
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 rounded-xl border border-slate-200 px-3.5 py-2.5">
                            <label class="flex items-center gap-2.5 flex-1 cursor-pointer">
                                <input type="checkbox" name="inspecteurs[]" value="{{ $inspecteur->matricule_inspecteur }}" @checked(in_array($inspecteur->matricule_inspecteur, $selection)) class="w-4 h-4 rounded border-slate-300 text-[#991b1b] focus:ring-[#991b1b]/30">
                                <span class="text-sm text-slate-700 font-medium">{{ $inspecteur->nom_inspecteur }}</span>
                                <span class="text-xs text-slate-400 font-mono">{{ $inspecteur->matricule_inspecteur }}</span>
                            </label>
                            <input type="text" name="roles[{{ $inspecteur->matricule_inspecteur }}]" value="{{ $roles[$inspecteur->matricule_inspecteur] ?? 'Membre' }}"
                                class="h-9 px-3 rounded-lg border border-slate-200 text-sm text-slate-600 outline-none focus:border-[#991b1b]/40 focus:ring-2 focus:ring-[#991b1b]/10 sm:w-48" placeholder="Rôle">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Mettre à jour</x-btn>
                <x-btn :href="route('equipes.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
