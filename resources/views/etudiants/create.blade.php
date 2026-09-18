@extends('layouts.app')

@section('title', 'Ajouter un dossier')

@section('content')
    <x-flash />

    <x-page-header title="Ajouter un dossier étudiant" subtitle="Saisie complète des informations du finaliste."
        :breadcrumb="['Gestion des étudiants' => null, 'Ajouter un dossier' => null]" />

    <x-card class="max-w-5xl">
        @include('etudiants._form')
    </x-card>
@endsection
