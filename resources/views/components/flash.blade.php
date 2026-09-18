@if (session('success'))
    <div class="flash-msg mb-5 flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-700">
        <svg class="w-5 h-5 shrink-0 mt-px" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="flex-1">{{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 leading-none text-lg">&times;</button>
    </div>
@endif

@if (session('error'))
    <div class="flash-msg mb-5 flex items-start gap-3 rounded-2xl border border-rose-100 bg-rose-50 px-4 py-3.5 text-sm text-rose-700">
        <svg class="w-5 h-5 shrink-0 mt-px" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
        <span class="flex-1">{{ session('error') }}</span>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 leading-none text-lg">&times;</button>
    </div>
@endif
