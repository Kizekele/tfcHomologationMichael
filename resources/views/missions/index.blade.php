@extends('layouts.app')

@section('title', 'Ordres de mission')

@section('content')
    <x-flash />

    <x-page-header title="Ordres de mission" subtitle="Lettres de mission et équipes déployées sur le terrain."
        :breadcrumb="['Ordres de mission' => null, 'Consulter les ordres' => null]">
        <x-slot:actions>
            <x-btn :href="route('missions.create')">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Créer un ordre
            </x-btn>
        </x-slot:actions>
    </x-page-header>

    <x-card class="mb-5" padding="p-4">
        <form method="GET" action="{{ route('missions.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="w-full sm:w-64">
                <x-input name="q" :value="$q" placeholder="N° lettre ou motif" />
            </div>
            <div class="w-full sm:w-56">
                <x-select name="faculte" :options="$facultes->pluck('nom_faculte', 'id_faculte')" :value="$faculteId" placeholder="Toutes les facultés" />
            </div>
            <div class="w-full sm:w-44">
                <x-select name="statut" :options="['actives' => 'En cours', 'terminees' => 'Terminées']" :value="$statut" placeholder="Tous les statuts" />
            </div>
            <x-btn type="submit" variant="secondary">Filtrer</x-btn>
        </form>
    </x-card>

    <x-card padding="p-0">
        @if ($missions->isEmpty())
            <x-empty message="Aucun ordre de mission trouvé." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">N° lettre</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Faculté</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Équipe</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Période</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-center">Avis</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Statut</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($missions as $mission)
                            @php $active = $mission->periode_fin && $mission->periode_fin->isFuture(); @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5">
                                    <a href="{{ route('missions.show', $mission) }}" class="font-semibold text-slate-700 hover:text-[#991b1b] transition-colors">{{ $mission->numero_lettre }}</a>
                                    <p class="text-xs text-slate-400">{{ $mission->date_lettre?->format('d/m/Y') }}</p>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $mission->faculte?->nom_faculte ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">Équipe #{{ $mission->id_equipe }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-500 text-xs">
                                    {{ $mission->periode_debut?->format('d/m/Y') ?? '—' }} → {{ $mission->periode_fin?->format('d/m/Y') ?? '—' }}
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-center text-slate-600">{{ $fmt($mission->homologations_count) }}</td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <x-badge :color="$active ? 'emerald' : 'slate'">{{ $active ? 'En cours' : 'Terminée' }}</x-badge>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('missions.show', $mission) }}" title="Consulter" class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#991b1b] hover:bg-[#991b1b]/5 transition-colors">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </a>
                                        <a href="{{ route('missions.edit', $mission) }}" title="Modifier" class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#991b1b] hover:bg-[#991b1b]/5 transition-colors">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('missions.destroy', $mission) }}" onsubmit="return confirm('Supprimer cet ordre de mission ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Supprimer" class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 lg:px-6 py-4 border-t border-slate-100">{{ $missions->links() }}</div>
        @endif
    </x-card>
@endsection
