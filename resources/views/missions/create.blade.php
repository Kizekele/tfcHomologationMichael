@extends('layouts.app')

@section('title', 'Créer un ordre de mission')

@section('content')
    <x-flash />

    <x-page-header title="Créer un ordre de mission" :breadcrumb="['Ordres de mission' => null, 'Consulter les ordres' => route('missions.index'), 'Créer' => null]" />

    <x-card class="max-w-4xl">
        @include('missions._form')
    </x-card>
@endsection
