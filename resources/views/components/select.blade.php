@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'help' => null,
])

@php
    $val = old($name, $value);
    $err = $errors->first($name);
    $base = 'w-full h-11 px-4 rounded-xl border text-sm text-slate-700 outline-none transition-all duration-200 ';
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
    <select id="{{ $name }}" name="{{ $name }}" @if ($required) required @endif
        {{ $attributes->merge(['class' => $base.$state]) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" @selected((string) $val === (string) $optValue)>{{ $optLabel }}</option>
        @endforeach
    </select>
    @if ($err)
        <p class="mt-1.5 text-xs text-rose-600">{{ $err }}</p>
    @elseif ($help)
        <p class="mt-1.5 text-xs text-slate-400">{{ $help }}</p>
    @endif
</div>
