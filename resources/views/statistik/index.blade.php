@extends('layouts.publik')

@section('title', 'Statistik ' . ($kategoriAktif === 'p2m' ? 'P2M' : ($kategoriAktif === 'pemberantasan' ? 'Pemberantasan' : 'Rehabilitasi')) . ' - BNNP Sulawesi Tengah')

@push('styles')
@if($kategoriAktif === 'rehabilitasi')
<style>
    /* Tooltip ApexCharts */
    .dark .apexcharts-tooltip {
        background: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5) !important;
    }
    .dark .apexcharts-tooltip-title {
        background: #0f172a !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    html:not(.dark) .apexcharts-tooltip {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #0f172a !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }
    html:not(.dark) .apexcharts-tooltip-title {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        color: #0f172a !important;
    }
    .apexcharts-text tspan {
        font-family: 'Inter', sans-serif !important;
    }
</style>
@endif
@endpush

@section('content')
<div class="relative min-h-screen py-10">
    {{-- Glow effect --}}
    <div class="pointer-events-none absolute top-10 left-1/2 -translate-x-1/2 w-3/4 max-w-4xl h-64 bg-primary-500/10 blur-[120px] rounded-full"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="text-center max-w-3xl mx-auto mb-8">
            <span class="inline-flex items-center gap-1.5 rounded-full border border-primary-200 dark:border-primary-500/30 bg-primary-50 dark:bg-primary-500/10 px-3.5 py-1 text-xs font-bold text-primary-700 dark:text-primary-400 mb-3">
                SKENA • Pusat Data Statistik Terpadu
            </span>
            <h1 class="text-3xl font-black text-surface-900 dark:text-white sm:text-4xl">
                Statistik <span class="text-primary-600 dark:text-primary-400">
                    @if($kategoriAktif === 'p2m')
                        Pencegahan & Pemberdayaan (P2M)
                    @elseif($kategoriAktif === 'pemberantasan')
                        Penindakan & Pemberantasan
                    @else
                        Klien & Layanan Rehabilitasi
                    @endif
                </span>
            </h1>
            <p class="mt-3 text-base text-surface-600 dark:text-surface-400 leading-relaxed">
                @if($kategoriAktif === 'p2m')
                    Data sebaran sosialisasi P4GN, deteksi dini skrining tes urine, penggiat anti narkoba, dan intervensi Desa Bersinar BNNP Sulawesi Tengah dalam sistem <strong class="text-surface-900 dark:text-white">SKENA</strong>.
                @elseif($kategoriAktif === 'pemberantasan')
                    Data pengungkapan kasus tindak pidana narkotika, penyitaan barang bukti, dan penegakan hukum jaringan peredaran gelap BNNP Sulawesi Tengah dalam sistem <strong class="text-surface-900 dark:text-white">SKENA</strong>.
                @else
                    Data agregat sebaran pasien, pola penggunaan narkotika, dan demografi terkait upaya rehabilitasi BNNP Sulawesi Tengah dalam sistem <strong class="text-surface-900 dark:text-white">SKENA</strong> (Sistem Informasi Kumpulan Edukasi Narkotika).
                @endif
            </p>
        </div>

        {{-- Filter & Kategori Bidang --}}
        <div class="mb-10 flex flex-wrap items-center justify-center gap-2">
            <a href="{{ route('statistik', ['kategori' => 'rehabilitasi']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border {{ $kategoriAktif === 'rehabilitasi' ? 'bg-primary-600 border-primary-500 text-white shadow-md shadow-primary-600/30' : 'bg-white dark:bg-surface-900/60 border-surface-200 dark:border-white/5 text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-white shadow-xs' }}">
                Rehabilitasi
            </a>
            <a href="{{ route('statistik', ['kategori' => 'p2m']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border {{ $kategoriAktif === 'p2m' ? 'bg-primary-600 border-primary-500 text-white shadow-md shadow-primary-600/30' : 'bg-white dark:bg-surface-900/60 border-surface-200 dark:border-white/5 text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-white shadow-xs' }}">
                P2M
            </a>
            <a href="{{ route('statistik', ['kategori' => 'pemberantasan']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border {{ $kategoriAktif === 'pemberantasan' ? 'bg-primary-600 border-primary-500 text-white shadow-md shadow-primary-600/30' : 'bg-white dark:bg-surface-900/60 border-surface-200 dark:border-white/5 text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-white shadow-xs' }}">
                Pemberantasan
            </a>
        </div>

        @if($kategoriAktif === 'rehabilitasi')
            {{-- Main Grid: Data Rehabilitasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Chart 1: Penggunaan Narkotika (Bar) --}}
                <div class="col-span-1 lg:col-span-2 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Penggunaan Jenis Narkotika
                    </h3>
                    <div id="chart-penggunaan" class="h-80"></div>
                </div>

                {{-- Chart 2: Usia Anak & Dewasa (Pie) --}}
                <div class="col-span-1 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4">Usia Anak dan Dewasa</h3>
                    <div id="chart-usia" class="flex justify-center h-80"></div>
                </div>

                {{-- Chart 3: Motif Penggunaan (Bar) --}}
                <div class="col-span-1 lg:col-span-2 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4">Motif Penggunaan Narkotika</h3>
                    <div id="chart-motif" class="h-80"></div>
                </div>

                {{-- Chart 4: Pendidikan (Pie) --}}
                <div class="col-span-1 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4">Pendidikan Pasien</h3>
                    <div id="chart-pendidikan" class="flex justify-center h-80"></div>
                </div>

                {{-- Row 3: 3 Pie Charts --}}
                <div class="col-span-1 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4">Jenis Kelamin</h3>
                    <div id="chart-gender" class="flex justify-center h-64"></div>
                </div>

                <div class="col-span-1 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4">Sumber Pasien</h3>
                    <div id="chart-sumber" class="flex justify-center h-64"></div>
                </div>

                <div class="col-span-1 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4">Sumber Pembiayaan</h3>
                    <div id="chart-biaya" class="flex justify-center h-64"></div>
                </div>

                {{-- Chart 5: Lama Penggunaan (Bar) --}}
                <div class="col-span-1 lg:col-span-3 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4">Lama Penggunaan Narkotika</h3>
                    <div id="chart-lama" class="h-72"></div>
                </div>

                {{-- Chart 6: Pekerjaan (Bar) --}}
                <div class="col-span-1 lg:col-span-3 bg-white dark:bg-surface-900/50 backdrop-blur-md rounded-2xl p-6 border border-surface-200 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-bold text-surface-900 dark:text-white mb-4">Pekerjaan Pasien</h3>
                    <div id="chart-pekerjaan" class="h-[500px]"></div>
                </div>

            </div>

        @elseif($kategoriAktif === 'p2m')
            {{-- Placeholder Elegan P2M --}}
            <div class="relative overflow-hidden rounded-3xl border border-surface-200 dark:border-white/10 bg-white/80 dark:bg-surface-900/50 backdrop-blur-xl p-8 sm:p-12 shadow-sm text-center">
                {{-- Background decorative glows --}}
                <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-primary-500/10 blur-[90px] rounded-full"></div>

                <div class="relative max-w-2xl mx-auto">
                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-2xl bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400 border border-primary-200 dark:border-primary-500/20 mb-6 shadow-inner">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>

                    <div class="inline-flex items-center gap-2 rounded-full border border-primary-200 dark:border-primary-500/30 bg-primary-50 dark:bg-primary-500/10 px-3.5 py-1 text-xs font-semibold text-primary-700 dark:text-primary-300 mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                        </span>
                        Tahap Integrasi Data
                    </div>

                    <h2 class="text-2xl font-bold text-surface-900 dark:text-white sm:text-3xl">
                        Data Statistik Bidang P2M Sedang Disiapkan
                    </h2>
                    <p class="mt-3 text-sm sm:text-base text-surface-600 dark:text-surface-400 leading-relaxed">
                        Data statistik kegiatan Pencegahan dan Pemberdayaan Masyarakat (P2M) saat ini sedang dalam proses sinkronisasi dan verifikasi oleh tim BNNP Sulawesi Tengah.
                    </p>

                    {{-- Preview Cakupan Indikator Data P2M --}}
                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
                        <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-surface-50/70 dark:bg-white/[0.02] p-5">
                            <div class="h-9 w-9 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-surface-900 dark:text-white">Sosialisasi P4GN</h3>
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Rekapitulasi sebaran edukasi bahaya narkoba ke sekolah, kampus, dan instansi se-Sulawesi Tengah.</p>
                        </div>

                        <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-surface-50/70 dark:bg-white/[0.02] p-5">
                            <div class="h-9 w-9 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-surface-900 dark:text-white">Deteksi Dini Tes Urine</h3>
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Hasil skrining tes urine berkala terhadap instansi kerja, pelajar, dan masyarakat umum.</p>
                        </div>

                        <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-surface-50/70 dark:bg-white/[0.02] p-5">
                            <div class="h-9 w-9 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-surface-900 dark:text-white">Desa Bersinar</h3>
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Ketahanan keluarga antinarkoba, relawan pegiat, dan pendampingan wilayah binaan bersinar.</p>
                        </div>
                    </div>

                    {{-- Back to Rehab button --}}
                    <div class="mt-8 flex items-center justify-center gap-3">
                        <a href="{{ route('statistik', ['kategori' => 'rehabilitasi']) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-600 text-sm font-semibold text-white shadow-md shadow-primary-600/30 hover:bg-primary-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            Lihat Statistik Rehabilitasi
                        </a>
                    </div>
                </div>
            </div>

        @elseif($kategoriAktif === 'pemberantasan')
            {{-- Placeholder Elegan Pemberantasan --}}
            <div class="relative overflow-hidden rounded-3xl border border-surface-200 dark:border-white/10 bg-white/80 dark:bg-surface-900/50 backdrop-blur-xl p-8 sm:p-12 shadow-sm text-center">
                {{-- Background decorative glows --}}
                <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-primary-500/10 blur-[90px] rounded-full"></div>

                <div class="relative max-w-2xl mx-auto">
                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-2xl bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400 border border-primary-200 dark:border-primary-500/20 mb-6 shadow-inner">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                        </svg>
                    </div>

                    <div class="inline-flex items-center gap-2 rounded-full border border-primary-200 dark:border-primary-500/30 bg-primary-50 dark:bg-primary-500/10 px-3.5 py-1 text-xs font-semibold text-primary-700 dark:text-primary-300 mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                        </span>
                        Tahap Validasi Data
                    </div>

                    <h2 class="text-2xl font-bold text-surface-900 dark:text-white sm:text-3xl">
                        Data Statistik Bidang Pemberantasan Sedang Disiapkan
                    </h2>
                    <p class="mt-3 text-sm sm:text-base text-surface-600 dark:text-surface-400 leading-relaxed">
                        Data penindakan hukum tindak pidana narkotika dan pemutusan jaringan peredaran gelap saat ini sedang dalam proses validasi resmi oleh tim BNNP Sulawesi Tengah.
                    </p>

                    {{-- Preview Cakupan Indikator Data Pemberantasan --}}
                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
                        <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-surface-50/70 dark:bg-white/[0.02] p-5">
                            <div class="h-9 w-9 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-surface-900 dark:text-white">Pengungkapan Kasus LKN</h3>
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Jumlah laporan kejadian tindak pidana narkotika dan penanganan berkas perkara terproses.</p>
                        </div>

                        <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-surface-50/70 dark:bg-white/[0.02] p-5">
                            <div class="h-9 w-9 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-surface-900 dark:text-white">Penyitaan Barang Bukti</h3>
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Total berat dan jenis sitaan barang bukti (sabu, ganja, ekstasi, obat berbahaya, dll).</p>
                        </div>

                        <div class="rounded-2xl border border-surface-200 dark:border-white/5 bg-surface-50/70 dark:bg-white/[0.02] p-5">
                            <div class="h-9 w-9 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-surface-900 dark:text-white">Profil Jaringan Tersangka</h3>
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Klasifikasi peran tersangka (kurir, pengedar, bandar) serta sebaran jaringan di wilayah Sulteng.</p>
                        </div>
                    </div>

                    {{-- Back to Rehab button --}}
                    <div class="mt-8 flex items-center justify-center gap-3">
                        <a href="{{ route('statistik', ['kategori' => 'rehabilitasi']) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-600 text-sm font-semibold text-white shadow-md shadow-primary-600/30 hover:bg-primary-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            Lihat Statistik Rehabilitasi
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@if($kategoriAktif === 'rehabilitasi')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#94a3b8' : '#475569';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : '#e2e8f0';
        
        const commonOptions = {
            chart: {
                foreColor: textColor,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light'
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4,
            }
        };

        const pieColors = ['#2563eb', '#059669', '#d97706', '#dc2626', '#7c3aed', '#db2777', '#0891b2'];
        const barColor = '#2563eb';

        // 1. Penggunaan Narkotika (Bar)
        new ApexCharts(document.querySelector("#chart-penggunaan"), {
            ...commonOptions,
            series: [{ name: 'Jumlah Pasien', data: [5, 0, 0, 0, 0, 0, 44, 0, 3, 0, 1, 7, 0, 0] }],
            chart: { type: 'bar', height: 320, ...commonOptions.chart },
            plotOptions: { bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'top' } } },
            colors: [barColor],
            xaxis: {
                categories: ['Alkohol', 'Heroin', 'Metadon / Subutex', 'Opiat lain', 'Barbiturat', 'Sedatif', 'Amfetamin Type Stimulants', 'MDMA', 'Kanabis', 'Halusinogen', 'Solvent/Inhalasia', 'NPS', 'Kokain', 'Lainnya'],
            }
        }).render();

        // 2. Usia (Pie)
        new ApexCharts(document.querySelector("#chart-usia"), {
            ...commonOptions,
            series: [29, 45],
            labels: ['Anak (dibawah 19 tahun)', 'Dewasa'],
            chart: { type: 'pie', height: 320, ...commonOptions.chart },
            colors: ['#2563eb', '#1e3a8a'],
            legend: { position: 'bottom' }
        }).render();

        // 3. Motif (Bar)
        new ApexCharts(document.querySelector("#chart-motif"), {
            ...commonOptions,
            series: [{ name: 'Jumlah', data: [40, 33, 22, 14, 11, 1, 5, 2, 5, 4, 5, 0] }],
            chart: { type: 'bar', height: 320, ...commonOptions.chart },
            plotOptions: { bar: { horizontal: true, borderRadius: 4 } },
            colors: ['#0284c7'],
            xaxis: {
                categories: ['Ajakan/bujukan teman', 'Ingin mencoba/penasaran', 'Tinggal di lingkungan pengguna', 'Konflik keluarga', 'Bersenang-senang', 'Stress belajar/kerja', 'Penambah stamina', 'Keluarga penyalahguna', 'Perceraian/patah hati', 'Diberikan cuma-cuma', 'Bermain game', 'Berduka']
            }
        }).render();

        // 4. Pendidikan (Pie)
        new ApexCharts(document.querySelector("#chart-pendidikan"), {
            ...commonOptions,
            series: [2, 6, 27, 31, 0, 0, 0, 7, 1, 0],
            labels: ['Tidak Sekolah', 'Tamat SD', 'Tamat SLTP', 'Tamat SLTA', 'Lulusan D1', 'Lulusan D2', 'Lulusan D3', 'Lulusan S1', 'Lulusan S2', 'Lulusan S3'],
            chart: { type: 'pie', height: 320, ...commonOptions.chart },
            colors: pieColors,
            legend: { position: 'bottom' }
        }).render();

        // 5. Gender (Pie)
        new ApexCharts(document.querySelector("#chart-gender"), {
            ...commonOptions,
            series: [72, 2],
            labels: ['Laki-laki', 'Perempuan'],
            chart: { type: 'pie', height: 260, ...commonOptions.chart },
            colors: ['#2563eb', '#ec4899'],
            legend: { position: 'bottom' }
        }).render();

        // 6. Sumber Pasien (Pie)
        new ApexCharts(document.querySelector("#chart-sumber"), {
            ...commonOptions,
            series: [73, 0, 0, 0, 0, 0, 1, 0, 0],
            labels: ['Sukarela', 'Proses Hukum', 'Vonis Hakim', 'Warga Binaan', 'Intervensi Masy.', 'Rujukan TAT', 'Rujukan', 'Penjangkauan', 'Razia'],
            chart: { type: 'pie', height: 260, ...commonOptions.chart },
            colors: pieColors,
            legend: { position: 'bottom' }
        }).render();

        // 7. Sumber Biaya (Pie)
        new ApexCharts(document.querySelector("#chart-biaya"), {
            ...commonOptions,
            series: [74, 0],
            labels: ['APBN', 'PNBP'],
            chart: { type: 'pie', height: 260, ...commonOptions.chart },
            colors: ['#059669', '#d97706'],
            legend: { position: 'bottom' }
        }).render();

        // 8. Lama Penggunaan (Bar)
        new ApexCharts(document.querySelector("#chart-lama"), {
            ...commonOptions,
            series: [{ name: 'Jumlah', data: [20, 15, 42, 16] }],
            chart: { type: 'bar', height: 280, ...commonOptions.chart },
            plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '50%' } },
            colors: ['#059669'],
            xaxis: { categories: ['0 - 6 bulan', '7 - 12 bulan', '12 - 60 bulan', 'Diatas 60 bulan'] }
        }).render();

        // 9. Pekerjaan (Bar)
        new ApexCharts(document.querySelector("#chart-pekerjaan"), {
            ...commonOptions,
            series: [{ name: 'Jumlah', data: [10, 1, 32, 0, 3, 1, 0, 0, 5, 0, 0, 0, 1, 0, 6, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1] }],
            chart: { type: 'bar', height: 500, ...commonOptions.chart },
            plotOptions: { bar: { horizontal: true, borderRadius: 2 } },
            colors: [barColor],
            xaxis: {
                categories: ['Belum/Tidak Bekerja', 'Mengurus Rumah Tangga', 'Pelajar/Mahasiswa', 'Pensiunan', 'PNS', 'TNI', 'Kepolisian RI', 'Perdagangan', 'Petani/Pekebun', 'Peternak', 'Nelayan/Perikanan', 'Industri', 'Konstruksi', 'Transportasi', 'Karyawan Swasta', 'Karyawan BUMN', 'Karyawan BUMD', 'Karyawan Honorer', 'Buruh Harian Lepas', 'Buruh Tani', 'Buruh Nelayan', 'Buruh Peternakan', 'PRT', 'Tukang Cukur', 'Tukang Listrik', 'Tukang Batu', 'Tukang Kayu', 'Tukang Sol', 'Tukang Las', 'Tukang Jahit', 'Penata Rambut', 'Penata Rias', 'Penata Busana', 'Mekanik', 'Wiraswasta', 'Anggota Lembaga', 'Artis', 'Atlit', 'Chef', 'Manajer', 'Tata Usaha', 'Operator', 'Pekerja Pengolahan', 'Teknisi', 'Asisten Ahli', 'Lainnya']
            },
            grid: {
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: false } }
            }
        }).render();
    });
</script>
@endif
@endsection
