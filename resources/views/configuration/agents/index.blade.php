@extends('layouts.app')

@section('title', 'Agents')

@section('content')
    <x-flash />

    <x-page-header title="Agents du système" subtitle="Comptes autorisés à accéder à la plateforme."
        :breadcrumb="['Configuration du Système' => route('configuration.index'), 'Agents' => null]">
        <x-slot:actions>
            <x-btn :href="route('configuration.agents.create')">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Nouvel agent
            </x-btn>
        </x-slot:actions>
    </x-page-header>

    <x-card padding="p-0">
        @if ($agents->isEmpty())
            <x-empty message="Aucun agent enregistré." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-wide text-slate-400 border-b border-slate-100">
                            <th class="px-5 lg:px-6 py-3 font-semibold">Agent</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Fonction</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Rôle</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold">Dernière connexion</th>
                            <th class="px-5 lg:px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($agents as $agent)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-[#7f1d1d]/10 text-[#7f1d1b] text-[11px] font-bold flex items-center justify-center text-[#7f1d1d]">
                                            {{ $agent->initiales }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-700">{{ $agent->nom_agent }}</p>
                                            <p class="text-xs text-slate-400 font-mono">{{ $agent->matricule_agent }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-600">{{ $agent->fonction_agent ?? '—' }}</td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <x-badge :color="$agent->isAdmin() ? 'indigo' : 'slate'">{{ ucfirst($agent->role) }}</x-badge>
                                </td>
                                <td class="px-5 lg:px-6 py-3.5 text-slate-500 text-xs">{{ $agent->last_login_at?->format('d/m/Y H:i') ?? 'Jamais connecté' }}</td>
                                <td class="px-5 lg:px-6 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('configuration.agents.edit', $agent) }}" title="Modifier" class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#991b1b] hover:bg-[#991b1b]/5 transition-colors">
                                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('configuration.agents.destroy', $agent) }}" onsubmit="return confirm('Supprimer cet agent ?');">
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
        @endif
    </x-card>
@endsection
