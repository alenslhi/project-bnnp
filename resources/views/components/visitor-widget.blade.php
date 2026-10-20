{{-- ═══ WIDGET PENGUNJUNG WEBSITE (Sesuai Gambar 1) ═══ --}}
<div onclick="openVisitorModal()"
     class="cursor-pointer group select-none bg-white dark:bg-surface-800 rounded-2xl p-4 sm:p-5 shadow-xl hover:shadow-2xl border border-surface-200/80 dark:border-white/10 transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500/40">
    <div class="flex items-center gap-4">
        {{-- Icon Mata dalam Lingkaran Hijau Muda (Sesuai Gambar 1) --}}
        <div class="h-12 w-12 rounded-full bg-[#e8f5e9] dark:bg-emerald-950/60 text-[#2e7d32] dark:text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-200/60 dark:border-emerald-500/30 group-hover:scale-110 transition-transform">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-[10px] sm:text-[11px] font-bold text-surface-500 dark:text-surface-400 uppercase tracking-wider">
                PENGUNJUNG WEBSITE
            </span>
            <div class="flex items-baseline gap-2 mt-0.5">
                <span id="visitor-total-main" class="text-2xl sm:text-3xl font-black text-surface-900 dark:text-white tracking-tight">
                    {{ number_format($totalPengunjung ?? 0, 0, ',', '.') }}
                </span>
                <span class="inline-flex items-center text-xs sm:text-[13px] font-bold text-emerald-600 dark:text-emerald-400">
                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span id="visitor-today-main">{{ $pengunjungHariIni ?? 0 }}</span>&nbsp;hari ini
                </span>
            </div>
        </div>
    </div>
</div>
