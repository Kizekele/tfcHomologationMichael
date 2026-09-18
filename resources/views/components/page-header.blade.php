@props(['title', 'subtitle' => null, 'breadcrumb' => []])

<div class="flex flex-wrap items-end justify-between gap-4 mb-6">
    <div class="reveal">
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-1.5">
            <a href="{{ route('dashboard') }}" class="hover:text-[#991b1b] transition-colors">Accueil</a>
            @foreach ($breadcrumb as $label => $url)
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                @if ($url)
                    <a href="{{ $url }}" class="hover:text-[#991b1b] transition-colors">{{ $label }}</a>
                @else
                    <span class="text-slate-500 font-medium">{{ $label }}</span>
                @endif
            @endforeach
        </nav>
        <h2 class="text-2xl lg:text-[1.75rem] font-extrabold text-slate-900 tracking-tight">{{ $title }}</h2>
        @if ($subtitle)
            <p class="text-sm text-slate-500 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex items-center gap-2.5 reveal" style="transition-delay:.1s">{{ $actions }}</div>
    @endisset
</div>
