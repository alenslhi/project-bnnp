@extends('layouts.publik')

@section('title', 'Beranda')

@section('content')

    {{-- ═══ HERO SECTION ═══ --}}
    <section class="relative overflow-hidden">
        {{-- Gradient background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-primary-950 via-surface-950 to-surface-900"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--color-primary-800)_0%,_transparent_50%)] opacity-30"></div>
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary-500/5 rounded-full blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:py-28 lg:py-36 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-primary-500/20 bg-primary-500/10 px-4 py-1.5 mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-accent-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-accent-500"></span>
                    </span>
                    <span class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Sistem Informasi Aktif</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.1] tracking-tight">
                    Bersama Lawan
                    <span class="bg-gradient-to-r from-primary-400 via-primary-300 to-accent-400 bg-clip-text text-transparent">
                        Narkotika
                    </span>
                </h1>

                <p class="mt-6 text-lg sm:text-xl text-surface-300 leading-relaxed max-w-2xl">
                    Sistem Edukasi dan Informasi BNNP Sulawesi Tengah — mendukung upaya pencegahan, pemberantasan, dan rehabilitasi penyalahgunaan narkotika melalui data dan edukasi.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('peta') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-6 py-3.5 text-sm font-semibold text-white shadow-xl shadow-primary-600/25 transition-all hover:bg-primary-500 hover:shadow-primary-500/30 hover:-translate-y-0.5">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Lihat Peta Zona
                    </a>
                    <a href="{{ route('edukasi.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-6 py-3.5 text-sm font-semibold text-surface-200 transition-all hover:bg-white/10 hover:text-white hover:-translate-y-0.5">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        Jelajahi Edukasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ STATISTIK ═══ --}}
    <section class="relative -mt-10 z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Kasus --}}
            <div class="group rounded-2xl border border-white/5 bg-surface-900/80 backdrop-blur-xl p-5 transition-all hover:border-primary-500/20 hover:bg-surface-900">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-500/10 text-primary-400 group-hover:bg-primary-500/20 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <span class="text-xs font-medium text-surface-400 uppercase tracking-wider">Total Kasus</span>
                </div>
                <p class="text-3xl font-extrabold text-white">{{ number_format($totalKasus) }}</p>
            </div>

            {{-- Zona Merah --}}
            <div class="group rounded-2xl border border-white/5 bg-surface-900/80 backdrop-blur-xl p-5 transition-all hover:border-danger-500/20 hover:bg-surface-900">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-danger-500/10 text-danger-400 group-hover:bg-danger-500/20 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6"/></svg>
                    </div>
                    <span class="text-xs font-medium text-surface-400 uppercase tracking-wider">Zona Merah</span>
                </div>
                <p class="text-3xl font-extrabold text-danger-400">{{ $zonaMerah }}</p>
            </div>

            {{-- Zona Kuning --}}
            <div class="group rounded-2xl border border-white/5 bg-surface-900/80 backdrop-blur-xl p-5 transition-all hover:border-warning-500/20 hover:bg-surface-900">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-warning-500/10 text-warning-400 group-hover:bg-warning-500/20 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6"/></svg>
                    </div>
                    <span class="text-xs font-medium text-surface-400 uppercase tracking-wider">Zona Kuning</span>
                </div>
                <p class="text-3xl font-extrabold text-warning-400">{{ $zonaKuning }}</p>
            </div>

            {{-- Zona Hijau --}}
            <div class="group rounded-2xl border border-white/5 bg-surface-900/80 backdrop-blur-xl p-5 transition-all hover:border-accent-500/20 hover:bg-surface-900">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-accent-500/10 text-accent-400 group-hover:bg-accent-500/20 transition">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="6"/></svg>
                    </div>
                    <span class="text-xs font-medium text-surface-400 uppercase tracking-wider">Zona Hijau</span>
                </div>
                <p class="text-3xl font-extrabold text-accent-400">{{ $zonaHijau }}</p>
            </div>
        </div>
    </section>

    {{-- ═══ TENTANG SECTION ═══ --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block text-xs font-semibold text-primary-400 uppercase tracking-widest mb-3">Tentang Sistem</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white leading-tight">
                    Platform Informasi <span class="text-primary-400">Anti-Narkotika</span> Terpadu
                </h2>
                <p class="mt-4 text-surface-300 leading-relaxed">
                    Sistem ini dirancang untuk memberikan informasi terkini tentang persebaran zona kerawanan narkotika di Sulawesi Tengah,
                    serta menyediakan materi edukasi untuk meningkatkan kesadaran masyarakat akan bahaya penyalahgunaan narkotika.
                </p>
                <div class="mt-8 space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-500/10 text-primary-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Peta Interaktif</h3>
                            <p class="text-sm text-surface-400">Visualisasi zona kerawanan narkotika secara real-time dengan data GeoJSON.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent-500/10 text-accent-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Katalog Edukasi</h3>
                            <p class="text-sm text-surface-400">Kumpulan artikel, kamus istilah, dan media edukasi anti-narkotika.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-warning-500/10 text-warning-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-white">Monitoring Wilayah</h3>
                            <p class="text-sm text-surface-400">Pemantauan dan klasifikasi tingkat kerawanan tiap wilayah di Sulawesi Tengah.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-square rounded-3xl bg-gradient-to-br from-primary-600/20 to-accent-600/20 border border-white/5 flex items-center justify-center">
                    <div class="text-center p-8">
                        <img src="{{ asset('images/logo-bnn.png') }}" alt="Logo BNNP Sulteng" class="mx-auto h-24 w-auto object-contain mb-6 drop-shadow-2xl">
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $totalZona }} Wilayah</h3>
                        <p class="text-surface-400">dipantau secara aktif</p>
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
                <span class="inline-block text-xs font-semibold text-primary-400 uppercase tracking-widest mb-2">Terbaru</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Materi Edukasi</h2>
            </div>
            <a href="{{ route('edukasi.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-medium text-primary-400 hover:text-primary-300 transition">
                Lihat Semua
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($artikelTerbaru as $artikel)
                <a href="{{ route('edukasi.show', $artikel) }}"
                   class="group rounded-2xl border border-white/5 bg-surface-900/60 p-6 transition-all duration-300 hover:border-primary-500/20 hover:bg-surface-900 hover:-translate-y-1 hover:shadow-xl hover:shadow-primary-500/5">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wider
                            {{ $artikel->kategori === 'artikel' ? 'bg-primary-500/10 text-primary-400' : ($artikel->kategori === 'kamus' ? 'bg-accent-500/10 text-accent-400' : 'bg-warning-500/10 text-warning-400') }}">
                            {{ $artikel->kategori }}
                        </span>
                        <span class="text-xs text-surface-500">{{ $artikel->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-white group-hover:text-primary-400 transition line-clamp-2">{{ $artikel->judul }}</h3>
                    <p class="mt-2 text-sm text-surface-400 leading-relaxed line-clamp-3">{{ Str::limit(strip_tags($artikel->konten), 120) }}</p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-surface-500">
                        <div class="h-5 w-5 rounded-full bg-gradient-to-br from-primary-400 to-accent-500 flex items-center justify-center text-[10px] font-bold text-white">
                            {{ strtoupper(substr($artikel->penulis->name, 0, 1)) }}
                        </div>
                        {{ $artikel->penulis->name }}
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

@endsection
