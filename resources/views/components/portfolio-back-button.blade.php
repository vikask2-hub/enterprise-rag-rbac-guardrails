@props(['theme' => 'light'])

<a href="{{ route('portfolio') }}"
    {{ $attributes->class([
        'inline-flex min-h-10 items-center justify-center gap-2 rounded-xl border px-3.5 text-[10px] font-extrabold tracking-[-.01em] shadow-sm transition focus-visible:outline-none focus-visible:ring-4',
        'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950 focus-visible:ring-slate-200' => $theme === 'light',
        'border-white/15 bg-white/10 text-white hover:border-white/25 hover:bg-white/15 focus-visible:ring-white/15' => $theme === 'dark',
    ]) }}>
    <svg viewBox="0 0 24 24" aria-hidden="true" class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m15 18-6-6 6-6" />
        <path d="M9 12h10" />
    </svg>
    <span>Back to Portfolio Page</span>
</a>
