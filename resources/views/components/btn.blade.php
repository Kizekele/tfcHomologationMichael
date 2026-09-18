@props(['href' => null, 'type' => 'submit', 'variant' => 'primary'])

@php
    $variants = [
        'primary' => 'bg-gradient-to-r from-[#7f1d1d] to-[#991b1b] text-white shadow-lg shadow-[#991b1b]/20 hover:brightness-110',
        'secondary' => 'bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:border-slate-300 hover:shadow-sm',
        'danger' => 'bg-rose-50 text-rose-600 border border-rose-100 hover:bg-rose-100',
        'ghost' => 'text-slate-500 hover:text-[#991b1b] hover:bg-[#991b1b]/5',
    ];
    $classes = 'inline-flex items-center justify-center gap-2 h-10 px-4 rounded-xl text-sm font-semibold transition-all active:scale-[.98] '.($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
