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
        box-shadow: 0 0 25px rgba(245, 158, 11, 0.45);
    }
    .glow-silver {
        box-shadow: 0 0 20px rgba(203, 213, 225, 0.35);
    }
    .glow-bronze {
        box-shadow: 0 0 20px rgba(217, 119, 6, 0.35);
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
<div class="relative min-h-[calc(100vh-4rem)] overflow-hidden py-4 sm:py-8 px-3 sm:px-6 lg:px-8">
    {{-- Ambient Gradients --}}
    <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-gradient-to-b from-primary-500/15 via-amber-500/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative mx-auto max-w-3xl">

        {{-- ═══ TOP CONTROLS & HEADER ═══ --}}
        <div class="flex items-center justify-between gap-2 mb-4 sm:mb-6 pb-3 sm:pb-4 border-b border-surface-200 dark:border-white/10">
            <div class="flex items-center gap-2.5 sm:gap-3 min-w-0 flex-1">
                <a href="{{ route('beranda') }}" class="p-2 rounded-xl border border-surface-200 dark:border-white/10 text-surface-500 hover:text-surface-900 dark:hover:text-white transition shrink-0" title="Kembali ke Beranda">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                </a>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="text-[10px] sm:text-xs font-black uppercase tracking-wider text-primary-600 dark:text-primary-400 truncate">SKENA MINI GAMES</span>
                        <span id="header-mode-badge" class="hidden md:inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-500/20 text-primary-600 dark:text-primary-400 border border-primary-500/30 shrink-0 whitespace-nowrap">Mitos/Fakta & Wordle</span>
                    </div>
                    <h1 class="text-sm sm:text-xl font-black text-surface-900 dark:text-white tracking-tight truncate">5 Mitos/Fakta & Wordle</h1>
                </div>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                {{-- Leaderboard Button --}}
                <button id="btn-open-leaderboard" type="button" class="flex items-center gap-1.5 p-2 sm:px-3 sm:py-2 rounded-xl border border-amber-400/40 bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 font-bold text-xs transition cursor-pointer shadow-sm hover:scale-[1.02] shrink-0" title="Papan Peringkat Harian">
                    <svg class="h-4 w-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                    </svg>
                    <span class="hidden sm:inline">Papan Peringkat</span>
                </button>
                {{-- Audio Mute/Unmute --}}
                <button id="btn-toggle-sound" type="button" class="p-2 sm:p-2.5 rounded-xl border border-surface-200 dark:border-white/10 text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5 transition shrink-0" title="Suara Efek (Aktif/Mati)">
                    <svg id="sound-icon-on" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.757 3.63 8.25 4.51 8.25H6.75z"/>
                    </svg>
                    <svg id="sound-icon-off" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 9.75L19.5 12m0 0l2.25 2.25M19.5 12l2.25-2.25M19.5 12l-2.25 2.25m-10.5-7.5l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.757 3.63 8.25 4.51 8.25H6.75z"/>
                    </svg>
                </button>
                {{-- Help Modal --}}
                <button id="btn-open-help" type="button" class="p-2 sm:p-2.5 rounded-xl border border-surface-200 dark:border-white/10 text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5 transition shrink-0" title="Petunjuk Bermain">
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
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/>
                        </svg>
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

                    <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <button id="btn-start-game" type="button" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-surface-950 font-black px-8 py-4 text-base shadow-xl hover:shadow-amber-500/25 transition-all hover:scale-[1.02] cursor-pointer">
                            <span>Mulai Mini Games</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </button>
                        <button id="btn-view-leaderboard-intro" type="button" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-amber-400/40 bg-white/5 hover:bg-white/10 text-amber-300 font-bold px-6 py-4 text-sm transition-all hover:scale-[1.02] cursor-pointer">
                            <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                            </svg>
                            <span>Papan Peringkat (Top 10)</span>
                        </button>
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
                    <span id="quiz-remedial-badge" class="hidden px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 animate-pulse inline-flex items-center gap-1">
                        <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        <span>Ulangi Pertanyaan</span>
                    </span>
                    <span id="quiz-score-badge" class="text-primary-600 dark:text-primary-400">Tuntas: <span id="quiz-mastered-count">0</span>/5</span>
                </div>
                <div class="h-3.5 w-full bg-surface-200 dark:bg-surface-800 rounded-full overflow-hidden p-0.5">
                    <div id="quiz-progress-bar" class="h-full bg-gradient-to-r from-emerald-500 to-accent-400 rounded-full transition-all duration-500 w-0"></div>
                </div>
            </div>

            {{-- Announcement Alert (Ulangi Pertanyaan) --}}
            <div id="remedial-alert-banner" class="hidden rounded-2xl border border-amber-500/40 bg-amber-500/10 p-4 text-amber-800 dark:text-amber-300 text-xs sm:text-sm flex items-start gap-3">
                <div class="h-8 w-8 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-300 flex items-center justify-center shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </div>
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
                        <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        <span>Pengulangan</span>
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
                        <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-2xl bg-danger-500/15 border border-danger-500/30 flex items-center justify-center text-danger-500 mb-2 transition-transform group-hover:scale-110 shadow-xs">
                            <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-black text-danger-600 dark:text-danger-400 tracking-wide">MITOS</span>
                        <span class="text-[11px] text-surface-400 mt-1">Pernyataan salah</span>
                    </button>

                    {{-- FAKTA Button --}}
                    <button id="btn-choose-fakta" type="button" class="group relative flex flex-col items-center justify-center p-5 sm:p-6 rounded-2xl border-2 border-accent-500/30 bg-accent-500/5 hover:bg-accent-500/15 hover:border-accent-500 transition-all hover:scale-[1.02] cursor-pointer">
                        <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-2xl bg-accent-500/15 border border-accent-500/30 flex items-center justify-center text-accent-500 mb-2 transition-transform group-hover:scale-110 shadow-xs">
                            <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </div>
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
        {{-- ══════════════════════════════════════════════════════════ --}}
        {{-- VIEW 3: BABAK 1 SELESAI - TRANSISI KE WORDLE              --}}
        {{-- ══════════════════════════════════════════════════════════ --}}
        <div id="view-phase1-complete" class="hidden space-y-6">
            <div class="rounded-3xl border border-emerald-500/30 bg-gradient-to-br from-emerald-950/40 via-surface-900 to-surface-950 p-6 sm:p-10 text-center shadow-2xl">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-500/20 text-emerald-400 mb-4 border border-emerald-400/30 glow-gold">
                    <svg class="h-10 w-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
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
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-500/15 text-primary-600 dark:text-primary-400 shrink-0 mt-0.5">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.508 1.333 1.508 2.316V18"/>
                        </svg>
                    </div>
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
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-primary-500/20 text-primary-400 mb-4 border border-primary-400/30">
                    <svg class="h-10 w-10 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
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
        <div id="view-result" class="hidden space-y-3.5">
            <div id="result-card" class="rounded-2xl sm:rounded-3xl border p-4 sm:p-7 text-center shadow-2xl">
                {{-- Icon Badge --}}
                <div id="result-badge-icon" class="mx-auto flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl mb-2">
                    <svg class="h-8 w-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                    </svg>
                </div>

                <span id="result-pill" class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider mb-1">
                    HASIL TANTANGAN
                </span>
                <h2 id="result-title" class="text-xl sm:text-2xl font-black text-white">
                    Status Hasil
                </h2>
                <p id="result-description" class="mt-1 text-surface-300 text-xs sm:text-sm max-w-md mx-auto leading-relaxed"></p>

                {{-- Skor & Statistik Detail Permainan (Hanya Muncul saat MENANG) --}}
                <div id="result-score-section" class="hidden my-3 max-w-xl mx-auto space-y-2.5 text-left">
                    {{-- Kartu Skor Utama (Angka Terlihat Jelas & Kontras Tinggi) --}}
                    <div class="relative overflow-hidden rounded-2xl bg-amber-500/10 dark:bg-amber-500/15 p-3.5 sm:p-4 border-2 border-amber-400/60 text-center shadow-lg">
                        <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-amber-500 dark:text-amber-400">TOTAL PEROLEHAN SKOR</span>
                        <div class="mt-0.5 flex items-baseline justify-center gap-1.5 sm:gap-2">
                            <span id="score-grand-total" class="text-4xl sm:text-5xl font-black font-mono text-amber-500 dark:text-amber-300 tracking-tight" style="color: #f59e0b; text-shadow: 0 0 16px rgba(245, 158, 11, 0.45);">0</span>
                            <span class="text-sm sm:text-base font-black text-amber-600 dark:text-amber-400">PTS</span>
                        </div>
                        <div class="mt-1.5 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 dark:bg-surface-800/80 border border-white/15 text-xs font-bold text-white shadow-sm">
                            <span id="score-badge-icon" class="inline-flex items-center">
                                <svg class="h-4 w-4 text-amber-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </span>
                            <span id="score-badge-title">Master P4GN Paripurna</span>
                        </div>
                    </div>

                    {{-- Rincian 5 Komponen Skor Edukasi (Hemat Ruang & Nyaman di HP) --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                        {{-- Mitos/Fakta --}}
                        <div class="rounded-xl bg-surface-900/90 border border-white/10 p-2.5">
                            <span class="text-surface-400 flex items-center gap-1 text-[9px] uppercase font-bold">
                                <svg class="h-3 w-3 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                <span>Mitos/Fakta</span>
                            </span>
                            <span id="score-quiz-val" class="text-xs sm:text-sm font-black text-emerald-400 mt-0.5 block">+0 Pts</span>
                            <span id="score-quiz-detail" class="text-[9px] text-surface-400">0/5 Soal Tepat</span>
                        </div>
                        {{-- Wordle 1 --}}
                        <div class="rounded-xl bg-surface-900/90 border border-white/10 p-2.5">
                            <span class="text-surface-400 flex items-center gap-1 text-[9px] uppercase font-bold">
                                <svg class="h-3 w-3 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                <span>Kata 1</span>
                            </span>
                            <span id="score-w1-val" class="text-xs sm:text-sm font-black text-amber-400 mt-0.5 block">+0 Pts</span>
                            <span id="score-w1-detail" class="text-[9px] text-surface-400">Tebakan ke-0</span>
                        </div>
                        {{-- Wordle 2 --}}
                        <div class="rounded-xl bg-surface-900/90 border border-white/10 p-2.5">
                            <span class="text-surface-400 flex items-center gap-1 text-[9px] uppercase font-bold">
                                <svg class="h-3 w-3 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                <span>Kata 2</span>
                            </span>
                            <span id="score-w2-val" class="text-xs sm:text-sm font-black text-amber-400 mt-0.5 block">+0 Pts</span>
                            <span id="score-w2-detail" class="text-[9px] text-surface-400">Tebakan ke-0</span>
                        </div>
                        {{-- Kecepatan Waktu --}}
                        <div class="rounded-xl bg-surface-900/90 border border-white/10 p-2.5">
                            <span class="text-surface-400 flex items-center gap-1 text-[9px] uppercase font-bold">
                                <svg class="h-3 w-3 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Waktu Selesai</span>
                            </span>
                            <span id="score-speed-val" class="text-xs sm:text-sm font-black text-sky-400 mt-0.5 block">+0 Pts</span>
                            <span id="score-speed-detail" class="text-[9px] text-surface-400">Durasi: 00:00</span>
                        </div>
                        {{-- Penalti Mengulang --}}
                        <div class="col-span-2 sm:col-span-2 rounded-xl bg-surface-900/90 border border-white/10 p-2.5 flex items-center justify-between">
                            <div>
                                <span class="text-surface-400 flex items-center gap-1 text-[9px] uppercase font-bold">
                                    <svg class="h-3 w-3 text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                                    <span>Penalti Pengulangan</span>
                                </span>
                                <span id="score-retry-detail" class="text-[9px] text-surface-400">Menuntaskan tanpa mengulang</span>
                            </div>
                            <span id="score-retry-val" class="text-xs sm:text-sm font-black text-emerald-400 block">0 Pts (First Try!)</span>
                        </div>
                    </div>
                </div>

                {{-- Form Input Nama ke Leaderboard Harian (Simple, Praktis untuk di Lobby HP) --}}
                <div id="leaderboard-entry-card" class="hidden my-3 max-w-xl mx-auto rounded-2xl bg-gradient-to-br from-amber-500/10 via-surface-900 to-surface-950 border border-amber-400/40 p-3 sm:p-4 text-left shadow-lg">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                            </svg>
                            <h3 id="leaderboard-card-title" class="text-xs sm:text-sm font-black text-white">Catat Namamu di Top 10 Hari Ini</h3>
                        </div>
                        <span class="text-[10px] text-amber-300 font-bold">Reset 07:00 WITA</span>
                    </div>

                    {{-- Form: Cukup Nama / Panggilan / Alias saja --}}
                    <form id="form-submit-leaderboard" class="space-y-2">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                            <div class="relative flex-1">
                                <input id="input-player-name" type="text" maxlength="30" required placeholder="Ketik nama atau alias..." class="w-full rounded-xl border border-white/15 bg-surface-800/90 px-3.5 py-2.5 text-xs sm:text-sm text-white placeholder-surface-400 focus:border-amber-400 focus:ring-1 focus:ring-amber-400/30 outline-none transition" />
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button id="btn-submit-score-lb" type="submit" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-surface-950 font-black px-4 py-2.5 text-xs sm:text-sm shadow-md transition-all active:scale-95 cursor-pointer shrink-0">
                                    <span>Kirim Skor</span>
                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                                    </svg>
                                </button>
                                <button id="btn-open-leaderboard-from-result" type="button" class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/10 text-white font-bold text-xs transition cursor-pointer shrink-0" title="Buka Papan Peringkat">
                                    <svg class="h-3.5 w-3.5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                                    </svg>
                                    <span>Top 10</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Feedback Success Card / Status Sudah Tercatat --}}
                    <div id="leaderboard-submit-success" class="hidden mt-2 p-3 sm:p-3.5 rounded-xl bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 text-xs">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                            <div class="flex items-start sm:items-center gap-2.5 min-w-0 flex-1">
                                <svg class="h-5 w-5 text-emerald-400 shrink-0 mt-0.5 sm:mt-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                                <div class="min-w-0 flex-1">
                                    <h4 id="leaderboard-success-title" class="font-black text-white text-xs sm:text-sm leading-snug">Skor Berhasil Masuk!</h4>
                                    <p id="leaderboard-success-subtitle" class="text-[11px] text-emerald-300/90 mt-0.5 break-words">Tercatat sebagai: <span id="leaderboard-submitted-name-badge" class="font-bold underline text-white">...</span></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0 self-end sm:self-center">
                                <button id="btn-change-player-name" type="button" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 text-surface-300 hover:text-white font-semibold text-[11px] transition cursor-pointer" title="Ubah nama tampilan">
                                    <svg class="h-3.5 w-3.5 text-surface-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                    </svg>
                                    <span>Ganti Nama</span>
                                </button>
                                <button id="btn-view-lb-after-submit" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition cursor-pointer shadow">
                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                                    </svg>
                                    <span>Buka Peringkat</span>
                                    <span>→</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Both Words Revealed (Kompak 2 Kolom) --}}
                <div id="result-words-container" class="hidden my-3 grid grid-cols-2 gap-2 max-w-xl mx-auto text-left">
                    <div class="rounded-xl bg-surface-900/90 border border-white/10 p-2.5">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-surface-400 block">Kata 1</span>
                        <p id="result-word1-title" class="text-sm sm:text-base font-black text-emerald-400 tracking-wider"></p>
                        <p id="result-word1-def" class="text-[10px] sm:text-xs text-surface-300 mt-0.5 line-clamp-3 sm:line-clamp-none"></p>
                    </div>
                    <div class="rounded-xl bg-surface-900/90 border border-white/10 p-2.5">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-surface-400 block">Kata 2</span>
                        <p id="result-word2-title" class="text-sm sm:text-base font-black text-emerald-400 tracking-wider"></p>
                        <p id="result-word2-def" class="text-[10px] sm:text-xs text-surface-300 mt-0.5 line-clamp-3 sm:line-clamp-none"></p>
                    </div>
                </div>

                {{-- Wordle Shareable Grid Box (Kompak) --}}
                <div class="rounded-xl bg-surface-950/80 border border-white/10 p-2.5 max-w-xs mx-auto my-3 font-mono text-xs text-left">
                    <div class="flex items-center justify-between border-b border-white/10 pb-1.5 mb-1.5 text-surface-400 text-[10px]">
                        <span>Papan Skor Wordle</span>
                        <span id="result-attempts-summary">SKENA</span>
                    </div>
                    <div id="result-emoji-grid" class="space-y-1 text-center py-1 leading-none text-sm"></div>
                </div>

                {{-- Countdown timer to next challenge (Kompak 1 Baris) --}}
                <div id="result-countdown-box" class="rounded-xl bg-amber-500/10 border border-amber-400/20 px-3 py-2 max-w-sm mx-auto my-3 text-xs flex items-center justify-between gap-2">
                    <div class="text-left">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-amber-300 block">Reset Soal Baru (07:00 WITA):</span>
                        <span id="countdown-timer" class="text-xs sm:text-sm font-black font-mono text-amber-400">--:--:--</span>
                    </div>
                    <a href="{{ route('game.index', ['reset' => 1, 't' => time()]) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border border-amber-400/30 bg-amber-400/10 hover:bg-amber-400/20 text-[10px] font-bold text-amber-300 transition cursor-pointer shrink-0">
                        <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        <span>Reset Soal</span>
                    </a>
                </div>

                {{-- Action Buttons (Promosi & Share WhatsApp Lebih Menarik) --}}
                <div class="space-y-2.5 mt-5 max-w-md mx-auto">
                    {{-- Tombol Utama: Share WhatsApp (Tantang Teman & Promosi) --}}
                    <button id="btn-share-score" type="button" class="w-full inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-400 hover:to-green-500 text-white font-black px-5 py-3.5 text-sm shadow-xl hover:shadow-emerald-500/25 transition-all hover:scale-[1.01] active:scale-[0.99] cursor-pointer">
                        <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span id="btn-share-text">Bagikan Skor & Tantang di WhatsApp</span>
                    </button>

                    <div class="flex items-center gap-2">
                        <button id="btn-open-leaderboard-result" type="button" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl border border-amber-400/40 bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 font-bold px-3 py-2.5 text-xs shadow transition cursor-pointer hover:scale-[1.01]">
                            <svg class="h-3.5 w-3.5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                            </svg>
                            <span>Papan Peringkat</span>
                        </button>
                        <button id="btn-restart-game" type="button" class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl border border-white/20 bg-white/5 hover:bg-white/10 text-white font-bold px-3 py-2.5 text-xs shadow transition cursor-pointer hover:scale-[1.01]">
                            <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                            </svg>
                            <span>Main Lagi</span>
                        </button>
                    </div>

                    <p class="text-[11px] text-surface-400 text-center">
                        Ajak teman bersaing di Top 10 harian sambil menguji wawasan anti-narkoba!
                    </p>
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
                <svg class="h-5 w-5 text-primary-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                <span>Aturan & Cara Bermain</span>
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
                    <li><span class="inline-block w-3 h-3 rounded-xs bg-emerald-500 mr-1.5 align-middle shadow-xs"></span><span class="font-bold text-emerald-600 dark:text-emerald-400">Hijau:</span> Huruf tepat dan posisinya benar.</li>
                    <li><span class="inline-block w-3 h-3 rounded-xs bg-amber-500 mr-1.5 align-middle shadow-xs"></span><span class="font-bold text-amber-600 dark:text-amber-400">Kuning:</span> Huruf ada di dalam kata, namun posisinya salah.</li>
                    <li><span class="inline-block w-3 h-3 rounded-xs bg-surface-500 dark:bg-surface-600 mr-1.5 align-middle shadow-xs"></span><span class="font-bold text-surface-600 dark:text-surface-400">Abu-abu:</span> Huruf tidak ada di dalam kata.</li>
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

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- MODAL PAPAN PERINGKAT (LEADERBOARD TOP 10)                     --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<div id="modal-leaderboard" class="fixed inset-0 hidden bg-black/75 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 overscroll-contain" style="z-index: 99999;">
    <div class="relative w-full max-w-lg sm:max-w-xl rounded-3xl border border-surface-200/90 dark:border-white/10 bg-white dark:bg-surface-900 p-4 sm:p-6 shadow-2xl flex flex-col max-h-[86vh] overflow-hidden">
        
        {{-- Header Modal --}}
        <div class="flex items-center justify-between pb-3 border-b border-surface-100 dark:border-white/10 shrink-0">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-500/15 text-amber-500 text-2xl border border-amber-400/30 shrink-0 shadow-xs">
                    <svg class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-black text-surface-900 dark:text-white leading-tight">
                        Papan Peringkat Harian
                    </h3>
                    <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">
                        Top 10 Harian • Direset Tiap Jam 07:00 WITA
                    </p>
                </div>
            </div>
            <button id="btn-close-leaderboard" type="button" class="p-2 rounded-xl text-surface-400 hover:text-surface-900 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/5 transition cursor-pointer" aria-label="Tutup Papan Peringkat">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Info Bar: Periode & Countdown Reset 07:00 WITA --}}
        <div class="my-3 rounded-2xl bg-amber-500/10 border border-amber-400/20 px-3.5 py-2.5 flex items-center justify-between gap-2 shrink-0 text-xs">
            <div class="flex items-center gap-2">
                <svg class="h-3.5 w-3.5 text-surface-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/>
                </svg>
                <span id="lb-period-text" class="font-bold text-surface-800 dark:text-surface-200 text-xs">Memuat...</span>
                <span class="text-surface-400">•</span>
                <span id="lb-participants-badge" class="font-bold text-primary-600 dark:text-primary-400 text-xs">0 Peserta</span>
            </div>
            <div class="flex items-center gap-1.5 text-amber-600 dark:text-amber-400 font-bold text-xs">
                <svg class="h-3.5 w-3.5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Reset: <span id="lb-reset-countdown" class="font-mono font-black text-xs text-amber-600 dark:text-amber-300">--:--:--</span></span>
            </div>
        </div>

        {{-- Scrollable Leaderboard List (Area Khusus Scroll Lancar) --}}
        <div id="lb-scroll-container" class="min-h-0 flex-1 overflow-y-auto overscroll-contain pr-1.5 space-y-3" style="-webkit-overflow-scrolling: touch;">
            {{-- Loading State --}}
            <div id="lb-loading-state" class="py-12 text-center text-surface-400 space-y-2">
                <div class="inline-flex items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <p class="text-xs font-semibold">Mengambil data peringkat...</p>
            </div>

            {{-- Empty State --}}
            <div id="lb-empty-state" class="hidden py-12 text-center text-surface-400 space-y-3">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-500 border border-amber-400/20">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.004 0A5.25 5.25 0 0012 3a5.25 5.25 0 00-5.25 11.25m10.5 0a5.25 5.25 0 01-5.25 0m0 0a5.25 5.25 0 00-5.25 0"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-surface-800 dark:text-surface-200">Belum Ada Skor di Papan Peringkat Hari Ini</h4>
                <p class="text-xs max-w-sm mx-auto text-surface-500 dark:text-surface-400">
                    Jadilah pemain pertama yang menuntaskan tantangan hari ini dan raih posisi teratas Top 10 sebelum jam 07:00 WITA!
                </p>
            </div>

            {{-- Top 3 Podium Cards Container (Fokus Utama: Juara 1, 2, 3) --}}
            <div id="lb-top3-container" class="hidden space-y-2.5 sm:space-y-3">
                {{-- Inserted via JS: Juara 1, 2, 3 --}}
            </div>

            {{-- Collapsible Section: Peringkat 4 s.d. 10 (Menu Arrow Dropdown) --}}
            <div id="lb-section-top10" class="hidden pt-1">
                <button id="btn-toggle-top10" type="button" class="w-full flex items-center justify-between p-3.5 rounded-2xl bg-surface-50 dark:bg-surface-800/60 hover:bg-surface-100 dark:hover:bg-surface-800 border border-surface-200 dark:border-white/10 transition-all cursor-pointer shadow-xs active:scale-[0.99]">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary-500/15 text-primary-600 dark:text-primary-400 font-black text-xs">
                            4-10
                        </div>
                        <div class="text-left">
                            <h4 class="text-xs sm:text-sm font-black text-surface-900 dark:text-white">Peringkat 4 s.d. 10</h4>
                            <p class="text-[11px] text-surface-500 dark:text-surface-400 font-medium"><span id="lb-top10-count-badge">0</span> Pemain Terdaftar</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="lb-top10-toggle-text" class="text-xs font-bold text-primary-600 dark:text-primary-400">Lihat</span>
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-surface-200/60 dark:bg-white/5">
                            <svg id="lb-top10-arrow" class="h-4 w-4 transform transition-transform duration-300 text-surface-600 dark:text-surface-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </button>
                <div id="lb-top4to10-container" class="hidden space-y-2 mt-2.5 transition-all">
                    {{-- Inserted via JS: Peringkat 4 - 10 --}}
                </div>
            </div>

            {{-- Collapsible Section: Peringkat Lainnya (11+) (Menu Arrow Dropdown) --}}
            <div id="lb-section-others" class="hidden pt-1">
                <button id="btn-toggle-others" type="button" class="w-full flex items-center justify-between p-3.5 rounded-2xl bg-surface-50/70 dark:bg-surface-800/40 hover:bg-surface-100 dark:hover:bg-surface-800 border border-surface-200 dark:border-white/10 transition-all cursor-pointer shadow-xs active:scale-[0.99]">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-surface-200 dark:bg-surface-700 text-surface-600 dark:text-surface-300 font-black text-xs">
                            11+
                        </div>
                        <div class="text-left">
                            <h4 class="text-xs sm:text-sm font-bold text-surface-800 dark:text-surface-200">Peringkat Lainnya (11+)</h4>
                            <p class="text-[11px] text-surface-500 dark:text-surface-400 font-medium"><span id="lb-others-count-badge">0</span> Pemain</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span id="lb-others-toggle-text" class="text-xs font-bold text-surface-500">Lihat</span>
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-surface-200/60 dark:bg-white/5">
                            <svg id="lb-others-arrow" class="h-4 w-4 transform transition-transform duration-300 text-surface-600 dark:text-surface-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </button>
                <div id="lb-others-container" class="hidden space-y-2 mt-2.5 transition-all">
                    {{-- Inserted via JS: Peringkat 11+ --}}
                </div>
            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="pt-3 border-t border-surface-100 dark:border-white/10 flex items-center justify-between shrink-0 text-xs">
            <span class="text-surface-500 dark:text-surface-400 text-[11px]">
                Skor dihitung dari ketepatan, efisiensi Wordle, & waktu.
            </span>
            <button id="btn-refresh-leaderboard" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-surface-200 dark:border-white/10 hover:bg-surface-100 dark:hover:bg-white/5 font-bold text-xs text-surface-700 dark:text-surface-300 transition cursor-pointer">
                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                </svg>
                <span>Segarkan</span>
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
        const NEXT_RESET_ISO = @json($nextResetIso ?? null);
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

        // Leaderboard & Scoring State
        let gameStartTime = null;
        let gameEndTime = null;
        let durationSeconds = 0;
        let quizFirstTryCorrect = 0;
        let retryCount = 0;
        let currentComputedScore = null;
        let hasSubmittedLeaderboard = false;
        let lbResetInterval = null;

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
            if (!gameStartTime) {
                gameStartTime = Date.now();
            }
            quizFirstTryCorrect = 0;

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

            // Acak urutan soal (Fisher-Yates Shuffle) agar setiap orang mendapat paket soal yang sama tetapi urutan tampilnya acak
            for (let i = quizQueue.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [quizQueue[i], quizQueue[j]] = [quizQueue[j], quizQueue[i]];
            }

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

            // Acak posisi tombol MITOS vs FAKTA (kiri/kanan) pada setiap pertanyaan
            const optionsContainer = document.getElementById('quiz-options-container');
            const btnMitos = document.getElementById('btn-choose-mitos');
            const btnFakta = document.getElementById('btn-choose-fakta');
            if (optionsContainer && btnMitos && btnFakta) {
                if (Math.random() < 0.5) {
                    optionsContainer.appendChild(btnMitos); // FAKTA di kiri, MITOS di kanan
                } else {
                    optionsContainer.appendChild(btnFakta); // MITOS di kiri, FAKTA di kanan
                }
            }

            if (optionsContainer) optionsContainer.classList.remove('hidden');
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
                feedbackIcon.innerHTML = '<svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
                feedbackTitle.innerText = 'Tepat Sekali! Jawaban Kamu Benar.';

                // Catat benar pada percobaan pertama (bukan remedial)
                if (!isRemedialSession) {
                    quizFirstTryCorrect++;
                }

                // If not already counted as mastered
                if (!currentQuestion._mastered) {
                    currentQuestion._mastered = true;
                    masteredCount++;
                    updateQuizProgress();
                }
            } else {
                playSound('wrong');
                feedbackHeader.className = 'flex items-center gap-2 text-base font-black text-rose-600 dark:text-danger-400';
                feedbackIcon.innerHTML = '<svg class="w-6 h-6 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>';
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
                ind1.innerHTML = '<span>Kata 1</span><svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
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
            gameEndTime = Date.now();
            durationSeconds = Math.max(5, Math.round(((gameEndTime - (gameStartTime || gameEndTime)) / 1000)));

            const w1Attempts = (wordGuesses[0] && wordGuesses[0].length) ? wordGuesses[0].length : 6;
            const w2Attempts = (wordGuesses[1] && wordGuesses[1].length) ? wordGuesses[1].length : 6;

            const computed = computeClientScore(
                quizFirstTryCorrect,
                word1Won,
                w1Attempts,
                word2Won,
                w2Attempts,
                durationSeconds,
                retryCount
            );
            currentComputedScore = computed;

            const record = {
                date: TODAY_DATE,
                isVictory: isVictory,
                word1Won: word1Won,
                word2Won: word2Won,
                wordGuesses: wordGuesses,
                targetWords: targetWords,
                timestamp: Date.now(),
                durationSeconds: durationSeconds,
                quizFirstTryCorrect: quizFirstTryCorrect,
                w1Attempts: w1Attempts,
                w2Attempts: w2Attempts,
                retryCount: retryCount,
                scoreDetails: computed
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
            const scoreSection = document.getElementById('result-score-section');
            const lbEntryCard = document.getElementById('leaderboard-entry-card');

            if (isVictory) {
                playSound('victory');
                triggerConfetti();

                resultCard.className = 'rounded-3xl border border-emerald-500/40 bg-gradient-to-br from-emerald-950/40 via-surface-900 to-surface-950 p-6 sm:p-10 text-center shadow-2xl';
                resultBadgeIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-500/20 text-emerald-400 text-4xl mb-4 border border-emerald-400/30 glow-gold';
                resultBadgeIcon.innerHTML = '<svg class="w-10 h-10 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                resultPill.className = 'inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 mb-2';
                resultPill.innerText = 'LULUS SEMPURNA!';
                resultTitle.innerText = 'Selamat! Kamu Menaklukkan Wordle SKENA!';
                resultDesc.innerText = 'Dua kata kunci bahaya narkoba berhasil kamu tebak berkat pemahaman tajam dari babak Mitos/Fakta. Terus pertahankan wawasan ini!';

                // Hitung / siapkan skor detail
                const score = record.scoreDetails || computeClientScore(
                    record.quizFirstTryCorrect ?? 5,
                    record.word1Won ?? true,
                    record.w1Attempts ?? 2,
                    record.word2Won ?? true,
                    record.w2Attempts ?? 2,
                    record.durationSeconds ?? 60,
                    record.retryCount ?? 0
                );
                currentComputedScore = score;
                durationSeconds = score.duration_seconds;
                quizFirstTryCorrect = score.quiz_correct_count;
                retryCount = score.retry_count;

                // PULIHKAN SEMUA VARIABEL GAME KE MEMORY AGAR TIDAK KOSONG SAAT REFRESH
                word1Won = (record.word1Won !== undefined) ? Boolean(record.word1Won) : true;
                word2Won = (record.word2Won !== undefined) ? Boolean(record.word2Won) : true;
                wordGuesses = record.wordGuesses || [[], []];
                if (record.targetWords) targetWords = record.targetWords;

                // Tampilkan Score Section
                if (scoreSection) {
                    scoreSection.classList.remove('hidden');
                    document.getElementById('score-grand-total').innerText = Number(score.total_score).toLocaleString('id-ID');
                    const badgeIconEl = document.getElementById('score-badge-icon');
                    if (badgeIconEl) {
                        badgeIconEl.innerHTML = '<svg class="h-4 w-4 text-amber-300 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
                    }
                    document.getElementById('score-badge-title').innerText = score.badge_title;

                    document.getElementById('score-quiz-val').innerText = '+' + score.quiz_score + ' Pts';
                    document.getElementById('score-quiz-detail').innerText = score.quiz_correct_count + '/5 Soal Tepat (Pertama)';

                    document.getElementById('score-w1-val').innerText = '+' + score.word1_score + ' Pts';
                    document.getElementById('score-w1-detail').innerText = 'Tebakan ke-' + score.word1_attempts;

                    document.getElementById('score-w2-val').innerText = '+' + score.word2_score + ' Pts';
                    document.getElementById('score-w2-detail').innerText = 'Tebakan ke-' + score.word2_attempts;

                    document.getElementById('score-speed-val').innerText = '+' + score.speed_bonus + ' Pts';
                    document.getElementById('score-speed-detail').innerText = 'Durasi: ' + formatDuration(score.duration_seconds);

                    if (score.retry_count > 0) {
                        document.getElementById('score-retry-val').innerText = '-' + score.retry_penalty + ' Pts';
                        document.getElementById('score-retry-val').className = 'text-sm sm:text-base font-black text-rose-400 mt-0.5 block';
                        document.getElementById('score-retry-detail').innerText = 'Mengulang ' + score.retry_count + 'x';
                    } else {
                        document.getElementById('score-retry-val').innerText = '0 Pts (First Try!)';
                        document.getElementById('score-retry-val').className = 'text-sm sm:text-base font-black text-emerald-400 mt-0.5 block';
                        document.getElementById('score-retry-detail').innerText = 'Menuntaskan tanpa mengulang';
                    }
                }

                // Tampilkan Form Input Nama Leaderboard / Status Terdaftar
                if (lbEntryCard) {
                    lbEntryCard.classList.remove('hidden');
                    const savedName = record.submittedPlayerName || localStorage.getItem('skena_player_name') || '';
                    const nameField = document.getElementById('input-player-name');
                    if (nameField && savedName) nameField.value = savedName;

                    const formLb = document.getElementById('form-submit-leaderboard');
                    const successCard = document.getElementById('leaderboard-submit-success');
                    const cardTitle = document.getElementById('leaderboard-card-title');
                    const isAlreadySubmitted = Boolean(record.hasSubmittedLeaderboard || hasSubmittedLeaderboard);

                    if (isAlreadySubmitted) {
                        hasSubmittedLeaderboard = true;
                        if (formLb) formLb.classList.add('hidden');
                        if (cardTitle) cardTitle.innerText = 'Papan Peringkat Harian (Sudah Tercatat)';
                        if (successCard) {
                            successCard.classList.remove('hidden');
                            applyLeaderboardRankBadge(record.submittedRank, record.submittedPlayerName || savedName);
                        }
                        // Refresh live rank terkini dari database server saat kembali ke halaman
                        refreshLivePlayerRank();
                    } else {
                        if (formLb) formLb.classList.remove('hidden');
                        if (cardTitle) cardTitle.innerText = 'Catat Namamu di Top 10 Hari Ini';
                        if (successCard) successCard.classList.add('hidden');
                    }
                }

                // Tampilkan kata jika menang (karena pemain sudah berhasil menebaknya)
                if (resultWordsContainer) {
                    resultWordsContainer.classList.remove('hidden');
                    document.getElementById('result-word1-title').innerText = w1.word;
                    document.getElementById('result-word1-def').innerText = w1.definition;
                    document.getElementById('result-word2-title').innerText = w2.word;
                    document.getElementById('result-word2-def').innerText = w2.definition;
                }
                if (resultCountdownBox) resultCountdownBox.classList.remove('hidden');
                if (btnRestart) btnRestart.innerHTML = '<svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg><span>Main Lagi</span>';
            } else {
                resultCard.className = 'rounded-3xl border border-danger-500/40 bg-gradient-to-br from-danger-950/40 via-surface-900 to-surface-950 p-6 sm:p-10 text-center shadow-2xl';
                resultBadgeIcon.className = 'mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-danger-500/20 text-danger-400 text-4xl mb-4 border border-danger-400/30';
                resultBadgeIcon.innerHTML = '<svg class="w-10 h-10 text-danger-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
                resultPill.className = 'inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-danger-500/20 text-danger-300 mb-2';
                resultPill.innerText = 'KESEMPATAN HABIS (GAME OVER)';
                resultTitle.innerText = 'Sayang Sekali, Kesempatanmu Habis!';
                resultDesc.innerText = 'Kesempatan menebak telah habis. Silakan mengulang dari babak awal untuk mencoba kembali!';

                // Sembunyikan skor & form leaderboard jika kalah
                if (scoreSection) scoreSection.classList.add('hidden');
                if (lbEntryCard) lbEntryCard.classList.add('hidden');

                // Sembunyikan jawaban sama sekali agar pemain tidak bisa mencoba ulang dengan mengetahui jawaban
                if (resultWordsContainer) {
                    resultWordsContainer.classList.add('hidden');
                }
                document.getElementById('result-word1-title').innerText = '';
                document.getElementById('result-word1-def').innerText = '';
                document.getElementById('result-word2-title').innerText = '';
                document.getElementById('result-word2-def').innerText = '';

                if (resultCountdownBox) resultCountdownBox.classList.add('hidden');
                if (btnRestart) btnRestart.innerHTML = '<svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg><span>Mengulang</span>';
            }

            // Generate grid tiles
            generateGridTiles(record);

            showView(viewResult);
            startCountdown();
        }

        function buildShareMessage(record) {
            const w1Target = (record.targetWords ? record.targetWords[0].word : activePuzzle.words[0].word).toUpperCase();
            const w2Target = (record.targetWords ? record.targetWords[1].word : activePuzzle.words[1].word).toUpperCase();
            const guesses1 = record.wordGuesses ? record.wordGuesses[0] || [] : [];
            const guesses2 = record.wordGuesses ? record.wordGuesses[1] || [] : [];

            const currentName = document.getElementById('input-player-name')?.value?.trim() ||
                                localStorage.getItem('skena_player_name') ||
                                'Pemain SKENA';

            const score = currentComputedScore || computeClientScore(
                record.quizFirstTryCorrect ?? 5,
                record.word1Won ?? true,
                record.w1Attempts ?? 2,
                record.word2Won ?? true,
                record.w2Attempts ?? 2,
                record.durationSeconds ?? 60,
                record.retryCount ?? 0
            );

            let grid1 = '';
            guesses1.forEach(g => {
                grid1 += evaluateToSharePattern(g, w1Target) + '\n';
            });

            let grid2 = '';
            if (guesses2.length > 0) {
                guesses2.forEach(g => {
                    grid2 += evaluateToSharePattern(g, w2Target) + '\n';
                });
            }

            const gameUrl = window.location.origin + window.location.pathname;
            const formattedTotalScore = Number(score.total_score).toLocaleString('id-ID');
            const durationText = formatDuration(score.duration_seconds);

            let msg = `*TANTANGAN MINI GAMES SKENA BNNP SULTENG*\n`;
            msg += `_Edukasi Pencegahan Narkoba & Asah Otak Harian_\n\n`;

            msg += `*HASIL SKOR SAYA HARI INI:*\n`;
            msg += `• Nama: *${currentName}*\n`;
            msg += `• Total Skor: *${formattedTotalScore} PTS*\n`;
            msg += `• Gelar: *${score.badge_title}*\n`;
            msg += `• Waktu Selesai: *${durationText}*\n`;
            msg += `• Mitos atau Fakta: *${score.quiz_correct_count}/5 Benar (Babak 1)*\n\n`;

            msg += `*PAPAN TEBAK KATA (WORDLE):*\n`;
            msg += `Kata 1 (${record.word1Won ? guesses1.length : 'X'}/6):\n${grid1}`;
            if (grid2) {
                msg += `Kata 2 (${record.word2Won ? guesses2.length : 'X'}/6):\n${grid2}`;
            }

            msg += `\n*BERANI KALAHKAN SKORKU?*\n`;
            msg += `Buktikan wawasanmu dan rebut posisi Top 10 di Papan Peringkat Harian BNNP Sulteng! Reset setiap jam 07:00 WITA.\n\n`;
            msg += `*Ayo Mainkan Sekarang (Gratis & Seru):*\n${gameUrl}\n\n`;
            msg += `#SKENABNNP #BNNPSulteng #WarOnDrugs #IndonesiaBersinar #TolakNarkoba`;

            return msg;
        }

        function openWhatsAppShare(text) {
            const btnShareText = document.getElementById('btn-share-text');
            if (btnShareText) {
                btnShareText.innerText = 'Membuka WhatsApp...';
                setTimeout(() => {
                    btnShareText.innerText = 'Bagikan Skor & Tantang di WhatsApp';
                }, 3000);
            }
            const waUrl = 'https://wa.me/?text=' + encodeURIComponent(text);
            window.open(waUrl, '_blank');
        }

        function evaluateTileStatuses(guess, target) {
            const len = target.length;
            const statuses = new Array(len).fill('absent');
            const counts = {};
            for (let i = 0; i < len; i++) {
                const c = target[i];
                counts[c] = (counts[c] || 0) + 1;
            }
            for (let i = 0; i < len; i++) {
                if (guess[i] === target[i]) {
                    statuses[i] = 'correct';
                    counts[guess[i]]--;
                }
            }
            for (let i = 0; i < len; i++) {
                if (statuses[i] === 'correct') continue;
                const c = guess[i];
                if (counts[c] && counts[c] > 0) {
                    statuses[i] = 'present';
                    counts[c]--;
                }
            }
            return statuses;
        }

        function evaluateToSharePattern(guess, target) {
            const statuses = evaluateTileStatuses(guess, target);
            return statuses.map(s => s === 'correct' ? '[V]' : (s === 'present' ? '[?]' : '[-]')).join(' ');
        }

        function generateGridTiles(record) {
            const container = document.getElementById('result-emoji-grid');
            container.innerHTML = '';

            const w1Target = (record.targetWords ? record.targetWords[0].word : activePuzzle.words[0].word).toUpperCase();
            const w2Target = (record.targetWords ? record.targetWords[1].word : activePuzzle.words[1].word).toUpperCase();
            const guesses1 = record.wordGuesses ? record.wordGuesses[0] || [] : [];
            const guesses2 = record.wordGuesses ? record.wordGuesses[1] || [] : [];

            function renderGuessRow(statuses) {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-center gap-1.5 py-0.5';
                statuses.forEach(status => {
                    const tile = document.createElement('span');
                    if (status === 'correct') {
                        tile.className = 'w-6 h-6 rounded-md bg-emerald-600 flex items-center justify-center text-white shadow-xs';
                        tile.innerHTML = '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
                    } else if (status === 'present') {
                        tile.className = 'w-6 h-6 rounded-md bg-amber-500 flex items-center justify-center text-white shadow-xs';
                        tile.innerHTML = '<svg class="w-2.5 h-2.5 fill-current shrink-0" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>';
                    } else {
                        tile.className = 'w-6 h-6 rounded-md bg-surface-700/80 dark:bg-surface-800 flex items-center justify-center text-surface-400 shadow-xs';
                        tile.innerHTML = '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                    }
                    row.appendChild(tile);
                });
                return row;
            }

            guesses1.forEach(guess => {
                const statuses = evaluateTileStatuses(guess, w1Target);
                container.appendChild(renderGuessRow(statuses));
            });

            if (guesses2.length > 0) {
                const sep = document.createElement('div');
                sep.className = 'my-1 border-t border-white/10';
                container.appendChild(sep);

                guesses2.forEach(guess => {
                    const statuses = evaluateTileStatuses(guess, w2Target);
                    container.appendChild(renderGuessRow(statuses));
                });
            }

            // Setup share button
            const btnShare = document.getElementById('btn-share-score');
            const btnShareText = document.getElementById('btn-share-text');

            if (btnShare) {
                btnShare.onclick = () => {
                    playSound('click');
                    const fullShareText = buildShareMessage(record);

                    // 1. Selalu salin ke clipboard untuk kemudahan pemain
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(fullShareText).catch(() => {});
                    }

                    // 2. Jika di smartphone, utamakan Web Share API agar membuka WhatsApp langsung
                    if (navigator.share && /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent)) {
                        navigator.share({
                            title: 'Skor Mini Games SKENA BNNP Sulteng',
                            text: fullShareText
                        }).then(() => {
                            if (btnShareText) btnShareText.innerText = 'Tersalin & Berhasil Dibagikan!';
                            setTimeout(() => {
                                if (btnShareText) btnShareText.innerText = 'Bagikan Skor & Tantang di WhatsApp';
                            }, 3000);
                        }).catch(() => {
                            openWhatsAppShare(fullShareText);
                        });
                    } else {
                        // Desktop: buka wa.me
                        openWhatsAppShare(fullShareText);
                    }
                };
            }
        }

        // Countdown Timer ke Reset Soal Baru & Leaderboard (Setiap Jam 07:00 WITA)
        function startCountdown() {
            const timerEl = document.getElementById('countdown-timer');
            if (!timerEl) return;

            let targetTime = NEXT_RESET_ISO ? new Date(NEXT_RESET_ISO).getTime() : null;
            if (!targetTime || isNaN(targetTime)) {
                // Fallback jika NEXT_RESET_ISO tidak tersedia: hitung jam 07:00 WITA (UTC+8) berikutnya
                const now = new Date();
                const witaNow = new Date(now.getTime() + (8 * 60 + now.getTimezoneOffset()) * 60000);
                const nextResetWita = new Date(witaNow);
                if (witaNow.getHours() >= 7) {
                    nextResetWita.setDate(nextResetWita.getDate() + 1);
                }
                nextResetWita.setHours(7, 0, 0, 0);
                targetTime = now.getTime() + (nextResetWita - witaNow);
            }

            function updateTimer() {
                const now = Date.now();
                const diffMs = targetTime - now;
                if (diffMs <= 0) {
                    timerEl.innerText = '00:00:00 (Reset!)';
                    setTimeout(() => location.reload(), 2000);
                    return;
                }

                const totalSec = Math.floor(diffMs / 1000);
                const hours = Math.floor(totalSec / 3600);
                const mins = Math.floor((totalSec % 3600) / 60);
                const secs = totalSec % 60;

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

        // ══════════════════════════════════════════════════════════
        // LEADERBOARD & SCORING ALGORITHM HELPERS
        // ══════════════════════════════════════════════════════════
        function getDeviceFingerprint() {
            let fp = localStorage.getItem('skena_device_fp');
            if (!fp) {
                fp = 'fp_' + Math.random().toString(36).substring(2, 12) + '_' + Date.now();
                localStorage.setItem('skena_device_fp', fp);
            }
            return fp;
        }

        function formatDuration(totalSec) {
            const m = Math.floor(totalSec / 60);
            const s = totalSec % 60;
            return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }

        function escapeHtml(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.innerText = str;
            return div.innerHTML;
        }

        // Tampilkan badge peringkat pemain secara dinamis sesuai peringkat terkini
        function applyLeaderboardRankBadge(rankNum, playerName) {
            const titleEl = document.getElementById('leaderboard-success-title');
            const nameBadge = document.getElementById('leaderboard-submitted-name-badge');
            const rank = parseInt(rankNum, 10);

            if (titleEl) {
                if (rank && rank <= 3) {
                    titleEl.innerText = 'Luar Biasa! Kamu Masuk Top 3 (Peringkat #' + rank + ')!';
                } else if (rank && rank <= 10) {
                    titleEl.innerText = 'Hebat! Kamu Masuk Top 10 (Peringkat #' + rank + ')!';
                } else if (rank) {
                    titleEl.innerText = 'Skormu Tercatat di Peringkat #' + rank + '!';
                } else {
                    titleEl.innerText = 'Skormu Sudah Tercatat di Papan Peringkat!';
                }
            }

            if (nameBadge) {
                const displayName = playerName || localStorage.getItem('skena_player_name') || 'Pemain';
                nameBadge.innerText = displayName + (rank ? ' (Peringkat #' + rank + ')' : '');
            }
        }

        // Sinkronisasi posisi peringkat live (terbaru) langsung dari server ke tampilan hasil
        function refreshLivePlayerRank() {
            const fp = getDeviceFingerprint();
            const savedName = localStorage.getItem('skena_player_name') || '';

            fetch('{{ route('game.leaderboard') }}?device_fingerprint=' + encodeURIComponent(fp) + '&player_name=' + encodeURIComponent(savedName))
                .then(res => res.json())
                .then(res => {
                    if (res && res.success && res.player_rank && res.player_rank.found) {
                        const liveRank = res.player_rank.rank;
                        const liveName = res.player_rank.player_name || savedName;
                        applyLeaderboardRankBadge(liveRank, liveName);

                        try {
                            const saved = localStorage.getItem(STORAGE_KEY_TODAY);
                            if (saved) {
                                const rec = JSON.parse(saved);
                                rec.submittedRank = liveRank;
                                rec.submittedPlayerName = liveName;
                                rec.hasSubmittedLeaderboard = true;
                                localStorage.setItem(STORAGE_KEY_TODAY, JSON.stringify(rec));
                            }
                        } catch (e) {}
                    }
                })
                .catch(() => {});
        }

        function computeClientScore(quizCorrect, w1Won, w1Att, w2Won, w2Att, duration, retries) {
            const qScore = Math.min(5, Math.max(0, quizCorrect)) * 60;

            let w1Score = 0;
            if (w1Won) {
                const bonusMap = [0, 100, 80, 60, 40, 20, 0];
                w1Score = 250 + (bonusMap[w1Att] ?? 0);
            }

            let w2Score = 0;
            if (w2Won) {
                const bonusMap = [0, 100, 80, 60, 40, 20, 0];
                w2Score = 250 + (bonusMap[w2Att] ?? 0);
            }

            let spBonus = 15;
            if (duration <= 60) spBonus = 100;
            else if (duration <= 120) spBonus = 80;
            else if (duration <= 180) spBonus = 60;
            else if (duration <= 300) spBonus = 40;

            const rPenalty = Math.min(150, retries * 50);
            const total = Math.max(0, qScore + w1Score + w2Score + spBonus - rPenalty);

            let badge = 'Sahabat Sadar P4GN';
            if (total >= 1000) { badge = 'Master P4GN Paripurna'; }
            else if (total >= 850) { badge = 'Pejuang Bersinar Tangguh'; }
            else if (total >= 700) { badge = 'Relawan Sadar Narkoba'; }
            else if (total >= 500) { badge = 'Penggiat Muda P4GN'; }

            return {
                total_score: total,
                quiz_score: qScore,
                quiz_correct_count: quizCorrect,
                word1_score: w1Score,
                word1_attempts: w1Att,
                word2_score: w2Score,
                word2_attempts: w2Att,
                speed_bonus: spBonus,
                retry_penalty: rPenalty,
                retry_count: retries,
                duration_seconds: duration,
                badge_title: badge
            };
        }

        // ══════════════════════════════════════════════════════════
        // LEADERBOARD MODAL LOGIC (RESET 07:00 WITA)
        // ══════════════════════════════════════════════════════════
        const modalLeaderboard = document.getElementById('modal-leaderboard');
        function lockBodyScrollForLb() {
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
        }

        function unlockBodyScrollForLb() {
            document.body.style.overflow = '';
            document.documentElement.style.overflow = '';
        }

        function openLeaderboardModal(highlightPlayerName) {
            playSound('click');
            if (modalLeaderboard) {
                modalLeaderboard.classList.remove('hidden');
                lockBodyScrollForLb();
                loadLeaderboardData(highlightPlayerName);
            }
        }

        function closeLeaderboardModal() {
            if (modalLeaderboard) {
                modalLeaderboard.classList.add('hidden');
                unlockBodyScrollForLb();
            }
            if (lbResetInterval) {
                clearInterval(lbResetInterval);
                lbResetInterval = null;
            }
        }

        // Collapsible Accordion State for Leaderboard Modal
        let isTop10Expanded = false;
        let isOthersExpanded = false;

        function setTop10Expanded(expanded) {
            isTop10Expanded = expanded;
            const cont = document.getElementById('lb-top4to10-container');
            const arrow = document.getElementById('lb-top10-arrow');
            const txt = document.getElementById('lb-top10-toggle-text');
            if (cont) {
                if (expanded) {
                    cont.classList.remove('hidden');
                    if (arrow) arrow.style.transform = 'rotate(180deg)';
                    if (txt) txt.innerText = 'Tutup';
                } else {
                    cont.classList.add('hidden');
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                    if (txt) txt.innerText = 'Lihat';
                }
            }
        }

        function setOthersExpanded(expanded) {
            isOthersExpanded = expanded;
            const cont = document.getElementById('lb-others-container');
            const arrow = document.getElementById('lb-others-arrow');
            const txt = document.getElementById('lb-others-toggle-text');
            if (cont) {
                if (expanded) {
                    cont.classList.remove('hidden');
                    if (arrow) arrow.style.transform = 'rotate(180deg)';
                    if (txt) txt.innerText = 'Tutup';
                } else {
                    cont.classList.add('hidden');
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                    if (txt) txt.innerText = 'Lihat';
                }
            }
        }

        function loadLeaderboardData(highlightPlayerName) {
            const loading = document.getElementById('lb-loading-state');
            const empty = document.getElementById('lb-empty-state');
            const top3Cont = document.getElementById('lb-top3-container');
            const sectionTop10 = document.getElementById('lb-section-top10');
            const top4to10Cont = document.getElementById('lb-top4to10-container');
            const top10Badge = document.getElementById('lb-top10-count-badge');
            const sectionOthers = document.getElementById('lb-section-others');
            const othersCont = document.getElementById('lb-others-container');
            const othersBadge = document.getElementById('lb-others-count-badge');

            if (!loading) return;

            loading.classList.remove('hidden');
            empty.classList.add('hidden');
            top3Cont.classList.add('hidden');
            if (sectionTop10) sectionTop10.classList.add('hidden');
            if (sectionOthers) sectionOthers.classList.add('hidden');

            const fp = getDeviceFingerprint();
            const pName = highlightPlayerName || localStorage.getItem('skena_player_name') || '';

            fetch('{{ route('game.leaderboard') }}?device_fingerprint=' + encodeURIComponent(fp) + '&player_name=' + encodeURIComponent(pName))
                .then(res => res.json())
                .then(res => {
                    loading.classList.add('hidden');
                    if (!res.success) return;

                    // Sinkronisasi Live Rank pemain terkini ke tampilan kartu hasil
                    if (res.player_rank && res.player_rank.found) {
                        applyLeaderboardRankBadge(res.player_rank.rank, res.player_rank.player_name);
                        try {
                            const saved = localStorage.getItem(STORAGE_KEY_TODAY);
                            if (saved) {
                                const rec = JSON.parse(saved);
                                rec.submittedRank = res.player_rank.rank;
                                rec.submittedPlayerName = res.player_rank.player_name;
                                rec.hasSubmittedLeaderboard = true;
                                localStorage.setItem(STORAGE_KEY_TODAY, JSON.stringify(rec));
                            }
                        } catch (e) {}
                    }

                    const periodEl = document.getElementById('lb-period-text');
                    const partEl = document.getElementById('lb-participants-badge');
                    if (periodEl) periodEl.innerText = res.period_formatted || res.period_date;
                    if (partEl) partEl.innerText = (res.total_participants || 0) + ' Peserta';

                    // Countdown timer ke 07:00 WITA
                    setupResetCountdown(res.next_reset_iso);

                    const all = res.all || [];
                    if (all.length === 0) {
                        empty.classList.remove('hidden');
                        return;
                    }

                    // Render Top 3 (Selalu Tampil agar fokus utama pada Juara 1, 2, 3)
                    const top3 = all.filter(p => p.rank <= 3);
                    if (top3.length > 0) {
                        top3Cont.innerHTML = '';
                        top3.forEach(player => {
                            top3Cont.appendChild(createTop3PodiumRow(player, highlightPlayerName));
                        });
                        top3Cont.classList.remove('hidden');
                    }

                    // Render Top 4-10 (Collapsible Accordion dengan Menu Arrow)
                    const top4to10 = all.filter(p => p.rank >= 4 && p.rank <= 10);
                    if (top4to10.length > 0) {
                        top4to10Cont.innerHTML = '';
                        top4to10.forEach(player => {
                            top4to10Cont.appendChild(createStandardRow(player, highlightPlayerName));
                        });
                        if (top10Badge) top10Badge.innerText = top4to10.length;
                        if (sectionTop10) sectionTop10.classList.remove('hidden');

                        // Cek apakah pemain yang sedang disorot ada di peringkat 4-10
                        const isUserInTop10 = highlightPlayerName && top4to10.some(p => p.player_name.toLowerCase() === highlightPlayerName.toLowerCase());
                        setTop10Expanded(isUserInTop10); // Buka jika pemain ada di sini, default tutup agar fokus ke Top 3
                    }

                    // Render Others (11+) (Collapsible Accordion dengan Menu Arrow)
                    const others = all.filter(p => p.rank > 10);
                    if (others.length > 0) {
                        othersCont.innerHTML = '';
                        others.forEach(player => {
                            othersCont.appendChild(createOthersRow(player, highlightPlayerName));
                        });
                        if (othersBadge) othersBadge.innerText = others.length;
                        if (sectionOthers) sectionOthers.classList.remove('hidden');

                        const isUserInOthers = highlightPlayerName && others.some(p => p.player_name.toLowerCase() === highlightPlayerName.toLowerCase());
                        setOthersExpanded(isUserInOthers); // Buka jika pemain ada di sini, default tutup
                    }
                })
                .catch(() => {
                    loading.classList.add('hidden');
                    empty.classList.remove('hidden');
                });
        }

        function setupResetCountdown(isoString) {
            if (lbResetInterval) clearInterval(lbResetInterval);
            const targetMs = new Date(isoString).getTime();
            const timerEl = document.getElementById('lb-reset-countdown');
            if (!timerEl) return;

            function update() {
                const now = Date.now();
                const diff = targetMs - now;
                if (diff <= 0) {
                    timerEl.innerText = '00:00:00 (Reset!)';
                    loadLeaderboardData();
                    return;
                }
                const h = Math.floor(diff / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);
                timerEl.innerText =
                    String(h).padStart(2, '0') + ':' +
                    String(m).padStart(2, '0') + ':' +
                    String(s).padStart(2, '0');
            }
            update();
            lbResetInterval = setInterval(update, 1000);
        }

        function createTop3PodiumRow(player, highlightPlayerName) {
            const isHighlight = (highlightPlayerName && player.player_name.toLowerCase() === highlightPlayerName.toLowerCase());
            const row = document.createElement('div');

            let rankBadge = '';
            let borderClass = '';
            let scoreColor = '';

            if (player.rank === 1) {
                rankBadge = 'bg-gradient-to-br from-amber-400 to-yellow-500 text-surface-950 font-black shadow-md';
                borderClass = 'border border-amber-400/60 dark:border-amber-400/30 bg-gradient-to-r from-amber-500/15 via-yellow-500/10 to-transparent dark:from-amber-500/20 dark:via-yellow-500/10 dark:to-surface-800/40 shadow-xs';
                scoreColor = 'text-amber-600 dark:text-amber-400';
            } else if (player.rank === 2) {
                rankBadge = 'bg-gradient-to-br from-slate-200 to-slate-400 text-surface-950 font-black shadow-sm';
                borderClass = 'border border-slate-300 dark:border-slate-600/40 bg-gradient-to-r from-slate-200/50 via-slate-100/30 to-transparent dark:from-slate-700/30 dark:via-slate-800/20 dark:to-surface-800/40 shadow-xs';
                scoreColor = 'text-slate-700 dark:text-slate-200';
            } else {
                rankBadge = 'bg-gradient-to-br from-amber-600 to-amber-700 text-white font-black shadow-sm';
                borderClass = 'border border-amber-600/40 dark:border-amber-700/30 bg-gradient-to-r from-amber-600/10 via-orange-500/5 to-transparent dark:from-amber-800/20 dark:via-orange-900/10 dark:to-surface-800/40 shadow-xs';
                scoreColor = 'text-amber-700 dark:text-amber-400';
            }

            row.className = `rounded-2xl p-3.5 sm:p-4 flex items-center justify-between gap-3 transition-all ${borderClass} ${isHighlight ? 'ring-2 ring-primary-500' : 'hover:scale-[1.005]'}`;

            row.innerHTML = `
                <div class="flex items-center gap-3 min-w-0">
                    <div class="flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-2xl font-black text-sm sm:text-base font-mono shadow-xs ${rankBadge}">
                        #${player.rank}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <h4 class="font-extrabold text-sm sm:text-base text-surface-900 dark:text-white truncate">
                                ${escapeHtml(player.player_name)}
                            </h4>
                            ${isHighlight ? '<span class="px-1.5 py-0.2 rounded-full text-[9px] font-black bg-primary-500 text-white animate-pulse">KAMU</span>' : ''}
                        </div>
                        <p class="text-xs text-surface-500 dark:text-surface-400 font-medium flex items-center gap-1 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-surface-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>${player.duration_formatted}</span>
                        </p>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <span class="text-base sm:text-xl font-black font-mono ${scoreColor}">
                        ${Number(player.total_score).toLocaleString('id-ID')}
                    </span>
                    <span class="block text-[10px] font-bold text-surface-400 uppercase tracking-wider">PTS</span>
                </div>
            `;
            return row;
        }

        function createStandardRow(player, highlightPlayerName) {
            const isHighlight = (highlightPlayerName && player.player_name.toLowerCase() === highlightPlayerName.toLowerCase());
            const row = document.createElement('div');

            row.className = `rounded-xl p-3 sm:p-3.5 flex items-center justify-between gap-3 border border-surface-200/80 dark:border-white/5 bg-surface-50/70 dark:bg-surface-800/40 hover:bg-surface-100 dark:hover:bg-surface-800 transition ${isHighlight ? 'ring-2 ring-primary-500' : ''}`;

            row.innerHTML = `
                <div class="flex items-center gap-3 min-w-0">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl font-black text-xs bg-primary-500/10 text-primary-600 dark:text-primary-300 border border-primary-500/20">
                        #${player.rank}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <h4 class="font-bold text-xs sm:text-sm text-surface-900 dark:text-white truncate">
                                ${escapeHtml(player.player_name)}
                            </h4>
                            ${isHighlight ? '<span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-primary-500 text-white">KAMU</span>' : ''}
                        </div>
                        <p class="text-[11px] text-surface-500 dark:text-surface-400 mt-0.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-surface-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>${player.duration_formatted}</span>
                        </p>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <span class="text-xs sm:text-sm font-black font-mono text-surface-900 dark:text-white">
                        ${Number(player.total_score).toLocaleString('id-ID')}
                    </span>
                    <span class="text-[10px] font-bold text-surface-400"> PTS</span>
                </div>
            `;
            return row;
        }

        function createOthersRow(player, highlightPlayerName) {
            const isHighlight = (highlightPlayerName && player.player_name.toLowerCase() === highlightPlayerName.toLowerCase());
            const row = document.createElement('div');

            row.className = `rounded-xl px-3 py-2 flex items-center justify-between gap-3 border border-surface-200/60 dark:border-white/5 bg-surface-50/40 dark:bg-white/[0.02] hover:bg-surface-100/60 dark:hover:bg-white/5 transition ${isHighlight ? 'ring-1 ring-primary-500' : ''}`;

            row.innerHTML = `
                <div class="flex items-center gap-2.5 min-w-0">
                    <span class="text-xs font-mono font-bold text-surface-400 w-6 text-center shrink-0">
                        #${player.rank}
                    </span>
                    <div class="min-w-0">
                        <span class="text-xs font-semibold text-surface-700 dark:text-surface-300 truncate block">
                            ${escapeHtml(player.player_name)}
                        </span>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <span class="text-xs font-bold font-mono text-surface-600 dark:text-surface-400">
                        ${Number(player.total_score).toLocaleString('id-ID')} <span class="text-[10px] text-surface-400">pts</span>
                    </span>
                </div>
            `;
            return row;
        }

        // Form Submit Handler
        const formLeaderboard = document.getElementById('form-submit-leaderboard');
        if (formLeaderboard) {
            formLeaderboard.addEventListener('submit', (e) => {
                e.preventDefault();
                if (hasSubmittedLeaderboard) return;

                const nameInput = document.getElementById('input-player-name');
                const btnSubmit = document.getElementById('btn-submit-score-lb');

                const nameVal = nameInput ? nameInput.value.trim() : '';
                if (!nameVal) return;

                playSound('click');
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span>Menyimpan...</span><svg class="h-3.5 w-3.5 animate-spin shrink-0" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                // Simpan nama di localStorage
                localStorage.setItem('skena_player_name', nameVal);

                // Pastikan attempts & status menang akurat dan tidak pernah 0 jika menang
                let w1Attempts = (wordGuesses[0] && wordGuesses[0].length) ? wordGuesses[0].length : 0;
                let w2Attempts = (wordGuesses[1] && wordGuesses[1].length) ? wordGuesses[1].length : 0;
                if (!w1Attempts && currentComputedScore) w1Attempts = currentComputedScore.word1_attempts;
                if (!w2Attempts && currentComputedScore) w2Attempts = currentComputedScore.word2_attempts;
                if (!w1Attempts) w1Attempts = 1;
                if (!w2Attempts) w2Attempts = 1;

                const isW1Won = (word1Won !== undefined && word1Won !== false) ? Boolean(word1Won) : true;
                const isW2Won = (word2Won !== undefined && word2Won !== false) ? Boolean(word2Won) : true;

                const payload = {
                    player_name: nameVal,
                    player_organization: null,
                    quiz_correct_count: quizFirstTryCorrect,
                    word1_attempts: w1Attempts,
                    word2_attempts: w2Attempts,
                    word1_won: isW1Won,
                    word2_won: isW2Won,
                    duration_seconds: durationSeconds || (currentComputedScore ? currentComputedScore.duration_seconds : 60),
                    retry_count: retryCount,
                    device_fingerprint: getDeviceFingerprint()
                };

                fetch('{{ route('game.leaderboard.submit') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        hasSubmittedLeaderboard = true;

                        // Simpan status sudah terdaftar & detailnya ke localStorage agar persisten saat refresh!
                        try {
                            const saved = localStorage.getItem(STORAGE_KEY_TODAY);
                            if (saved) {
                                const rec = JSON.parse(saved);
                                rec.hasSubmittedLeaderboard = true;
                                rec.submittedPlayerName = nameVal;
                                rec.submittedRank = data.rank;
                                rec.submittedScore = data.total_score || (currentComputedScore ? currentComputedScore.total_score : null);
                                localStorage.setItem(STORAGE_KEY_TODAY, JSON.stringify(rec));
                            }
                        } catch (e) {}

                        // Sembunyikan form input dan tampilkan status sudah terdaftar
                        const formLb = document.getElementById('form-submit-leaderboard');
                        if (formLb) formLb.classList.add('hidden');

                        const cardTitle = document.getElementById('leaderboard-card-title');
                        if (cardTitle) cardTitle.innerText = 'Papan Peringkat Harian (Sudah Tercatat)';

                        const successCard = document.getElementById('leaderboard-submit-success');
                        if (successCard) {
                            successCard.classList.remove('hidden');
                            applyLeaderboardRankBadge(data.rank, nameVal);
                        }

                        // Otomatis buka papan peringkat setelah 1.2 detik
                        setTimeout(() => {
                            openLeaderboardModal(nameVal);
                        }, 1200);
                    } else {
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML = '<span>Kirim Skor</span><svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>';
                        alert(data.message || 'Gagal mengirim skor.');
                    }
                })
                .catch(() => {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = '<span>Kirim Skor</span><svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>';
                    alert('Terjadi kesalahan koneksi saat mengirim skor.');
                });
            });
        }

        // Tombol Ganti Nama Pemain
        const btnChangePlayerName = document.getElementById('btn-change-player-name');
        if (btnChangePlayerName) {
            btnChangePlayerName.addEventListener('click', () => {
                playSound('click');
                hasSubmittedLeaderboard = false; // Buka kunci pengiriman untuk ganti nama
                const formLb = document.getElementById('form-submit-leaderboard');
                const successCard = document.getElementById('leaderboard-submit-success');
                const cardTitle = document.getElementById('leaderboard-card-title');
                if (cardTitle) cardTitle.innerText = 'Ganti Nama di Papan Peringkat';
                if (formLb) formLb.classList.remove('hidden');
                if (successCard) successCard.classList.add('hidden');

                const nameField = document.getElementById('input-player-name');
                if (nameField) {
                    nameField.focus();
                    nameField.select();
                }
                const btnSubmit = document.getElementById('btn-submit-score-lb');
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = '<span>Perbarui Nama</span><svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>';
                    btnSubmit.className = 'flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-surface-950 font-black px-4 py-2.5 text-xs sm:text-sm shadow-md transition-all active:scale-95 cursor-pointer shrink-0';
                }
            });
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
            hasSubmittedLeaderboard = false;
            retryCount++;
            gameStartTime = Date.now();

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

        // Leaderboard Modal Triggers
        const btnOpenLb = document.getElementById('btn-open-leaderboard');
        if (btnOpenLb) btnOpenLb.addEventListener('click', () => openLeaderboardModal());

        const btnViewLbIntro = document.getElementById('btn-view-leaderboard-intro');
        if (btnViewLbIntro) btnViewLbIntro.addEventListener('click', () => openLeaderboardModal());

        const btnOpenLbResult = document.getElementById('btn-open-leaderboard-result');
        if (btnOpenLbResult) btnOpenLbResult.addEventListener('click', () => openLeaderboardModal());

        const btnOpenLbFromResult = document.getElementById('btn-open-leaderboard-from-result');
        if (btnOpenLbFromResult) btnOpenLbFromResult.addEventListener('click', () => openLeaderboardModal());

        const btnViewLbAfterSubmit = document.getElementById('btn-view-lb-after-submit');
        if (btnViewLbAfterSubmit) {
            btnViewLbAfterSubmit.addEventListener('click', () => {
                const nameVal = document.getElementById('input-player-name')?.value?.trim();
                openLeaderboardModal(nameVal);
            });
        }

        const btnCloseLb = document.getElementById('btn-close-leaderboard');
        if (btnCloseLb) btnCloseLb.addEventListener('click', closeLeaderboardModal);

        const btnRefreshLb = document.getElementById('btn-refresh-leaderboard');
        if (btnRefreshLb) {
            btnRefreshLb.addEventListener('click', () => {
                playSound('click');
                const nameVal = document.getElementById('input-player-name')?.value?.trim();
                loadLeaderboardData(nameVal);
            });
        }

        // Leaderboard Collapsible Accordion Toggles
        const btnToggleTop10 = document.getElementById('btn-toggle-top10');
        if (btnToggleTop10) {
            btnToggleTop10.addEventListener('click', () => {
                playSound('click');
                setTop10Expanded(!isTop10Expanded);
            });
        }

        const btnToggleOthers = document.getElementById('btn-toggle-others');
        if (btnToggleOthers) {
            btnToggleOthers.addEventListener('click', () => {
                playSound('click');
                setOthersExpanded(!isOthersExpanded);
            });
        }

        if (modalLeaderboard) {
            modalLeaderboard.addEventListener('click', (e) => {
                if (e.target === modalLeaderboard) closeLeaderboardModal();
            });

            // Cegah scroll tembus ke background document pada gesture mobile di luar daftar peringkat
            modalLeaderboard.addEventListener('touchmove', (e) => {
                const scrollBox = document.getElementById('lb-scroll-container');
                if (!scrollBox || !scrollBox.contains(e.target)) {
                    e.preventDefault();
                }
            }, { passive: false });
        }

        // On Page Load: Check if already completed today
        const alreadyDone = checkDailyStatus();
        if (!alreadyDone) {
            showView(viewIntro);
        }

    })();
</script>
@endpush
@endsection
