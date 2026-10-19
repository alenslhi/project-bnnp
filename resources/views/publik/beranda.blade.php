@extends('layouts.publik')

@section('title', 'Beranda')

@section('content')

    {{-- ═══ HERO SECTION (BNN Blue Govt Identity) ═══ --}}
    <section class="relative overflow-hidden">
        {{-- Gradient background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-950 dark:from-surface-950 dark:via-surface-900 dark:to-surface-950"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(37,99,235,0.25)_0%,_transparent_60%)]"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/5 dark:bg-primary-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:py-24 lg:py-28 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 dark:border-primary-500/30 dark:bg-primary-500/10 px-4 py-1.5 mb-6 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-accent-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-accent-400"></span>
                    </span>
                    <span class="text-xs font-bold text-white uppercase tracking-wider">SKENA • Sistem Informasi Kumpulan Edukasi Narkotika</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.15] tracking-tight">
                    Bersama Lawan <br class="hidden sm:block">
                    <span class="bg-gradient-to-r from-blue-200 via-white to-accent-300 bg-clip-text text-transparent">
                        Peredaran Narkotika
                    </span>
                </h1>

                <p class="mt-6 text-base sm:text-lg text-primary-100 dark:text-surface-300 leading-relaxed max-w-2xl">
                    <strong class="text-white font-semibold">SKENA</strong> (Sistem Informasi Kumpulan Edukasi Narkotika) BNNP Sulawesi Tengah — mendukung program Pencegahan, Pemberantasan, Penyalahgunaan, dan Peredaran Gelap Narkotika (P4GN) serta rehabilitasi di wilayah Provinsi Sulawesi Tengah berbasis data geografis dan edukasi publik terpadu.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('peta') }}" class="inline-flex items-center gap-2.5 rounded-xl bg-white text-primary-900 font-bold px-6 py-3.5 text-sm shadow-xl hover:bg-primary-50 transition-all hover:-translate-y-0.5">
                        <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Lihat Peta Zona Kerawanan
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 dark:bg-white/5 px-6 py-3.5 text-sm font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20 hover:-translate-y-0.5">
                        <svg class="h-5 w-5 text-primary-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        Jelajahi Edukasi SKENA
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ STATISTIK ═══ --}}
    <section class="relative -mt-10 z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Kasus --}}
            <div class="group rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/80 backdrop-blur-xl p-5 shadow-sm transition-all hover:shadow-md hover:border-primary-500/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400 group-hover:bg-primary-100 dark:group-hover:bg-primary-500/20 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-surface-500 dark:text-surface-400 uppercase tracking-wider">Total Kasus</span>
                </div>
                <p class="text-3xl font-black text-surface-900 dark:text-white">{{ number_format($totalKasus) }}</p>
                <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Kasus di 13 Kab/Kota</p>
            </div>

            {{-- Zona Merah --}}
            <div class="group rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/80 backdrop-blur-xl p-5 shadow-sm transition-all hover:shadow-md hover:border-danger-500/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-danger-50 dark:bg-danger-500/10 text-danger-600 dark:text-danger-400 group-hover:bg-danger-100 dark:group-hover:bg-danger-500/20 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6"/></svg>
                    </div>
                    <span class="text-xs font-bold text-surface-500 dark:text-surface-400 uppercase tracking-wider">Zona Merah</span>
                </div>
                <p class="text-3xl font-black text-danger-600 dark:text-danger-400">{{ $zonaMerah }}</p>
                <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Wilayah Rawan Tinggi</p>
            </div>

            {{-- Zona Kuning --}}
            <div class="group rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/80 backdrop-blur-xl p-5 shadow-sm transition-all hover:shadow-md hover:border-warning-500/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10 text-warning-600 dark:text-warning-400 group-hover:bg-warning-100 dark:group-hover:bg-warning-500/20 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6"/></svg>
                    </div>
                    <span class="text-xs font-bold text-surface-500 dark:text-surface-400 uppercase tracking-wider">Zona Kuning</span>
                </div>
                <p class="text-3xl font-black text-amber-600 dark:text-warning-400">{{ $zonaKuning }}</p>
                <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Wilayah Rawan Sedang</p>
            </div>

            {{-- Zona Hijau --}}
            <div class="group rounded-2xl border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/80 backdrop-blur-xl p-5 shadow-sm transition-all hover:shadow-md hover:border-accent-500/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 dark:bg-accent-500/10 text-emerald-600 dark:text-accent-400 group-hover:bg-emerald-100 dark:group-hover:bg-accent-500/20 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6"/></svg>
                    </div>
                    <span class="text-xs font-bold text-surface-500 dark:text-surface-400 uppercase tracking-wider">Zona Hijau</span>
                </div>
                <p class="text-3xl font-black text-emerald-600 dark:text-accent-400">{{ $zonaHijau }}</p>
                <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Wilayah Aman / Rawan Rendah</p>
            </div>
        </div>
    </section>

    {{-- ═══ TENTANG SECTION ═══ --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-3">Tentang Sistem</span>
                <h2 class="text-3xl sm:text-4xl font-black text-surface-900 dark:text-white leading-tight">
                    Platform Informasi <span class="text-primary-600 dark:text-primary-400">Anti-Narkotika</span> Terpadu
                </h2>
                <p class="mt-4 text-surface-600 dark:text-surface-300 leading-relaxed">
                    Sistem ini dirancang untuk memberikan informasi terkini tentang persebaran zona kerawanan narkotika di Sulawesi Tengah,
                    serta menyediakan materi edukasi untuk meningkatkan kesadaran masyarakat akan bahaya penyalahgunaan narkotika.
                </p>
                <div class="mt-8 space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400 border border-primary-200 dark:border-primary-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-surface-900 dark:text-white">Peta Interaktif Resmi</h3>
                            <p class="text-sm text-surface-500 dark:text-surface-400">Visualisasi batas kecamatan dan kelurahan secara interaktif dengan kode warna kerawanan.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:bg-accent-500/10 text-emerald-600 dark:text-accent-400 border border-emerald-200 dark:border-accent-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-surface-900 dark:text-white">Katalog Edukasi SKENA</h3>
                            <p class="text-sm text-surface-500 dark:text-surface-400">Kumpulan materi artikel edukatif, kamus istilah bahaya narkoba, regulasi hukum, dan panduan rehabilitasi.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 dark:bg-warning-500/10 text-amber-600 dark:text-warning-400 border border-amber-200 dark:border-warning-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-surface-900 dark:text-white">Statistik & Monitoring Wilayah</h3>
                            <p class="text-sm text-surface-500 dark:text-surface-400">Data kasus berbasis dataset CSV yang terverifikasi dan dapat diakses transparan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-square rounded-3xl bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-600/20 dark:to-accent-600/20 border border-primary-200/50 dark:border-white/5 flex items-center justify-center shadow-lg">
                    <div class="text-center p-8">
                        <img src="{{ asset('images/logo-bnn.png') }}" alt="Logo BNNP Sulteng" class="mx-auto h-24 w-auto object-contain mb-6 drop-shadow-xl">
                        <h3 class="text-2xl font-black text-surface-900 dark:text-white mb-2">{{ $totalZona }} Wilayah</h3>
                        <p class="text-sm font-semibold text-primary-600 dark:text-surface-400">Dipantau secara aktif di Sulawesi Tengah</p>
                    </div>
                </div>
                {{-- Decorative elements --}}
                <div class="absolute -top-4 -right-4 h-24 w-24 rounded-2xl bg-primary-500/10 border border-primary-500/20 animate-pulse"></div>
                <div class="absolute -bottom-4 -left-4 h-16 w-16 rounded-xl bg-accent-500/10 border border-accent-500/20 animate-pulse" style="animation-delay: 1s"></div>
            </div>
        </div>
    </section>

    {{-- ═══ ARTIKEL TERBARU ═══ --}}
    @if($artikelTerbaru->count() > 0)
    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="inline-block text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-2">Terbaru</span>
                <h2 class="text-2xl sm:text-3xl font-black text-surface-900 dark:text-white">Materi Edukasi P4GN</h2>
            </div>
            <a href="{{ route('edukasi.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-bold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition">
                Lihat Semua Materi
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($artikelTerbaru as $artikel)
                <a href="{{ route('edukasi.show', $artikel) }}"
                   class="group flex flex-col rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/60 p-5 sm:p-6 transition-all duration-300 hover:border-primary-500/40 hover:shadow-xl hover:-translate-y-1 shadow-sm overflow-hidden">
                    @if($artikel->gambar)
                        <div class="mb-4 overflow-hidden rounded-xl aspect-[16/10] bg-surface-100 dark:bg-surface-800 -mx-1 -mt-1 sm:mx-0 sm:mt-0">
                            <img src="{{ $artikel->gambar_url }}" alt="{{ $artikel->judul }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @endif
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider
                            {{ $artikel->kategori === 'artikel' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/10 dark:text-primary-400' : ($artikel->kategori === 'kamus' ? 'bg-emerald-50 text-emerald-700 dark:bg-accent-500/10 dark:text-accent-400' : 'bg-amber-50 text-amber-700 dark:bg-warning-500/10 dark:text-warning-400') }}">
                            {{ $artikel->kategori }}
                        </span>
                        <span class="text-xs text-surface-400">{{ $artikel->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition line-clamp-2">{{ $artikel->judul }}</h3>
                    <p class="mt-2 text-sm text-surface-600 dark:text-surface-400 leading-relaxed line-clamp-3">{{ Str::limit(strip_tags($artikel->konten), 120) }}</p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-surface-500">
                        <div class="h-6 w-6 rounded-full bg-primary-600 flex items-center justify-center text-[10px] font-bold text-white shadow-xs">
                            {{ strtoupper(substr($artikel->penulis->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-surface-700 dark:text-surface-300">{{ $artikel->penulis->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

@endsection
