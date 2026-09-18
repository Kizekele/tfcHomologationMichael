@extends('layouts.app')

@section('title', 'Nouvel agent')

@section('content')
    <x-flash />

    <x-page-header title="Nouvel agent" :breadcrumb="['Configuration du Système' => route('configuration.index'), 'Agents' => route('configuration.agents.index'), 'Nouveau' => null]" />

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('configuration.agents.store') }}" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-input name="matricule_agent" label="Matricule" :value="old('matricule_agent')" required placeholder="Ex. AG-007" />
                <x-input name="nom_agent" label="Nom complet" :value="old('nom_agent')" required />
                <x-input name="email" type="email" label="Adresse email" :value="old('email')" placeholder="prenom.nom@esu.cd" />
                <x-input name="password" type="password" label="Mot de passe" required help="6 caractères minimum." />
                <x-select name="role" label="Rôle" :options="['agent' => 'Agent', 'admin' => 'Administrateur']" :value="old('role', 'agent')" placeholder="Sélectionner un rôle" required />
                <x-input name="fonction_agent" label="Fonction" :value="old('fonction_agent')" placeholder="Ex. Chef de Bureau" />
                <x-input name="telephone_agent" label="Téléphone" :value="old('telephone_agent')" placeholder="+243 ..." />
            </div>
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Enregistrer</x-btn>
                <x-btn :href="route('configuration.agents.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
