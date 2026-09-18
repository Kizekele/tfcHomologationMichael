@props(['color' => 'slate'])

@php
    $map = [
        'slate' => 'bg-slate-100 text-slate-600 border-slate-200',
        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'rose' => 'bg-rose-50 text-rose-700 border-rose-100',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-100',
        'sky' => 'bg-sky-50 text-sky-700 border-sky-100',
        'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold border '.($map[$color] ?? $map['slate'])]) }}>
    {{ $slot }}
</span>
