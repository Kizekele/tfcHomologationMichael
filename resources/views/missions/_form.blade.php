@php
    $mission = $mission ?? null;
    $selection = old('agents', $agentsSelectionnes ?? []);
    $equipeOptions = $equipes->mapWithKeys(fn ($e) => [$e->id_equipe => 'Équipe '.$e->id_equipe.($e->moyen_transport ? ' · '.$e->moyen_transport : '')]);
@endphp

<form method="POST" action="{{ $mission ? route('missions.update', $mission) : route('missions.store') }}" class="space-y-5">
    @csrf
    @if ($mission)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <x-input name="numero_lettre" label="Numéro de la lettre" :value="$mission->numero_lettre ?? null" required placeholder="Ex. MIN-ESU/2025/004" />
        <x-input name="date_lettre" type="date" label="Date de la lettre" :value="$mission?->date_lettre?->format('Y-m-d')" required />
        <x-input name="periode_debut" type="date" label="Début de la période" :value="$mission?->periode_debut?->format('Y-m-d')" />
        <x-input name="periode_fin" type="date" label="Fin de la période" :value="$mission?->periode_fin?->format('Y-m-d')" />
        <x-select name="id_equipe" label="Équipe" :options="$equipeOptions" :value="$mission->id_equipe ?? null" placeholder="Sélectionner une équipe" required />
        <x-select name="id_faculte" label="Faculté concernée" :options="$facultes->pluck('nom_faculte', 'id_faculte')" :value="$mission->id_faculte ?? null" placeholder="Sélectionner une faculté" required />
        <x-select name="id_anneeacad" label="Année académique" :options="$annees->pluck('libelle', 'id_anneeacad')" :value="$mission->id_anneeacad ?? null" placeholder="Sélectionner une année" required />
        <x-input name="motif" label="Motif" :value="$mission->motif ?? null" placeholder="Objet de la mission" />
    </div>

    <div>
        <p class="text-[13px] font-semibold text-slate-700 mb-2">Agents présentateurs</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
            @foreach ($agents as $agent)
                <label class="flex items-center gap-2.5 rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-slate-600 cursor-pointer hover:border-[#991b1b]/30 transition-colors">
                    <input type="checkbox" name="agents[]" value="{{ $agent->matricule_agent }}" @checked(in_array($agent->matricule_agent, $selection)) class="w-4 h-4 rounded border-slate-300 text-[#991b1b] focus:ring-[#991b1b]/30">
                    {{ $agent->nom_agent }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex items-center gap-2.5 pt-1">
        <x-btn type="submit">{{ $mission ? 'Mettre à jour' : 'Enregistrer' }}</x-btn>
        <x-btn :href="route('missions.index')" variant="secondary">Annuler</x-btn>
    </div>
</form>
