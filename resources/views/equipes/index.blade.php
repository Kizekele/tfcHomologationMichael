@extends('layouts.app')

@section('title', "Équipes d'inspection")

@section('content')
    <x-flash />

    <x-page-header title="Équipes d'inspection" subtitle="Composition des équipes et leurs moyens de transport."
        :breadcrumb="['Ordres de mission' => null, 'Équipes d\'inspection' => null]">
        <x-slot:actions>
            <x-btn :href="route('equipes.create')">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Nouvelle équipe
            </x-btn>
        </x-slot:actions>
    </x-page-header>

    @if ($equipes->isEmpty())
        <x-card><x-empty message="Aucune équipe enregistrée." /></x-card>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            @foreach ($equipes as $equipe)
                <x-card>
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-[#7f1d1d]/10 text-[#7f1d1d] flex items-center justify-center font-extrabold text-sm">
                                #{{ $equipe->id_equipe }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Équipe {{ $equipe->id_equipe }}</p>
                                <p class="text-xs text-slate-400">{{ $equipe->moyen_transport ?? 'Transport non défini' }}</p>
                            </div>
                        </div>
                        <x-badge color="sky">{{ $fmt($equipe->missions_count) }} mission(s)</x-badge>
                    </div>

                    <div class="mt-4 space-y-2">
                        @forelse ($equipe->inspecteurs as $inspecteur)
                            <div class="flex items-center gap-2.5 rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
                                <div class="w-7 h-7 rounded-lg bg-white text-slate-600 text-[10px] font-bold flex items-center justify-center border border-slate-200">
                                    {{ mb_substr($inspecteur->nom_inspecteur, 0, 2) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[13px] font-semibold text-slate-700 truncate">{{ $inspecteur->nom_inspecteur }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $inspecteur->pivot->role }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 py-2">Aucun membre affecté.</p>
                        @endforelse
                    </div>

                    <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-100">
                        <x-btn :href="route('equipes.edit', $equipe)" variant="secondary" class="flex-1 h-9">Modifier</x-btn>
                        <form method="POST" action="{{ route('equipes.destroy', $equipe) }}" onsubmit="return confirm('Supprimer cette équipe ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="h-9 px-3 rounded-xl text-sm font-semibold text-rose-600 bg-rose-50 border border-rose-100 hover:bg-rose-100 transition-colors">Supprimer</button>
                        </form>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif
@endsection
