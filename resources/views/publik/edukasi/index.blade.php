@extends('layouts.publik')

@section('title', 'Katalog Edukasi P4GN')

@section('content')
<div class="relative min-h-screen py-12">
    {{-- Glow effect --}}
    <div class="pointer-events-none absolute top-10 left-1/2 -translate-x-1/2 w-3/4 max-w-4xl h-64 bg-primary-500/10 blur-[120px] rounded-full"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="inline-flex items-center gap-1.5 rounded-full border border-primary-500/30 bg-primary-500/10 px-3.5 py-1 text-xs font-semibold text-primary-400 mb-4">
                Pusat Literasi & Informasi
            </span>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                Katalog Edukasi & Informasi P4GN
            </h1>
            <p class="mt-3 text-base text-surface-400">
                Temukan artikel ilmiah, kamus istilah bahaya narkoba, materi rehabilitasi, dan rilis media resmi dari BNNP Sulawesi Tengah.
            </p>
        </div>

        {{-- Filter & Kategori --}}
        <div class="mb-10 flex flex-wrap items-center justify-center gap-2">
            <a href="{{ route('edukasi.index') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border {{ !$kategoriAktif ? 'bg-primary-600 border-primary-500 text-white shadow-lg shadow-primary-600/30' : 'bg-surface-900/60 border-white/5 text-surface-300 hover:bg-surface-800 hover:text-white' }}">
                Semua Kategori
            </a>
            <a href="{{ route('edukasi.index', ['kategori' => 'artikel']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border {{ $kategoriAktif === 'artikel' ? 'bg-primary-600 border-primary-500 text-white shadow-lg shadow-primary-600/30' : 'bg-surface-900/60 border-white/5 text-surface-300 hover:bg-surface-800 hover:text-white' }}">
                📖 Artikel Edukatif
            </a>
            <a href="{{ route('edukasi.index', ['kategori' => 'kamus']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border {{ $kategoriAktif === 'kamus' ? 'bg-primary-600 border-primary-500 text-white shadow-lg shadow-primary-600/30' : 'bg-surface-900/60 border-white/5 text-surface-300 hover:bg-surface-800 hover:text-white' }}">
                🔍 Kamus Narkoba
            </a>
            <a href="{{ route('edukasi.index', ['kategori' => 'media']) }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border {{ $kategoriAktif === 'media' ? 'bg-primary-600 border-primary-500 text-white shadow-lg shadow-primary-600/30' : 'bg-surface-900/60 border-white/5 text-surface-300 hover:bg-surface-800 hover:text-white' }}">
                📢 Rilis Media
            </a>
        </div>

        {{-- Grid Materi Edukasi --}}
        @if($edukasis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($edukasis as $item)
                    <article class="group flex flex-col rounded-2xl border border-white/10 bg-surface-900/50 backdrop-blur-sm p-6 transition-all duration-300 hover:-translate-y-1 hover:border-primary-500/40 hover:bg-surface-900/80 hover:shadow-xl hover:shadow-primary-500/10">
                        {{-- Header / Badges --}}
                        <div class="flex items-center justify-between gap-2 mb-4">
                            @if($item->kategori === 'artikel')
                                <span class="inline-flex items-center gap-1 rounded-lg border border-primary-500/30 bg-primary-500/10 px-2.5 py-1 text-xs font-semibold text-primary-400">
                                    Artikel
                                </span>
                            @elseif($item->kategori === 'kamus')
                                <span class="inline-flex items-center gap-1 rounded-lg border border-warning-500/30 bg-warning-500/10 px-2.5 py-1 text-xs font-semibold text-warning-400">
                                    Kamus Narkoba
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-lg border border-accent-500/30 bg-accent-500/10 px-2.5 py-1 text-xs font-semibold text-accent-400">
                                    Rilis Media
                                </span>
                            @endif

                            <span class="text-xs text-surface-400">
                                {{ $item->created_at->translatedFormat('d M Y') }}
                            </span>
                        </div>

                        {{-- Judul --}}
                        <h2 class="text-lg font-bold text-white leading-snug mb-3 group-hover:text-primary-400 transition-colors">
                            <a href="{{ route('edukasi.show', $item->id) }}" class="line-clamp-2">
                                {{ $item->judul }}
                            </a>
                        </h2>

                        {{-- Cuplikan Konten --}}
                        <p class="text-sm text-surface-400 line-clamp-3 leading-relaxed mb-5 flex-1">
                            {{ Str::limit(strip_tags($item->konten), 140) }}
                        </p>

                        {{-- Footer Card --}}
                        <div class="pt-4 border-t border-white/5 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-primary-500/20 text-primary-400 font-semibold text-[11px]">
                                    {{ strtoupper(substr($item->penulis->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="text-surface-300 font-medium truncate max-w-[120px]">
                                    {{ $item->penulis->name ?? 'BNNP Admin' }}
                                </span>
                            </div>

                            <a href="{{ route('edukasi.show', $item->id) }}"
                               class="inline-flex items-center gap-1 font-semibold text-primary-400 group-hover:text-primary-300 group-hover:translate-x-0.5 transition-all">
                                Baca
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center">
                {{ $edukasis->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-white/10 bg-surface-900/30 p-12 text-center max-w-lg mx-auto">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white/5 text-surface-400 mb-4">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-1">Materi Edukasi Belum Tersedia</h3>
                <p class="text-sm text-surface-400 mb-6">Belum ada konten untuk kategori yang dipilih.</p>
                <a href="{{ route('edukasi.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition hover:bg-primary-500">
                    Lihat Semua Kategori
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
