@extends('layouts.app')

@section('title', 'Modifier un inspecteur')

@section('content')
    <x-flash />

    <x-page-header title="Modifier l'inspecteur" :breadcrumb="['Ordres de mission' => null, 'Inspecteurs' => route('inspecteurs.index'), 'Modifier' => null]" />

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('inspecteurs.update', $inspecteur) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-input name="matricule_inspecteur" label="Matricule" :value="$inspecteur->matricule_inspecteur" required />
                <x-input name="nom_inspecteur" label="Nom complet" :value="$inspecteur->nom_inspecteur" required />
                <x-input name="fonction_inspecteur" label="Fonction" :value="$inspecteur->fonction_inspecteur" />
                <x-input name="telephone_inspecteur" label="Téléphone" :value="$inspecteur->telephone_inspecteur" />
            </div>
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Mettre à jour</x-btn>
                <x-btn :href="route('inspecteurs.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
