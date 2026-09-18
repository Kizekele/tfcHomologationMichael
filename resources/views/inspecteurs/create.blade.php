@extends('layouts.app')

@section('title', 'Nouvel inspecteur')

@section('content')
    <x-flash />

    <x-page-header title="Nouvel inspecteur" :breadcrumb="['Ordres de mission' => null, 'Inspecteurs' => route('inspecteurs.index'), 'Nouveau' => null]" />

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('inspecteurs.store') }}" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-input name="matricule_inspecteur" label="Matricule" :value="old('matricule_inspecteur')" required placeholder="Ex. INSP-010" />
                <x-input name="nom_inspecteur" label="Nom complet" :value="old('nom_inspecteur')" required />
                <x-input name="fonction_inspecteur" label="Fonction" :value="old('fonction_inspecteur')" placeholder="Ex. Inspecteur Principal" />
                <x-input name="telephone_inspecteur" label="Téléphone" :value="old('telephone_inspecteur')" placeholder="+243 ..." />
            </div>
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Enregistrer</x-btn>
                <x-btn :href="route('inspecteurs.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
