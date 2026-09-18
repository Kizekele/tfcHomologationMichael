@props(['title' => null, 'subtitle' => null, 'padding' => 'p-5 lg:p-6'])

<div {{ $attributes->merge(['class' => 'reveal bg-white rounded-3xl border border-slate-200/70 shadow-sm']) }}>
    @if ($title || isset($actions))
        <div class="flex items-center justify-between gap-3 px-5 lg:px-6 py-4 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-800">{{ $title }}</h3>
                @if ($subtitle)
                    <p class="text-xs text-slate-400 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex items-center gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif
    <div class="{{ $padding }}">{{ $slot }}</div>
</div>
