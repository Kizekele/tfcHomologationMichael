@extends('layouts.app')

@section('title', 'Modifier un ordre de mission')

@section('content')
    <x-flash />

    <x-page-header :title="'Modifier ' . $mission->numero_lettre" :breadcrumb="['Ordres de mission' => null, 'Consulter les ordres' => route('missions.index'), 'Modifier' => null]" />

    <x-card class="max-w-4xl">
        @include('missions._form')
    </x-card>
@endsection
