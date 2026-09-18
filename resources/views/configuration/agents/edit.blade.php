@extends('layouts.app')

@section('title', 'Modifier un agent')

@section('content')
    <x-flash />

    <x-page-header :title="'Modifier ' . $agent->nom_agent" :breadcrumb="['Configuration du Système' => route('configuration.index'), 'Agents' => route('configuration.agents.index'), 'Modifier' => null]" />

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('configuration.agents.update', $agent) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-input name="matricule_agent" label="Matricule" :value="$agent->matricule_agent" required />
                <x-input name="nom_agent" label="Nom complet" :value="$agent->nom_agent" required />
                <x-input name="email" type="email" label="Adresse email" :value="$agent->email" />
                <x-input name="password" type="password" label="Nouveau mot de passe" help="Laisser vide pour conserver l'actuel." />
                <x-select name="role" label="Rôle" :options="['agent' => 'Agent', 'admin' => 'Administrateur']" :value="$agent->role" placeholder="Sélectionner un rôle" required />
                <x-input name="fonction_agent" label="Fonction" :value="$agent->fonction_agent" />
                <x-input name="telephone_agent" label="Téléphone" :value="$agent->telephone_agent" />
            </div>
            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Mettre à jour</x-btn>
                <x-btn :href="route('configuration.agents.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
