@extends('layouts.app')

@section('title', 'Modifier une promotion')

@section('content')
    <x-flash />

    <x-page-header title="Modifier la promotion" :breadcrumb="['Paramètres académiques' => null, 'Promotions' => route('promotions.index'), 'Modifier' => null]" />

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('promotions.update', $promotion) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-input name="nom_promotion" label="Nom de la promotion" :value="$promotion->nom_promotion" required />
                <x-input name="cycle" label="Cycle" :value="$promotion->cycle" />
            </div>

            <x-select name="id_faculte" label="Faculté" :options="$facultes->pluck('nom_faculte', 'id_faculte')" :value="$promotion->id_faculte" placeholder="Sélectionner une faculté" required />

            @php $selection = old('annees', $promotion->annees->pluck('id_anneeacad')->all()); @endphp
            <div>
                <p class="text-[13px] font-semibold text-slate-700 mb-2">Années académiques</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    @foreach ($annees as $annee)
                        <label class="flex items-center gap-2.5 rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm text-slate-600 cursor-pointer hover:border-[#991b1b]/30 transition-colors">
                            <input type="checkbox" name="annees[]" value="{{ $annee->id_anneeacad }}" @checked(in_array($annee->id_anneeacad, $selection)) class="w-4 h-4 rounded border-slate-300 text-[#991b1b] focus:ring-[#991b1b]/30">
                            {{ $annee->libelle }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-2.5 pt-1">
                <x-btn type="submit">Mettre à jour</x-btn>
                <x-btn :href="route('promotions.index')" variant="secondary">Annuler</x-btn>
            </div>
        </form>
    </x-card>
@endsection
