@extends('layouts.app')

@section('title', 'Modifier une faculté')

@section('content')
    <x-flash />

    <x-page-header title="Modifier la faculté" :breadcrumb="['Paramètres académiques' => null, 'Facultés' => route('facultes.index'), 'Modifier' => null]" />

    <x-card class="max-w-2xl">
        <form method="POST" action="{{ route('facultes.update', $faculte) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <x-input name="nom_faculte" label="Nom de la faculté" :value="$faculte->nom_faculte" required />
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Mettre à jour</x-btn>
                <x-btn :href="route('facultes.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
