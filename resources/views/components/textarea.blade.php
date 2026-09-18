@props([
    'name',
    'label' => null,
    'value' => null,
    'rows' => 3,
    'required' => false,
    'placeholder' => '',
    'help' => null,
])

@php
    $val = old($name, $value);
    $err = $errors->first($name);
    $base = 'w-full px-4 py-3 rounded-xl border text-sm text-slate-700 placeholder:text-slate-400 outline-none transition-all duration-200 ';
    $state = $err
        ? 'border-rose-300 bg-rose-50 focus:border-rose-400 focus:ring-2 focus:ring-rose-100'
        : 'border-slate-200 bg-white focus:border-[#991b1b]/40 focus:ring-2 focus:ring-[#991b1b]/10';
@endphp

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-[13px] font-semibold text-slate-700 mb-1.5">
            {{ $label }}@if ($required)<span class="text-rose-500"> *</span>@endif
        </label>
    @endif
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => $base.$state]) }}>{{ $val }}</textarea>
    @if ($err)
        <p class="mt-1.5 text-xs text-rose-600">{{ $err }}</p>
    @elseif ($help)
        <p class="mt-1.5 text-xs text-slate-400">{{ $help }}</p>
    @endif
</div>
