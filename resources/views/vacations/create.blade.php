@extends('layouts.app')

@section('title', 'Nouvelle vacation')

@section('content')
    <x-flash />

    <x-page-header title="Nouvelle vacation" :breadcrumb="['Finances & Vacations' => route('vacations.index'), 'Nouvelle' => null]" />

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('vacations.store') }}" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-select name="id_mission" label="Mission" :options="$missions->mapWithKeys(fn ($m) => [$m->id_mission => $m->numero_lettre.' · '.($m->faculte?->nom_faculte ?? '')])" :value="old('id_mission')" placeholder="Sélectionner une mission" required />
                <x-select name="matricule_inspecteur" label="Inspecteur" :options="$inspecteurs->pluck('nom_inspecteur', 'matricule_inspecteur')" :value="old('matricule_inspecteur')" placeholder="Sélectionner un inspecteur" required />
                <x-input name="montant" type="number" step="0.01" label="Montant (FC)" :value="old('montant', 300000)" required />
                <x-input name="date_paiement" type="date" label="Date de paiement" :value="old('date_paiement')" help="Laisser vide si la vacation est en attente." />
            </div>
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Enregistrer</x-btn>
                <x-btn :href="route('vacations.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
