@extends('layouts.app')

@section('title', 'Nouvelle faculté')

@section('content')
    <x-flash />

    <x-page-header title="Nouvelle faculté" :breadcrumb="['Paramètres académiques' => null, 'Facultés' => route('facultes.index'), 'Nouvelle' => null]" />

    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('facultes.store') }}" class="space-y-5">
            @csrf
            <x-input name="nom_faculte" label="Nom de la faculté" :value="old('nom_faculte')" required placeholder="Ex. Faculté des Sciences" />
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Enregistrer</x-btn>
                <x-btn :href="route('facultes.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
