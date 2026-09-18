@extends('layouts.app')

@section('title', 'Modifier un dossier')

@section('content')
    <x-flash />

    <x-page-header :title="'Modifier ' . $etudiant->nom_complet" :breadcrumb="['Gestion des étudiants' => null, 'Liste des finalistes' => route('etudiants.index'), 'Modifier' => null]" />

    <x-card class="max-w-5xl">
        @include('etudiants._form')
    </x-card>
@endsection
