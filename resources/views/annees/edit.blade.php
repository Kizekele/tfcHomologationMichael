@extends('layouts.app')

@section('title', 'Modifier une année académique')

@section('content')
    <x-flash />

    <x-page-header title="Modifier l'année académique" :breadcrumb="['Paramètres académiques' => null, 'Années académiques' => route('annees.index'), 'Modifier' => null]" />

    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('annees.update', $annee) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <x-input name="libelle" label="Libellé" :value="$annee->libelle" required placeholder="Ex. 2025-2026" />
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Mettre à jour</x-btn>
                <x-btn :href="route('annees.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
