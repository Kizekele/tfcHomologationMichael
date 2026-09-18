@php
    $etudiant = $etudiant ?? null;
    $promotionOptions = $promotions->mapWithKeys(fn ($p) => [$p->id_promotion => $p->nom_promotion.' — '.($p->faculte?->nom_faculte ?? '')]);
@endphp

<form method="POST" action="{{ $etudiant ? route('etudiants.update', $etudiant) : route('etudiants.store') }}" class="space-y-6">
    @csrf
    @if ($etudiant)
        @method('PUT')
    @endif

    <div>
        <h3 class="text-sm font-bold text-slate-800 mb-3">Identité de l'étudiant</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <x-input name="matricule" label="Matricule" :value="$etudiant->matricule ?? null" placeholder="Laisser vide pour générer" help="Généré automatiquement si vide." />
            <x-input name="nom" label="Nom" :value="$etudiant->nom ?? null" required />
            <x-input name="postnom" label="Postnom" :value="$etudiant->postnom ?? null" />
            <x-input name="prenom" label="Prénom" :value="$etudiant->prenom ?? null" />
            <x-select name="sexe" label="Sexe" :options="['M' => 'Masculin', 'F' => 'Féminin']" :value="$etudiant->sexe ?? null" placeholder="Sélectionner" required />
            <x-input name="etat_civil" label="État civil" :value="$etudiant->etat_civil ?? null" placeholder="Ex. Célibataire" />
            <x-input name="lieu_naissance" label="Lieu de naissance" :value="$etudiant->lieu_naissance ?? null" />
            <x-input name="date_naissance" type="date" label="Date de naissance" :value="$etudiant->date_naissance ?? null" />
            <x-input name="nationalite" label="Nationalité" :value="$etudiant->nationalite ?? null" placeholder="Ex. Congolaise (RDC)" />
        </div>
    </div>

    <div>
        <h3 class="text-sm font-bold text-slate-800 mb-3">Filiation &amp; contact</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <x-input name="nom_pere" label="Nom du père" :value="$etudiant->nom_pere ?? null" />
            <x-input name="nom_mere" label="Nom de la mère" :value="$etudiant->nom_mere ?? null" />
            <x-input name="province_origine" label="Province d'origine" :value="$etudiant->province_origine ?? null" />
            <x-input name="adresse" label="Adresse" :value="$etudiant->adresse ?? null" />
            <x-input name="telephone" label="Téléphone" :value="$etudiant->telephone ?? null" />
        </div>
    </div>

    <div>
        <h3 class="text-sm font-bold text-slate-800 mb-3">Parcours académique</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <x-select name="id_promotion" label="Promotion" :options="$promotionOptions" :value="$etudiant->id_promotion ?? null" placeholder="Sélectionner une promotion" required />
            <x-input name="option_etude" label="Option d'étude" :value="$etudiant->option_etude ?? null" />
            <x-input name="section" label="Section" :value="$etudiant->section ?? null" />
            <x-input name="diplome_acces" label="Diplôme d'accès" :value="$etudiant->diplome_acces ?? null" placeholder="Ex. Diplôme d'État" />
            <x-input name="pourcentage_diplome" type="number" step="0.01" label="% du diplôme" :value="$etudiant->pourcentage_diplome ?? null" />
            <x-input name="mention" label="Mention" :value="$etudiant->mention ?? null" />
            <x-input name="lieu_delivrance" label="Lieu de délivrance" :value="$etudiant->lieu_delivrance ?? null" />
            <x-input name="date_delivrance" type="date" label="Date de délivrance" :value="$etudiant->date_delivrance ?? null" />
            <x-input name="pourcentage_bulletin" type="number" step="0.01" label="% du bulletin" :value="$etudiant->pourcentage_bulletin ?? null" />
            <x-input name="ecole_provenance" label="École de provenance" :value="$etudiant->ecole_provenance ?? null" />
            <x-input name="code_ecole" label="Code école" :value="$etudiant->code_ecole ?? null" />
            <x-input name="province_ecole" label="Province de l'école" :value="$etudiant->province_ecole ?? null" />
        </div>
    </div>

    <div class="flex items-center gap-2.5 pt-1">
        <x-btn type="submit">{{ $etudiant ? 'Mettre à jour' : 'Enregistrer le dossier' }}</x-btn>
        <x-btn :href="route('etudiants.index')" variant="secondary">Annuler</x-btn>
    </div>
</form>
