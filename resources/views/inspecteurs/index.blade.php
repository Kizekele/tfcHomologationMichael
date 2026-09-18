@extends('layouts.app')

@section('title', 'Inspecteurs')

@section('content')
    <x-flash />

    <x-page-header title="Inspecteurs" subtitle="Corps des inspecteurs mobilisables pour les missions."
        :breadcrumb="['Ordres de mission' => null, 'Inspecteurs' => null]">
        <x-slot:actions>
            <x-btn :href="route('inspecteurs.create')">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Nouvel inspecteur
            </x-btn>
        </x-slot:actions>
    </x-page-header>

    <x-card class="mb-5" padding="p-4">
        <form method="GET" action="{{ route('inspecteurs.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="w-full sm:w-80">
                <x-input name="q" :value="$q" placeholder="Rechercher par nom ou matricule" />
            </div>
            <x-btn type="submit" variant="secondary">Rechercher</x-btn>
        </form>
    </x-card>

    <x-card padding="p-0">
        @if ($inspecteurs->isEmpty())
            <x-empty message="Aucun inspecteur trouvé." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">Inspecteur</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Fonction</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Téléphone</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Équipes</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-center">Vacations</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($inspecteurs as $inspecteur)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5">
                                    <p class="font-semibold text-slate-700">{{ $inspecteur->nom_inspecteur }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ $inspecteur->matricule_inspecteur }}</p>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $inspecteur->fonction_inspecteur ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $inspecteur->telephone_inspecteur ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse ($inspecteur->equipes as $equipe)
                                            <x-badge color="sky">Équipe #{{ $equipe->id_equipe }} · {{ $equipe->pivot->role }}</x-badge>
                                        @empty
                                            <span class="text-slate-400">—</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-center text-slate-600">{{ $fmt($inspecteur->vacations_count) }}</td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('inspecteurs.edit', $inspecteur) }}" title="Modifier" class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#991b1b] hover:bg-[#991b1b]/5 transition-colors">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('inspecteurs.destroy', $inspecteur) }}" onsubmit="return confirm('Supprimer cet inspecteur ?');">
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
            <div class="px-5 lg:px-6 py-4 border-t border-slate-100">{{ $inspecteurs->links() }}</div>
        @endif
    </x-card>
@endsection
