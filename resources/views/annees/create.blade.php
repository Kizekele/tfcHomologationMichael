@extends('layouts.app')

@section('title', 'Nouvelle année académique')

@section('content')
    <x-flash />

    <x-page-header title="Nouvelle année académique" :breadcrumb="['Paramètres académiques' => null, 'Années académiques' => route('annees.index'), 'Nouvelle' => null]" />

    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('annees.store') }}" class="space-y-5">
            @csrf
            <x-input name="libelle" label="Libellé" :value="old('libelle')" required placeholder="Ex. 2025-2026" help="Format attendu : AAAA-AAAA" />
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Enregistrer</x-btn>
                <x-btn :href="route('annees.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
