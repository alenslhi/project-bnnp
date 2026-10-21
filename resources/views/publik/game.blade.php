@extends('layouts.publik')

@section('title', 'Mini Games: Mitos/Fakta & Wordle')

@push('styles')
<style>
    /* Wordle Flip Animation */
    .wordle-tile {
        perspective: 1000px;
        transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.4s ease, border-color 0.4s ease, color 0.4s ease;
    }
    .wordle-tile.pop {
        animation: tilePop 0.12s ease-in-out;
    }
    .wordle-tile.flip {
        animation: tileFlip 0.5s ease forwards;
    }
    @keyframes tilePop {
        0% { transform: scale(1); }
        50% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }
    @keyframes tileFlip {
        0% { transform: rotateX(0deg); }
        50% { transform: rotateX(90deg); }
        100% { transform: rotateX(0deg); }
    }
    /* Shake animation for invalid word or wrong guess */
    .shake-row {
        animation: shake 0.45s ease-in-out;
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        15%, 45%, 75% { transform: translateX(-6px); }
        30%, 60%, 90% { transform: translateX(6px); }
    }
    /* Pulse glow */
    .glow-gold {
        box-shadow: 0 0 25px rgba(245, 158, 11, 0.35);
    }
    /* Confetti animation */
    @keyframes confettiFall {
        0% { transform: translateY(-20px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
    }
    .confetti-piece {
        position: fixed;
        width: 10px;
        height: 10px;
        pointer-events: none;
        z-index: 9999;
        animation: confettiFall 3s ease-out forwards;
    }
</style>
@endpush

@section('content')
<div class="relative min-h-[calc(100vh-4rem)] overflow-hidden py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
    {{-- Ambient Gradients --}}
    <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-gradient-to-b from-primary-500/15 via-amber-500/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative mx-auto max-w-3xl">

        {{-- ═══ TOP CONTROLS & HEADER ═══ --}}
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-surface-200 dark:border-white/10">
            <div class="flex items-center gap-3">
                <a href="{{ route('beranda') }}" class="p-2 rounded-xl border border-surface-200 dark:border-white/10 text-surface-500 hover:text-surface-900 dark:hover:text-white transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black uppercase tracking-wider text-primary-600 dark:text-primary-400">SKENA MINI GAMES</span>
                        <span id="header-mode-badge" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-500/20 text-primary-600 dark:text-primary-400 border border-primary-500/30">Mitos/Fakta & Wordle</span>
                    </div>
                    <h1 class="text-lg sm:text-xl font-black text-surface-900 dark:text-white tracking-tight">5 Mitos/Fakta & Wordle</h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                {{-- Audio Mute/Unmute --}}
                <button id="btn-toggle-sound" type="button" class="p-2.5 rounded-xl border border-surface-200 dark:border-white/10 text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5 transition" title="Suara Efek (Aktif/Mati)">
                    <span id="sound-icon-on">🔊</span>
                    <span id="sound-icon-off" class="hidden">🔇</span>
                </button>
                {{-- Help Modal --}}
                <button id="btn-open-help" type="button" class="p-2.5 rounded-xl border border-surface-200 dark:border-white/10 text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5 transition" title="Petunjuk Bermain">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>
                </button>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════ --}}
        {{-- VIEW 1: INTRO SCREEN (Before Starting)                   --}}
        {{-- ══════════════════════════════════════════════════════════ --}}
        <div id="view-intro" class="space-y-6">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-900 via-primary-950 to-surface-950 p-6 sm:p-10 border border-primary-500/30 text-white shadow-2xl">
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 mb-4 text-xs font-semibold backdrop-blur-sm text-primary-200">
                        <span>📅</span>
                        <span>{{ $todayFormatted }}</span>
                        <span class="text-white/40">•</span>
                        <span>Edisi #{{ $puzzle['set_number'] }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                        Mini Games Edukasi Anti-Narkotika
                    </h2>
                    <p class="mt-2 text-primary-200 text-sm leading-relaxed max-w-xl">
                        Tema: <strong class="text-white font-bold">{{ $puzzle['theme'] }}</strong>.
                        Selesaikan 2 babak edukatif yang saling terhubung untuk mengasah ketajaman wawasanmu!
                    </p>

                    <div class="mt-6 space-y-3">
                        <div class="flex items-start gap-3.5 rounded-2xl bg-white/5 border border-white/10 p-3.5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-500/20 text-primary-300 font-bold text-sm">1</div>
                            <div>
                                <h3 class="text-sm font-bold text-white">Babak 1: 5 Mitos atau Fakta</h3>
                                <p class="text-xs text-primary-200/80 mt-0.5">Jawab 5 pernyataan seputar bahaya narkoba. Pelajari penjelasannya untuk memperkaya wawasan sebelum melangkah ke babak berikutnya.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 rounded-2xl bg-white/5 border border-white/10 p-3.5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-amber-500/20 text-amber-300 font-bold text-sm">2</div>
                            <div>
                                <h3 class="text-sm font-bold text-white">Babak 2: Wordle (Tebak 2 Kata Kunci)</h3>
                                <p class="text-xs text-primary-200/80 mt-0.5">Tebak <strong>2 istilah kunci seputar pencegahan narkotika</strong> berdasarkan pemahaman yang telah kamu peroleh (panjang kata 3 hingga 11 huruf). Maksimal 6 kesempatan per kata!</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        <button id="btn-start-game" type="button" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-surface-950 font-black px-8 py-4 text-base shadow-xl hover:shadow-amber-500/25 transition-all hover:scale-[1.02] cursor-pointer">
                            <span>Mulai Mini Games</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </button>
                        <span class="text-xs text-primary-300/80 text-center sm:text-left flex items-center justify-center sm:justify-start gap-1.5">
                            <svg class="h-4 w-4 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd"/></svg>
                            Asah wawasan & ketangkasan kata
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════ --}}
        {{-- VIEW 2: BABAK 1 - MITOS ATAU FAKTA (Alur Interaktif SKENA) --}}
        {{-- ══════════════════════════════════════════════════════════ --}}
        <div id="view-myth-fact" class="hidden space-y-6">
            {{-- Progress Bar Edukasi SKENA --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between text-xs font-bold text-surface-500 dark:text-surface-400">
                    <span id="quiz-progress-label">Pertanyaan 1 dari 5</span>
                    <span id="quiz-remedial-badge" class="hidden px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 animate-pulse">
                        🔁 Ulangi Pertanyaan
                    </span>
                    <span id="quiz-score-badge" class="text-primary-600 dark:text-primary-400">Tuntas: <span id="quiz-mastered-count">0</span>/5</span>
                </div>
                <div class="h-3.5 w-full bg-surface-200 dark:bg-surface-800 rounded-full overflow-hidden p-0.5">
                    <div id="quiz-progress-bar" class="h-full bg-gradient-to-r from-emerald-500 to-accent-400 rounded-full transition-all duration-500 w-0"></div>
                </div>
            </div>

            {{-- Announcement Alert (Ulangi Pertanyaan) --}}
            <div id="remedial-alert-banner" class="hidden rounded-2xl border border-amber-500/40 bg-amber-500/10 p-4 text-amber-800 dark:text-amber-300 text-xs sm:text-sm flex items-start gap-3">
                <span class="text-2xl shrink-0">🔁</span>
                <div>
                    <h4 class="font-black text-amber-900 dark:text-amber-200">Ulangi Pertanyaan yang Belum Tepat</h4>
                    <p class="mt-0.5 text-amber-800/90 dark:text-amber-300/90 leading-relaxed">
                        Terdapat <strong id="remedial-count-text">1</strong> pernyataan yang belum tepat. Ayo jawab kembali sekarang agar pemahamanmu semakin mantap!
                    </p>
                </div>
            </div>

            {{-- Question Card --}}
            <div class="rounded-3xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/90 p-6 sm:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <span id="question-badge" class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-primary-50 dark:bg-primary-500/10 text-primary-700 dark:text-primary-300">
                        Kategori
                    </span>
                    <span id="question-remedial-pill" class="hidden text-[11px] font-bold text-amber-600 dark:text-amber-400 flex items-center gap-1">
                        <span>🔁</span> Pengulangan
                    </span>
                </div>

                {{-- Statement --}}
                <div class="min-h-[120px] flex items-center">
                    <p id="question-statement" class="text-xl sm:text-2xl font-black text-surface-900 dark:text-white leading-relaxed">
                        Pertanyaan akan dimuat di sini...
                    </p>
                </div>

                {{-- Myth / Fact Choices --}}
                <div id="quiz-options-container" class="mt-8 grid grid-cols-2 gap-4">
                    {{-- MITOS Button --}}
                    <button id="btn-choose-mitos" type="button" class="group relative flex flex-col items-center justify-center p-5 sm:p-6 rounded-2xl border-2 border-danger-500/30 bg-danger-500/5 hover:bg-danger-500/15 hover:border-danger-500 transition-all hover:scale-[1.02] cursor-pointer">
                        <span class="text-3xl sm:text-4xl mb-2 transition-transform group-hover:scale-110">❌</span>
                        <span class="text-lg sm:text-xl font-black text-danger-600 dark:text-danger-400 tracking-wide">MITOS</span>
                        <span class="text-[11px] text-surface-400 mt-1">Pernyataan salah</span>
                    </button>

                    {{-- FAKTA Button --}}
                    <button id="btn-choose-fakta" type="button" class="group relative flex flex-col items-center justify-center p-5 sm:p-6 rounded-2xl border-2 border-accent-500/30 bg-accent-500/5 hover:bg-accent-500/15 hover:border-accent-500 transition-all hover:scale-[1.02] cursor-pointer">
                        <span class="text-3xl sm:text-4xl mb-2 transition-transform group-hover:scale-110">✅</span>
                        <span class="text-lg sm:text-xl font-black text-accent-600 dark:text-accent-400 tracking-wide">FAKTA</span>
                        <span class="text-[11px] text-surface-400 mt-1">Pernyataan benar</span>
                    </button>
                </div>

                {{-- Explanation Drawer (Shown after answering) --}}
                <div id="quiz-feedback-box" class="hidden mt-6 pt-6 border-t border-surface-200 dark:border-white/10 space-y-4">
                    {{-- Result Header --}}
                    <div id="feedback-header" class="flex items-center gap-2 text-base font-black">
                        <span id="feedback-icon" class="text-xl"></span>
                        <span id="feedback-title"></span>
                    </div>

                    {{-- Explanation Text --}}
                    <div class="rounded-2xl bg-surface-100 dark:bg-surface-800/80 p-4 border border-surface-200 dark:border-white/5">
                        <h4 class="text-xs font-bold text-surface-500 dark:text-surface-400 uppercase tracking-wider mb-1">Penjelasan:</h4>
                        <p id="feedback-explanation" class="text-sm text-surface-800 dark:text-surface-200 leading-relaxed"></p>
                    </div>

                    {{-- Next Button --}}
                    <div class="flex justify-end pt-2">
                        <button id="btn-next-question" type="button" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold px-6 py-3 text-sm shadow-md transition cursor-pointer">
                            <span id="btn-next-question-label">Lanjut Pertanyaan</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════ --}}
        {{-- VIEW 3: BABAK 1 SELESAI - TRANSISI KE WORDLE              --}}
        {{-- ══════════════════════════════════════════════════════════ --}}
        <div id="view-phase1-complete" class="hidden space-y-6">
            <div class="rounded-3xl border border-emerald-500/30 bg-gradient-to-br from-emerald-950/40 via-surface-900 to-surface-950 p-6 sm:p-10 text-center shadow-2xl">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-500/20 text-emerald-400 text-4xl mb-4 border border-emerald-400/30 glow-gold">
                    🎉
                </div>

                <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 mb-2">
                    Babak 1 Tuntas!
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white">5 Mitos vs Fakta Berhasil Dikuasai!</h2>
                <p class="mt-2 text-surface-300 text-sm max-w-lg mx-auto leading-relaxed">
                    Kerja bagus! Kamu telah menyelesaikan seluruh pernyataan edukasi. Sekarang gunakan pemahaman yang telah kamu peroleh untuk menuntaskan babak akhir: <strong>Tebak 2 Kata (Wordle)</strong>.
                </p>

                <div class="mt-8 flex justify-center">
                    <button id="btn-proceed-to-wordle" type="button" class="inline-flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-surface-950 font-black px-8 py-4 text-base shadow-xl transition-all hover:scale-105 cursor-pointer">
                        <span>Lanjut ke Papan Wordle</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════ --}}
        {{-- VIEW 4: BABAK 2 - WORDLE GAME BOARD (2 KATA)              --}}
        {{-- ══════════════════════════════════════════════════════════ --}}
        <div id="view-wordle" class="hidden space-y-6">
            {{-- Stage Indicator (Kata 1 vs Kata 2) --}}
            <div class="flex items-center justify-between rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/80 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-500/15 text-primary-600 dark:text-primary-400 font-black text-lg">
                        <span id="wordle-current-step">1</span>/2
                    </div>
                    <div>
                        <h3 id="wordle-stage-title" class="text-sm font-black text-surface-900 dark:text-white">Tebak Kata 1 dari 2</h3>
                        <p id="wordle-stage-subtitle" class="text-[11px] text-surface-500 dark:text-surface-400">Kata Huruf Bebas • Maks. 6 Percobaan</p>
                    </div>
                </div>

                {{-- Status indicators --}}
                <div class="flex items-center gap-2">
                    <span id="wordle-indicator-w1" class="px-2.5 py-1 rounded-lg text-xs font-bold bg-primary-600 text-white">Kata 1</span>
                    <span id="wordle-indicator-w2" class="px-2.5 py-1 rounded-lg text-xs font-bold bg-surface-200 dark:bg-surface-800 text-surface-400">Kata 2</span>
                </div>
            </div>

            {{-- Petunjuk / Pertanyaan Tebak Kata (Wordle) --}}
            <div class="rounded-2xl border border-primary-500/25 bg-primary-50/80 dark:bg-primary-950/40 p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <span class="text-2xl select-none mt-0.5">💡</span>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-black uppercase tracking-wider text-primary-700 dark:text-primary-300">
                                Pertanyaan / Petunjuk Kata:
                            </span>
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md bg-primary-500/10 text-primary-600 dark:text-primary-400">
                                Bantuan Menjawab
                            </span>
                        </div>
                        <p id="wordle-active-hint" class="text-sm sm:text-base font-bold text-surface-900 dark:text-white leading-relaxed"></p>
                    </div>
                </div>
            </div>

            {{-- Wordle 6-Row Grid --}}
            <div class="flex justify-center my-4">
                <div id="wordle-grid" class="grid grid-rows-6 gap-2 w-full mx-auto transition-all">
                    {{-- 6 rows generated dynamically by JS --}}
                </div>
            </div>

            {{-- Toast / Warning message container --}}
            <div id="wordle-toast" class="h-6 text-center text-xs font-bold text-danger-500 transition-opacity opacity-0">
                Pesan peringatan
            </div>

            {{-- Virtual Keyboard --}}
            <div class="max-w-md mx-auto select-none space-y-1.5 pt-2">
                {{-- Row 1: Q W E R T Y U I O P --}}
                <div class="flex justify-center gap-1 sm:gap-1.5" id="keyboard-row-1"></div>
                {{-- Row 2: A S D F G H J K L --}}
                <div class="flex justify-center gap-1 sm:gap-1.5" id="keyboard-row-2"></div>
                {{-- Row 3: ENTER Z X C V B N M BACKSPACE --}}
                <div class="flex justify-center gap-1 sm:gap-1.5" id="keyboard-row-3"></div>
            </div>

            {{-- Keyboard info tip --}}
            <p class="text-center text-[11px] text-surface-400">
                Kamu juga bisa mengetik langsung dengan keyboard fisik (A-Z, Enter, Backspace).
            </p>
        </div>

        {{-- ══════════════════════════════════════════════════════════ --}}
        {{-- VIEW 5: TRANSISI ANTARA KATA 1 KE KATA 2                   --}}
        {{-- ══════════════════════════════════════════════════════════ --}}
        <div id="view-word1-success" class="hidden space-y-6">
            <div class="rounded-3xl border border-primary-500/40 bg-gradient-to-br from-primary-950/60 via-surface-900 to-surface-950 p-6 sm:p-10 text-center shadow-2xl">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-primary-500/20 text-primary-400 text-4xl mb-4 border border-primary-400/30">
                    🎯
                </div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-primary-500/20 text-primary-300 mb-2">
                    Langkah 1 Selesai!
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white">Kata 1 Berhasil Ditebak!</h2>
                <div class="my-4 inline-flex items-center gap-1 px-5 py-2.5 rounded-2xl bg-emerald-600 text-white font-black text-2xl tracking-widest shadow-lg">
                    <span id="revealed-word1">WORD1</span>
                </div>
                <p id="revealed-word1-def" class="text-sm text-surface-300 max-w-lg mx-auto leading-relaxed mt-2"></p>

                <div class="mt-8 flex justify-center">
                    <button id="btn-start-word2" type="button" class="inline-flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-surface-950 font-black px-8 py-4 text-base shadow-xl transition-all hover:scale-105 cursor-pointer">
                        <span>Lanjut ke Kata 2 (Terakhir)</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════ --}}
        {{-- VIEW 6: RESULT SCREEN (WON or LOST)                      --}}
        {{-- ══════════════════════════════════════════════════════════ --}}
        <div id="view-result" class="hidden space-y-6">
            <div id="result-card" class="rounded-3xl border p-6 sm:p-10 text-center shadow-2xl">
                {{-- Icon Badge --}}
                <div id="result-badge-icon" class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl text-4xl mb-4">
                    🏆
                </div>

                <span id="result-pill" class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider mb-2">
                    HASIL TANTANGAN
                </span>
                <h2 id="result-title" class="text-2xl sm:text-3xl font-black text-white">
                    Status Hasil
                </h2>
                <p id="result-description" class="mt-2 text-surface-300 text-sm max-w-lg mx-auto leading-relaxed"></p>

                {{-- Both Words Revealed (Hanya ditampilkan jika pemain MENANG / berhasil menebak) --}}
                <div id="result-words-container" class="hidden my-6 grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl mx-auto text-left">
                    <div class="rounded-2xl bg-surface-900/90 border border-white/10 p-4">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-surface-400">Kata 1</span>
                        <p id="result-word1-title" class="text-lg font-black text-emerald-400 tracking-wider"></p>
                        <p id="result-word1-def" class="text-xs text-surface-300 mt-1"></p>
                    </div>
                    <div class="rounded-2xl bg-surface-900/90 border border-white/10 p-4">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-surface-400">Kata 2</span>
                        <p id="result-word2-title" class="text-lg font-black text-emerald-400 tracking-wider"></p>
                        <p id="result-word2-def" class="text-xs text-surface-300 mt-1"></p>
                    </div>
                </div>

                {{-- Wordle Shareable Grid Box --}}
                <div class="rounded-2xl bg-surface-950/80 border border-white/10 p-4 max-w-sm mx-auto my-6 font-mono text-xs text-left">
                    <div class="flex items-center justify-between border-b border-white/10 pb-2 mb-2 text-surface-400">
                        <span>Papan Skor Wordle</span>
                        <span id="result-attempts-summary">SKENA</span>
                    </div>
                    <div id="result-emoji-grid" class="space-y-1 text-center py-2 leading-none text-base"></div>
                </div>

                {{-- Countdown timer to next challenge --}}
                <div id="result-countdown-box" class="rounded-2xl bg-amber-500/10 border border-amber-400/20 p-4 max-w-md mx-auto my-6">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-300">Rotasi Soal Berikutnya Dalam:</span>
                    <div id="countdown-timer" class="text-2xl font-black font-mono text-amber-400 mt-1">
                        --:--:--
                    </div>
                    <p class="text-[11px] text-surface-400 mt-1">Pembaruan otomatis 5 Mitos/Fakta & 2 Kata baru setiap 00:00 WITA.</p>
                    <a href="{{ route('game.index', ['reset' => 1]) }}" class="inline-flex items-center gap-1.5 mt-3 px-3.5 py-1.5 rounded-xl border border-amber-400/30 bg-amber-400/10 hover:bg-amber-400/20 text-xs font-bold text-amber-300 transition cursor-pointer">
                        <span>🔄</span> Reset & Dapatkan Soal Baru
                    </a>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-6">
                    <button id="btn-share-score" type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-500 to-accent-500 hover:from-emerald-400 hover:to-accent-400 text-surface-950 font-bold px-6 py-3.5 text-sm shadow-lg transition cursor-pointer">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/></svg>
                        <span id="btn-share-text">Bagikan Skor ke WhatsApp / Salin</span>
                    </button>

                    <button id="btn-restart-game" type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-surface-950 font-black px-7 py-3.5 text-sm shadow-lg transition-all hover:scale-105 cursor-pointer">
                        <span>🔄 Mengulang</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- MODAL PETUNJUK BERMAIN                                         --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<div id="modal-help" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="relative w-full max-w-lg rounded-3xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900 p-6 sm:p-8 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-surface-200 dark:border-white/10">
            <h3 class="text-lg font-black text-surface-900 dark:text-white flex items-center gap-2">
                <span>📖</span> Aturan & Cara Bermain
            </h3>
            <button id="btn-close-help" class="p-2 rounded-xl text-surface-400 hover:text-surface-900 dark:hover:text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="space-y-4 text-xs sm:text-sm text-surface-600 dark:text-surface-300 leading-relaxed">
            <div class="rounded-xl bg-primary-50 dark:bg-primary-500/10 p-3.5 border border-primary-200 dark:border-primary-500/20">
                <strong class="text-primary-700 dark:text-primary-300 block mb-1">1. Babak Mitos atau Fakta:</strong>
                Pengunjung disajikan 5 pertanyaan seputar narkoba. Jika ada jawaban yang kurang tepat, pertanyaan tersebut akan diulang kembali di akhir agar kamu memahami fakta yang sebenarnya.
            </div>

            <div class="rounded-xl bg-amber-50 dark:bg-amber-500/10 p-3.5 border border-amber-200 dark:border-amber-500/20">
                <strong class="text-amber-800 dark:text-amber-300 block mb-1">2. Pahami Penjelasannya:</strong>
                Simak pembahasan di balik setiap pernyataan. Konsep dan wawasan yang kamu pelajari akan membantumu memecahkan tebakan kata di babak berikutnya.
            </div>

            <div class="rounded-xl bg-emerald-50 dark:bg-emerald-500/10 p-3.5 border border-emerald-200 dark:border-emerald-500/20">
                <strong class="text-emerald-800 dark:text-emerald-300 block mb-1">3. Babak Wordle (Tebak 2 Kata Kunci):</strong>
                Tebak 2 kata kunci seputar narkotika (panjang huruf fleksibel 3 hingga 11 huruf). Tebak Kata ke-1 terlebih dahulu dalam 6 kesempatan:
                <ul class="list-disc ml-4 mt-1.5 space-y-1 text-[11px] sm:text-xs">
                    <li><span class="font-bold text-emerald-600 dark:text-emerald-400">🟩 Hijau:</span> Huruf tepat dan posisinya benar.</li>
                    <li><span class="font-bold text-amber-600 dark:text-amber-400">🟨 Kuning:</span> Huruf ada di dalam kata, namun posisinya salah.</li>
                    <li><span class="font-bold text-surface-500">⬛ Abu-abu:</span> Huruf tidak ada di dalam kata.</li>
                </ul>
                Jika berhasil menebak Kata ke-1, kamu akan melangkah ke Kata ke-2.
            </div>

            <div class="rounded-xl bg-danger-50 dark:bg-danger-500/10 p-3.5 border border-danger-200 dark:border-danger-500/20">
                <strong class="text-danger-800 dark:text-danger-300 block mb-1">4. Kesempatan Bermain:</strong>
                Jika kamu kehabisan 6 kesempatan pada salah satu kata, permainan berakhir (Game Over). Kamu bisa mencoba kembali atau bermain di mode latihan untuk mengasah wawasanmu!
            </div>
        </div>

        <div class="pt-3 border-t border-surface-200 dark:border-white/10 flex justify-end">
            <button id="btn-close-help-ok" type="button" class="px-5 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs transition cursor-pointer">
                Mengerti
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        'use strict';

        // ══════════════════════════════════════════════════════════
        // DATA & STATE
        // ══════════════════════════════════════════════════════════
        const TODAY_DATE = @json($todayDate);
        const PUZZLE_DATA = @json($puzzle);
        const STORAGE_KEY_PREFIX = 'skena_game_v1_';
        const STORAGE_KEY_TODAY = STORAGE_KEY_PREFIX + TODAY_DATE + '_s' + PUZZLE_DATA.set_number;

        // Web Audio Synthesizer (Zero-latency sound effects)
        let audioContext = null;
        let isMuted = localStorage.getItem('skena_game_muted') === 'true';

        function initAudio() {
            if (!audioContext) {
                const AudioCtx = window.AudioContext || window.webkitAudioContext;
                if (AudioCtx) audioContext = new AudioCtx();
            }
            if (audioContext && audioContext.state === 'suspended') {
                audioContext.resume();
            }
        }

        function playSound(type) {
            if (isMuted) return;
            try {
                initAudio();
                if (!audioContext) return;
                const now = audioContext.currentTime;

                if (type === 'click') {
                    const osc = audioContext.createOscillator();
                    const gain = audioContext.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(440, now);
                    osc.frequency.exponentialRampToValueAtTime(880, now + 0.05);
                    gain.gain.setValueAtTime(0.08, now);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.05);
                    osc.connect(gain);
                    gain.connect(audioContext.destination);
                    osc.start(now);
                    osc.stop(now + 0.05);
                } else if (type === 'correct') {
                    // Cheerful rising major triad (C5 - E5 - G5)
                    [523.25, 659.25, 783.99].forEach((freq, idx) => {
                        const osc = audioContext.createOscillator();
                        const gain = audioContext.createGain();
                        osc.type = 'triangle';
                        osc.frequency.setValueAtTime(freq, now + idx * 0.08);
                        gain.gain.setValueAtTime(0.12, now + idx * 0.08);
                        gain.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.08 + 0.25);
                        osc.connect(gain);
                        gain.connect(audioContext.destination);
                        osc.start(now + idx * 0.08);
                        osc.stop(now + idx * 0.08 + 0.25);
                    });
                } else if (type === 'wrong') {
                    // Soft low buzzer
                    const osc = audioContext.createOscillator();
                    const gain = audioContext.createGain();
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(220, now);
                    osc.frequency.exponentialRampToValueAtTime(140, now + 0.2);
                    gain.gain.setValueAtTime(0.1, now);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.2);
                    osc.connect(gain);
                    gain.connect(audioContext.destination);
                    osc.start(now);
                    osc.stop(now + 0.2);
                } else if (type === 'tile') {
                    const osc = audioContext.createOscillator();
                    const gain = audioContext.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(320, now);
                    osc.frequency.exponentialRampToValueAtTime(540, now + 0.04);
                    gain.gain.setValueAtTime(0.05, now);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.04);
                    osc.connect(gain);
                    gain.connect(audioContext.destination);
                    osc.start(now);
                    osc.stop(now + 0.04);
                } else if (type === 'victory') {
                    // Fanfare chord
                    [523.25, 659.25, 783.99, 1046.50].forEach((freq, idx) => {
                        const osc = audioContext.createOscillator();
                        const gain = audioContext.createGain();
                        osc.type = 'triangle';
                        osc.frequency.setValueAtTime(freq, now + idx * 0.1);
                        gain.gain.setValueAtTime(0.15, now + idx * 0.1);
                        gain.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.1 + 0.6);
                        osc.connect(gain);
                        gain.connect(audioContext.destination);
                        osc.start(now + idx * 0.1);
                        osc.stop(now + idx * 0.1 + 0.6);
                    });
                }
            } catch (e) {
                // AudioContext not allowed or disabled
            }
        }

        // Sound Toggle Button
        const btnToggleSound = document.getElementById('btn-toggle-sound');
        const soundIconOn = document.getElementById('sound-icon-on');
        const soundIconOff = document.getElementById('sound-icon-off');

        function updateSoundUI() {
            if (isMuted) {
                soundIconOn.classList.add('hidden');
                soundIconOff.classList.remove('hidden');
            } else {
                soundIconOn.classList.remove('hidden');
                soundIconOff.classList.add('hidden');
            }
        }
        updateSoundUI();

        btnToggleSound.addEventListener('click', () => {
            isMuted = !isMuted;
            localStorage.setItem('skena_game_muted', isMuted ? 'true' : 'false');
            updateSoundUI();
            if (!isMuted) playSound('click');
        });

        // ══════════════════════════════════════════════════════════
        // GAME STATE MACHINE
        // ══════════════════════════════════════════════════════════
        let isPracticeMode = false;
        let activePuzzle = PUZZLE_DATA;

        // Phase 1 (Mitos atau Fakta) State
        let quizQueue = [];          // Current queue of questions
        let remedialQueue = [];      // Questions answered wrong that will be remediated
        let masteredCount = 0;       // Total unique questions mastered (up to 5)
        let totalQuestions = 5;
        let currentQuestion = null;
        let isRemedialSession = false;

        // Phase 2 (Wordle) State
        let currentWordIndex = 0;    // 0 = Word 1, 1 = Word 2
        let targetWords = [];        // [{ word: 'CANDU', hint: '...' }, { word: 'REHAB', hint: '...' }]
        let maxAttempts = 6;
        let wordLength = 5;
        let currentRow = 0;
        let currentCol = 0;
        let currentGuess = '';
        let wordGuesses = [[], []];  // guesses for word 1 and word 2
        let word1Won = false;
        let word2Won = false;
        let isGameOver = false;

        // Views Elements
        const viewIntro = document.getElementById('view-intro');
        const viewMythFact = document.getElementById('view-myth-fact');
        const viewPhase1Complete = document.getElementById('view-phase1-complete');
        const viewWordle = document.getElementById('view-wordle');
        const viewWord1Success = document.getElementById('view-word1-success');
        const viewResult = document.getElementById('view-result');
        const headerModeBadge = document.getElementById('header-mode-badge');

        function hideAllViews() {
            viewIntro.classList.add('hidden');
            viewMythFact.classList.add('hidden');
            viewPhase1Complete.classList.add('hidden');
            viewWordle.classList.add('hidden');
            viewWord1Success.classList.add('hidden');
            viewResult.classList.add('hidden');
        }

        function showView(viewEl) {
            hideAllViews();
            viewEl.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // ══════════════════════════════════════════════════════════
        // PHASE 1: MITOS ATAU FAKTA
        // ══════════════════════════════════════════════════════════
        let isAnswering = false;

        function startQuiz() {
            // Deep clone all questions to guarantee fresh state
            quizQueue = activePuzzle.questions.map(q => ({
                id: q.id,
                statement: q.statement,
                is_fakta: q.is_fakta,
                badge: q.badge,
                explanation: q.explanation,
                clue: q.clue,
                _mastered: false
            }));
            remedialQueue = [];
            masteredCount = 0;
            totalQuestions = activePuzzle.questions.length;
            isRemedialSession = false;
            isAnswering = false;

            document.getElementById('remedial-alert-banner').classList.add('hidden');
            document.getElementById('quiz-remedial-badge').classList.add('hidden');
            updateQuizProgress();

            showView(viewMythFact);
            loadNextQuestion();
        }

        function loadNextQuestion() {
            isAnswering = false;

            // Check if current queue is empty
            if (quizQueue.length === 0) {
                // If there are questions in remedialQueue, begin Remedial session!
                if (remedialQueue.length > 0) {
                    isRemedialSession = true;
                    quizQueue = [...remedialQueue];
                    remedialQueue = [];

                    // Show remedial banners
                    document.getElementById('remedial-alert-banner').classList.remove('hidden');
                    document.getElementById('remedial-count-text').innerText = quizQueue.length;
                    document.getElementById('quiz-remedial-badge').classList.remove('hidden');

                    playSound('click');
                } else {
                    // All 5 questions answered correctly! Phase 1 complete!
                    finishPhase1();
                    return;
                }
            }

            currentQuestion = quizQueue.shift();

            // Populate UI
            document.getElementById('question-badge').innerText = currentQuestion.badge || 'Wawasan';
            document.getElementById('question-statement').innerText = currentQuestion.statement;

            const remedialPill = document.getElementById('question-remedial-pill');
            if (isRemedialSession) {
                remedialPill.classList.remove('hidden');
            } else {
                remedialPill.classList.add('hidden');
            }

            // Reset choices and feedback box
            document.getElementById('quiz-options-container').classList.remove('hidden');
            document.getElementById('quiz-feedback-box').classList.add('hidden');

            updateQuizProgress();
        }

        function updateQuizProgress() {
            const pct = Math.min(100, Math.round((masteredCount / totalQuestions) * 100));
            document.getElementById('quiz-progress-bar').style.width = pct + '%';
            document.getElementById('quiz-mastered-count').innerText = masteredCount;

            if (isRemedialSession) {
                document.getElementById('quiz-progress-label').innerText = 'Sesi Remedial (' + (quizQueue.length + 1) + ' soal tersisa)';
            } else {
                const currentNum = Math.min(totalQuestions, Math.max(1, totalQuestions - quizQueue.length));
                document.getElementById('quiz-progress-label').innerText = 'Pertanyaan ' + currentNum + ' dari ' + totalQuestions;
            }
        }

        function answerQuestion(playerChoiceIsFakta) {
            if (isAnswering) return;
            isAnswering = true;
            playSound('click');
            const isCorrect = (playerChoiceIsFakta === currentQuestion.is_fakta);

            const feedbackHeader = document.getElementById('feedback-header');
            const feedbackIcon = document.getElementById('feedback-icon');
            const feedbackTitle = document.getElementById('feedback-title');
            const feedbackExplanation = document.getElementById('feedback-explanation');
            const feedbackClue = document.getElementById('feedback-clue');

            feedbackExplanation.innerText = currentQuestion.explanation;
            if (feedbackClue) {
                feedbackClue.innerText = currentQuestion.clue || '';
            }

            if (isCorrect) {
                playSound('correct');
                feedbackHeader.className = 'flex items-center gap-2 text-base font-black text-emerald-600 dark:text-emerald-400';
                feedbackIcon.innerText = '✅';
                feedbackTitle.innerText = 'Tepat Sekali! Jawaban Kamu Benar.';

                // If not already counted as mastered
                if (!currentQuestion._mastered) {
                    currentQuestion._mastered = true;
                    masteredCount++;
                    updateQuizProgress();
                }
            } else {
                playSound('wrong');
                feedbackHeader.className = 'flex items-center gap-2 text-base font-black text-rose-600 dark:text-danger-400';
                feedbackIcon.innerText = '❌';
                feedbackTitle.innerText = 'Kurang Tepat! Pernyataan ini sebenarnya adalah ' + (currentQuestion.is_fakta ? 'FAKTA' : 'MITOS') + '.';

                // Masukkan ke antrean pengulangan
                remedialQueue.push(currentQuestion);
            }

            // Hide buttons & reveal explanation
            document.getElementById('quiz-options-container').classList.add('hidden');
            document.getElementById('quiz-feedback-box').classList.remove('hidden');

            // Set button label
            const nextBtnLabel = document.getElementById('btn-next-question-label');
            if (quizQueue.length === 0 && remedialQueue.length > 0) {
                nextBtnLabel.innerText = 'Ulangi Soal Belum Tepat (' + remedialQueue.length + ')';
            } else if (quizQueue.length === 0 && remedialQueue.length === 0) {
                nextBtnLabel.innerText = 'Tuntaskan Babak 1';
            } else {
                nextBtnLabel.innerText = 'Lanjut Pertanyaan';
            }
        }

        document.getElementById('btn-choose-mitos').addEventListener('click', () => answerQuestion(false));
        document.getElementById('btn-choose-fakta').addEventListener('click', () => answerQuestion(true));

        document.getElementById('btn-next-question').addEventListener('click', () => {
            playSound('click');
            loadNextQuestion();
        });

        function finishPhase1() {
            playSound('victory');
            triggerConfetti();

            // Populate Clues Preview
            const w1 = activePuzzle.words[0];
            const w2 = activePuzzle.words[1];
            const w1Len = w1.length || w1.word.length;
            const w2Len = w2.length || w2.word.length;

            const lenEl1 = document.getElementById('clue-preview-word1-len');
            const lenEl2 = document.getElementById('clue-preview-word2-len');
            if (lenEl1) lenEl1.innerText = w1Len;
            if (lenEl2) lenEl2.innerText = w2Len;

            const cpw1 = document.getElementById('clue-preview-word1');
            const cpw2 = document.getElementById('clue-preview-word2');
            if (cpw1) cpw1.innerText = w1.hint;
            if (cpw2) cpw2.innerText = w2.hint;

            showView(viewPhase1Complete);
        }

        document.getElementById('btn-proceed-to-wordle').addEventListener('click', () => {
            playSound('click');
            startWordle();
        });

        // ══════════════════════════════════════════════════════════
        // PHASE 2: WORDLE GAME BOARD (2 KATA - PANJANG DINAMIS)
        // ══════════════════════════════════════════════════════════
        const KEYBOARD_LAYOUT = [
            ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
            ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L'],
            ['ENTER', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', '⌫']
        ];

        // Best status for each keyboard key: 'correct' > 'present' > 'absent'
        let keyStatusMap = {};

        function startWordle() {
            targetWords = activePuzzle.words;
            currentWordIndex = 0;
            wordGuesses = [[], []];
            word1Won = false;
            word2Won = false;
            isGameOver = false;

            setupWordStage(0);
            showView(viewWordle);
        }

        function setupWordStage(index) {
            currentWordIndex = index;
            currentRow = 0;
            currentCol = 0;
            currentGuess = '';
            keyStatusMap = {};

            const activeWordObj = targetWords[currentWordIndex];
            wordLength = activeWordObj.length || activeWordObj.word.length;

            // Indicators
            document.getElementById('wordle-current-step').innerText = (currentWordIndex + 1);
            document.getElementById('wordle-stage-title').innerText = 'Tebak Kata ' + (currentWordIndex + 1) + ' dari 2 (' + wordLength + ' Huruf)';
            const subTitleEl = document.getElementById('wordle-stage-subtitle');
            if (subTitleEl) subTitleEl.innerText = 'Kata ' + wordLength + ' Huruf • Maks. ' + maxAttempts + ' Percobaan';
            document.getElementById('wordle-active-hint').innerText = activeWordObj.hint;

            const ind1 = document.getElementById('wordle-indicator-w1');
            const ind2 = document.getElementById('wordle-indicator-w2');
            const w1Len = targetWords[0].length || targetWords[0].word.length;
            const w2Len = targetWords[1].length || targetWords[1].word.length;

            if (currentWordIndex === 0) {
                ind1.className = 'px-2.5 py-1 rounded-lg text-xs font-bold bg-primary-600 text-white';
                ind1.innerText = 'Kata 1 (' + w1Len + 'H)';
                ind2.className = 'px-2.5 py-1 rounded-lg text-xs font-bold bg-surface-200 dark:bg-surface-800 text-surface-400';
                ind2.innerText = 'Kata 2 (' + w2Len + 'H)';
            } else {
                ind1.className = 'px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-600 text-white flex items-center gap-1';
                ind1.innerHTML = '<span>Kata 1</span><span>✓</span>';
                ind2.className = 'px-2.5 py-1 rounded-lg text-xs font-bold bg-primary-600 text-white';
                ind2.innerText = 'Kata 2 (' + w2Len + 'H)';
            }

            renderGrid();
            renderKeyboard();
        }

        function renderGrid() {
            const grid = document.getElementById('wordle-grid');
            grid.innerHTML = '';

            // Dynamic max width based on word length
            if (wordLength <= 4) {
                grid.style.maxWidth = '250px';
            } else if (wordLength <= 6) {
                grid.style.maxWidth = '340px';
            } else if (wordLength <= 8) {
                grid.style.maxWidth = '450px';
            } else {
                grid.style.maxWidth = '580px';
            }

            // Typography & tile styling based on word length
            let fontClass = 'text-lg sm:text-xl';
            let roundedClass = 'rounded-xl';
            if (wordLength >= 10) {
                fontClass = 'text-xs sm:text-sm font-black';
                roundedClass = 'rounded-lg';
            } else if (wordLength >= 8) {
                fontClass = 'text-sm sm:text-base font-black';
                roundedClass = 'rounded-lg';
            } else if (wordLength >= 6) {
                fontClass = 'text-base sm:text-lg font-black';
            }

            for (let r = 0; r < maxAttempts; r++) {
                const rowEl = document.createElement('div');
                rowEl.style.display = 'grid';
                rowEl.style.gridTemplateColumns = `repeat(${wordLength}, minmax(0, 1fr))`;
                rowEl.className = (wordLength >= 8 ? 'gap-1' : 'gap-1.5');
                rowEl.id = 'wordle-row-' + r;

                for (let c = 0; c < wordLength; c++) {
                    const tileEl = document.createElement('div');
                    tileEl.id = 'tile-' + r + '-' + c;
                    tileEl.className = `wordle-tile aspect-square ${roundedClass} flex items-center justify-center font-black ${fontClass} border-2 border-surface-300 dark:border-white/15 bg-white/50 dark:bg-surface-800/60 text-surface-900 dark:text-white`;
                    rowEl.appendChild(tileEl);
                }

                grid.appendChild(rowEl);
            }
        }

        function renderKeyboard() {
            ['keyboard-row-1', 'keyboard-row-2', 'keyboard-row-3'].forEach((rowId, rIdx) => {
                const rowEl = document.getElementById(rowId);
                rowEl.innerHTML = '';

                KEYBOARD_LAYOUT[rIdx].forEach(key => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.id = 'key-' + (key === '⌫' ? 'backspace' : key);

                    const isSpecial = key === 'ENTER' || key === '⌫';
                    btn.className = (isSpecial ? 'px-2.5 sm:px-3 text-xs font-black' : 'flex-1 max-w-[38px] text-sm font-black') +
                        ' h-11 sm:h-12 rounded-xl flex items-center justify-center border border-surface-200 dark:border-white/10 bg-surface-200/80 dark:bg-surface-800 text-surface-800 dark:text-surface-100 hover:bg-surface-300 dark:hover:bg-surface-700 active:scale-95 transition cursor-pointer';

                    btn.innerText = key;
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        handleKeyInput(key);
                    });

                    rowEl.appendChild(btn);
                });
            });
        }

        function updateKeyStyles() {
            for (const [char, status] of Object.entries(keyStatusMap)) {
                const keyEl = document.getElementById('key-' + char);
                if (!keyEl) continue;

                if (status === 'correct') {
                    keyEl.className = keyEl.className.replace(/bg-\S+/g, '') + ' bg-emerald-600 text-white border-emerald-500';
                } else if (status === 'present') {
                    if (!keyEl.classList.contains('bg-emerald-600')) {
                        keyEl.className = keyEl.className.replace(/bg-\S+/g, '') + ' bg-amber-500 text-white border-amber-400';
                    }
                } else if (status === 'absent') {
                    if (!keyEl.classList.contains('bg-emerald-600') && !keyEl.classList.contains('bg-amber-500')) {
                        keyEl.className = keyEl.className.replace(/bg-\S+/g, '') + ' bg-surface-400 dark:bg-surface-900 text-surface-300 dark:text-surface-600 border-transparent opacity-60';
                    }
                }
            }
        }

        function showToast(msg) {
            const toast = document.getElementById('wordle-toast');
            toast.innerText = msg;
            toast.style.opacity = '1';
            setTimeout(() => {
                toast.style.opacity = '0';
            }, 2000);
        }

        function handleKeyInput(key) {
            if (isGameOver) return;

            if (key === 'ENTER') {
                submitGuess();
            } else if (key === '⌫' || key === 'BACKSPACE') {
                if (currentGuess.length > 0) {
                    playSound('tile');
                    currentGuess = currentGuess.slice(0, -1);
                    currentCol--;
                    const tile = document.getElementById('tile-' + currentRow + '-' + currentCol);
                    if (tile) {
                        tile.innerText = '';
                        tile.classList.remove('border-primary-500', 'dark:border-primary-400');
                    }
                }
            } else if (/^[A-Z]$/i.test(key)) {
                if (currentGuess.length < wordLength) {
                    playSound('tile');
                    const char = key.toUpperCase();
                    const tile = document.getElementById('tile-' + currentRow + '-' + currentCol);
                    if (tile) {
                        tile.innerText = char;
                        tile.classList.add('border-primary-500', 'dark:border-primary-400', 'pop');
                        setTimeout(() => tile.classList.remove('pop'), 150);
                    }
                    currentGuess += char;
                    currentCol++;
                }
            }
        }

        // Global Physical Keyboard Listener
        window.addEventListener('keydown', (e) => {
            // Ignore if active element is an input
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
            if (viewWordle.classList.contains('hidden')) return;

            if (e.key === 'Enter') {
                e.preventDefault();
                handleKeyInput('ENTER');
            } else if (e.key === 'Backspace') {
                e.preventDefault();
                handleKeyInput('⌫');
            } else if (/^[a-zA-Z]$/.test(e.key)) {
                handleKeyInput(e.key.toUpperCase());
            }
        });

        function submitGuess() {
            if (currentGuess.length < wordLength) {
                playSound('wrong');
                showToast('Masukkan ' + wordLength + ' huruf!');
                const rowEl = document.getElementById('wordle-row-' + currentRow);
                if (rowEl) {
                    rowEl.classList.add('shake-row');
                    setTimeout(() => rowEl.classList.remove('shake-row'), 500);
                }
                return;
            }

            const target = targetWords[currentWordIndex].word.toUpperCase();
            const guess = currentGuess.toUpperCase();
            wordGuesses[currentWordIndex].push(guess);

            // Compute letter matches with proper handling of duplicate letters
            // 1. Exact matches (green)
            // 2. Present matches (yellow)
            // 3. Absent matches (gray)
            const evaluation = new Array(wordLength).fill('absent');
            const targetLetterCounts = {};

            for (let i = 0; i < wordLength; i++) {
                const char = target[i];
                targetLetterCounts[char] = (targetLetterCounts[char] || 0) + 1;
            }

            // First pass: find exact matches (correct)
            for (let i = 0; i < wordLength; i++) {
                if (guess[i] === target[i]) {
                    evaluation[i] = 'correct';
                    targetLetterCounts[guess[i]]--;
                }
            }

            // Second pass: find letters present in other spots
            for (let i = 0; i < wordLength; i++) {
                if (evaluation[i] === 'correct') continue;
                const char = guess[i];
                if (targetLetterCounts[char] && targetLetterCounts[char] > 0) {
                    evaluation[i] = 'present';
                    targetLetterCounts[char]--;
                }
            }

            // Typography & tile styling based on word length
            let fontClass = 'text-lg sm:text-xl';
            let roundedClass = 'rounded-xl';
            if (wordLength >= 10) {
                fontClass = 'text-xs sm:text-sm font-black';
                roundedClass = 'rounded-lg';
            } else if (wordLength >= 8) {
                fontClass = 'text-sm sm:text-base font-black';
                roundedClass = 'rounded-lg';
            } else if (wordLength >= 6) {
                fontClass = 'text-base sm:text-lg font-black';
            }

            // Animate tile flip sequentially (quicker flip for longer words so user does not wait too long)
            const flipDelay = wordLength >= 8 ? 160 : 220;
            for (let i = 0; i < wordLength; i++) {
                const tile = document.getElementById('tile-' + currentRow + '-' + i);
                const char = guess[i];
                const status = evaluation[i];

                setTimeout(() => {
                    tile.classList.add('flip');

                    if (status === 'correct') {
                        tile.className = `wordle-tile aspect-square ${roundedClass} flex items-center justify-center font-black ${fontClass} border-2 border-emerald-600 bg-emerald-600 text-white shadow-md flip`;
                        keyStatusMap[char] = 'correct';
                    } else if (status === 'present') {
                        tile.className = `wordle-tile aspect-square ${roundedClass} flex items-center justify-center font-black ${fontClass} border-2 border-amber-500 bg-amber-500 text-white shadow-md flip`;
                        if (keyStatusMap[char] !== 'correct') keyStatusMap[char] = 'present';
                    } else {
                        tile.className = `wordle-tile aspect-square ${roundedClass} flex items-center justify-center font-black ${fontClass} border-2 border-surface-600 dark:border-surface-700 bg-surface-500 dark:bg-surface-800 text-white opacity-80 flip`;
                        if (!keyStatusMap[char]) keyStatusMap[char] = 'absent';
                    }

                    updateKeyStyles();
                }, i * flipDelay);
            }

            // Check win / lose condition after all tiles flip
            const totalFlipDuration = wordLength * flipDelay + 180;
            setTimeout(() => {
                if (guess === target) {
                    handleWordSuccess();
                } else {
                    currentRow++;
                    currentCol = 0;
                    currentGuess = '';

                    if (currentRow >= maxAttempts) {
                        handleGameOver();
                    }
                }
            }, totalFlipDuration);
        }

        function handleWordSuccess() {
            playSound('correct');

            if (currentWordIndex === 0) {
                word1Won = true;
                // Transition to Word 1 Success View
                document.getElementById('revealed-word1').innerText = targetWords[0].word;
                document.getElementById('revealed-word1-def').innerText = targetWords[0].definition;
                showView(viewWord1Success);
            } else {
                word2Won = true;
                // Full Victory!
                handleFinalResult(true);
            }
        }

        document.getElementById('btn-start-word2').addEventListener('click', () => {
            playSound('click');
            setupWordStage(1);
            showView(viewWordle);
        });

        function handleGameOver() {
            playSound('wrong');
            isGameOver = true;
            handleFinalResult(false);
        }

        // ══════════════════════════════════════════════════════════
        // FINAL RESULT (WON OR LOST) & DAILY RECORDING
        // ══════════════════════════════════════════════════════════
        function handleFinalResult(isVictory) {
            isGameOver = true;

            const record = {
                date: TODAY_DATE,
                isVictory: isVictory,
                word1Won: word1Won,
                word2Won: word2Won,
                wordGuesses: wordGuesses,
                targetWords: targetWords,
                timestamp: Date.now()
            };

            // Save official record if not in practice mode
            if (!isPracticeMode) {
                if (isVictory) {
                    localStorage.setItem(STORAGE_KEY_TODAY, JSON.stringify(record));
                } else {
                    // Jangan kunci Game Over di localStorage agar pemain bisa langsung mengulang
                    localStorage.removeItem(STORAGE_KEY_TODAY);
                }
                // Sync with server endpoint
                fetch('{{ route('game.record') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: isVictory ? 'won' : 'lost' })
                }).catch(() => {});
            }

            renderResultView(record);
        }

        function renderResultView(record) {
            const isVictory = record.isVictory;
            const w1 = record.targetWords ? record.targetWords[0] : activePuzzle.words[0];
            const w2 = record.targetWords ? record.targetWords[1] : activePuzzle.words[1];

            const resultCard = document.getElementById('result-card');
            const resultBadgeIcon = document.getElementById('result-badge-icon');
            const resultPill = document.getElementById('result-pill');
            const resultTitle = document.getElementById('result-title');
            const resultDesc = document.getElementById('result-description');
            const resultWordsContainer = document.getElementById('result-words-container');
            const resultCountdownBox = document.getElementById('result-countdown-box');
            const btnRestart = document.getElementById('btn-restart-game');

            if (isVictory) {
                playSound('victory');
                triggerConfetti();

                resultCard.className = 'rounded-3xl border border-emerald-500/40 bg-gradient-to-br from-emerald-950/40 via-surface-900 to-surface-950 p-6 sm:p-10 text-center shadow-2xl';
                resultBadgeIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-500/20 text-emerald-400 text-4xl mb-4 border border-emerald-400/30 glow-gold';
                resultBadgeIcon.innerText = '🏆';
                resultPill.className = 'inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 mb-2';
                resultPill.innerText = 'LULUS SEMPURNA!';
                resultTitle.innerText = 'Selamat! Kamu Menaklukkan Wordle SKENA!';
                resultDesc.innerText = 'Dua kata kunci bahaya narkoba berhasil kamu tebak berkat pemahaman tajam dari babak Mitos/Fakta. Terus pertahankan wawasan ini!';

                // Tampilkan kata jika menang (karena pemain sudah berhasil menebaknya)
                if (resultWordsContainer) {
                    resultWordsContainer.classList.remove('hidden');
                    document.getElementById('result-word1-title').innerText = w1.word;
                    document.getElementById('result-word1-def').innerText = w1.definition;
                    document.getElementById('result-word2-title').innerText = w2.word;
                    document.getElementById('result-word2-def').innerText = w2.definition;
                }
                if (resultCountdownBox) resultCountdownBox.classList.remove('hidden');
                if (btnRestart) btnRestart.innerHTML = '<span>🔄 Main Lagi</span>';
            } else {
                resultCard.className = 'rounded-3xl border border-danger-500/40 bg-gradient-to-br from-danger-950/40 via-surface-900 to-surface-950 p-6 sm:p-10 text-center shadow-2xl';
                resultBadgeIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-danger-500/20 text-danger-400 text-4xl mb-4 border border-danger-400/30';
                resultBadgeIcon.innerText = '💀';
                resultPill.className = 'inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-danger-500/20 text-danger-300 mb-2';
                resultPill.innerText = 'KESEMPATAN HABIS (GAME OVER)';
                resultTitle.innerText = 'Sayang Sekali, Kesempatanmu Habis!';
                resultDesc.innerText = 'Kesempatan menebak telah habis. Silakan mengulang dari babak awal untuk mencoba kembali!';

                // Sembunyikan jawaban sama sekali agar pemain tidak bisa mencoba ulang dengan mengetahui jawaban
                if (resultWordsContainer) {
                    resultWordsContainer.classList.add('hidden');
                }
                document.getElementById('result-word1-title').innerText = '';
                document.getElementById('result-word1-def').innerText = '';
                document.getElementById('result-word2-title').innerText = '';
                document.getElementById('result-word2-def').innerText = '';

                if (resultCountdownBox) resultCountdownBox.classList.add('hidden');
                if (btnRestart) btnRestart.innerHTML = '<span>🔄 Mengulang</span>';
            }

            // Generate emoji grid
            generateEmojiGrid(record);

            showView(viewResult);
            startCountdown();
        }

        function generateEmojiGrid(record) {
            const container = document.getElementById('result-emoji-grid');
            container.innerHTML = '';

            const w1Target = (record.targetWords ? record.targetWords[0].word : activePuzzle.words[0].word).toUpperCase();
            const w2Target = (record.targetWords ? record.targetWords[1].word : activePuzzle.words[1].word).toUpperCase();
            const guesses1 = record.wordGuesses ? record.wordGuesses[0] || [] : [];
            const guesses2 = record.wordGuesses ? record.wordGuesses[1] || [] : [];

            let fullShareText = '🎮 SKENA Wordle BNNP Sulteng\n📅 ' + TODAY_DATE + '\n\n';
            fullShareText += 'Kata 1 (' + (record.word1Won ? guesses1.length : 'X') + '/6):\n';

            guesses1.forEach(guess => {
                const rowStr = evaluateToEmojis(guess, w1Target);
                fullShareText += rowStr + '\n';
                const div = document.createElement('div');
                div.innerText = rowStr;
                container.appendChild(div);
            });

            if (guesses2.length > 0) {
                fullShareText += '\nKata 2 (' + (record.word2Won ? guesses2.length : 'X') + '/6):\n';
                const sep = document.createElement('div');
                sep.className = 'my-1 border-t border-white/10';
                container.appendChild(sep);

                guesses2.forEach(guess => {
                    const rowStr = evaluateToEmojis(guess, w2Target);
                    fullShareText += rowStr + '\n';
                    const div = document.createElement('div');
                    div.innerText = rowStr;
                    container.appendChild(div);
                });
            }

            fullShareText += '\nMainkan di: ' + window.location.href + '\n#SKENABNNP #TolakNarkoba #WarOnDrugs';

            // Setup share button
            const btnShare = document.getElementById('btn-share-score');
            const btnShareText = document.getElementById('btn-share-text');

            btnShare.onclick = () => {
                playSound('click');
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(fullShareText).then(() => {
                        btnShareText.innerText = 'Tersalin ke Clipboard! ✓';
                        setTimeout(() => {
                            btnShareText.innerText = 'Bagikan Skor ke WhatsApp / Salin';
                        }, 3000);
                    });
                }
                // Also open WhatsApp share if available
                const waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(fullShareText);
                window.open(waUrl, '_blank');
            };
        }

        function evaluateToEmojis(guess, target) {
            const len = target.length;
            const emojis = new Array(len).fill('⬛');
            const counts = {};
            for (let i = 0; i < len; i++) {
                const c = target[i];
                counts[c] = (counts[c] || 0) + 1;
            }
            for (let i = 0; i < len; i++) {
                if (guess[i] === target[i]) {
                    emojis[i] = '🟩';
                    counts[guess[i]]--;
                }
            }
            for (let i = 0; i < len; i++) {
                if (emojis[i] === '🟩') continue;
                const c = guess[i];
                if (counts[c] && counts[c] > 0) {
                    emojis[i] = '🟨';
                    counts[c]--;
                }
            }
            return emojis.join('');
        }

        // Countdown Timer to Midnight 00:00 WITA (UTC+8)
        function startCountdown() {
            const timerEl = document.getElementById('countdown-timer');

            function updateTimer() {
                const now = new Date();
                const tomorrow = new Date(now);
                tomorrow.setDate(tomorrow.getDate() + 1);
                tomorrow.setHours(0, 0, 0, 0);

                const diffMs = tomorrow - now;
                if (diffMs <= 0) {
                    timerEl.innerText = '00:00:00 (Reset!)';
                    location.reload();
                    return;
                }

                const hours = Math.floor(diffMs / (1000 * 60 * 60));
                const mins = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((diffMs % (1000 * 60)) / 1000);

                timerEl.innerText =
                    String(hours).padStart(2, '0') + ':' +
                    String(mins).padStart(2, '0') + ':' +
                    String(secs).padStart(2, '0');
            }

            updateTimer();
            setInterval(updateTimer, 1000);
        }

        // Confetti Generator
        function triggerConfetti() {
            const colors = ['#10b981', '#f59e0b', '#3b82f6', '#ec4899', '#8b5cf6'];
            for (let i = 0; i < 60; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti-piece';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDuration = (2 + Math.random() * 2) + 's';
                confetti.style.animationDelay = (Math.random() * 0.5) + 's';
                document.body.appendChild(confetti);

                setTimeout(() => confetti.remove(), 4000);
            }
        }

        // ══════════════════════════════════════════════════════════
        // INITIALIZATION & CHECK IF ALREADY PLAYED TODAY
        // ══════════════════════════════════════════════════════════
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('reset')) {
            Object.keys(localStorage).forEach(k => {
                if (k.startsWith(STORAGE_KEY_PREFIX)) localStorage.removeItem(k);
            });
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        // Global helper untuk reset cepat jika dibutuhkan kapan saja di console
        window.skenaResetToday = function() {
            localStorage.removeItem(STORAGE_KEY_TODAY);
            window.location.href = window.location.pathname;
        };

        function checkDailyStatus() {
            const savedToday = localStorage.getItem(STORAGE_KEY_TODAY);
            if (savedToday) {
                try {
                    const record = JSON.parse(savedToday);
                    if (record && record.date === TODAY_DATE) {
                        // Already played today!
                        renderResultView(record);
                        return true;
                    }
                } catch (e) {}
            }
            return false;
        }

        // Mengulang permainan dari babak awal lagi (Babak 1: Mitos atau Fakta)
        function restartGame() {
            playSound('click');
            localStorage.removeItem(STORAGE_KEY_TODAY);
            isPracticeMode = false;
            masteredCount = 0;
            currentWordIndex = 0;
            currentRow = 0;
            currentCol = 0;
            currentGuess = '';
            wordGuesses = [[], []];
            word1Won = false;
            word2Won = false;
            isGameOver = false;
            keyStatusMap = {};

            // Langsung bawa pemain mengulang dari babak awal (Mitos atau Fakta)
            startQuiz();
        }

        // Start Daily Challenge Event
        const btnStartGame = document.getElementById('btn-start-game');
        if (btnStartGame) {
            btnStartGame.addEventListener('click', () => {
                playSound('click');
                startQuiz();
            });
        }

        // Restart Game Button Event (Mengulang dari awal)
        const btnRestart = document.getElementById('btn-restart-game');
        if (btnRestart) {
            btnRestart.addEventListener('click', restartGame);
        }
        const btnPractice = document.getElementById('btn-practice-mode');
        if (btnPractice) {
            btnPractice.addEventListener('click', restartGame);
        }

        // Help Modal Events
        const modalHelp = document.getElementById('modal-help');
        document.getElementById('btn-open-help').addEventListener('click', () => {
            playSound('click');
            modalHelp.classList.remove('hidden');
        });
        document.getElementById('btn-close-help').addEventListener('click', () => {
            modalHelp.classList.add('hidden');
        });
        document.getElementById('btn-close-help-ok').addEventListener('click', () => {
            modalHelp.classList.add('hidden');
        });
        modalHelp.addEventListener('click', (e) => {
            if (e.target === modalHelp) modalHelp.classList.add('hidden');
        });

        // On Page Load: Check if already completed today
        const alreadyDone = checkDailyStatus();
        if (!alreadyDone) {
            showView(viewIntro);
        }

    })();
</script>
@endpush
@endsection
