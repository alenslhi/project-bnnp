@extends('layouts.publik')

@section('title', $edukasi->judul)

@section('content')
<div class="relative min-h-screen py-12">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        {{-- Back Navigation --}}
        <div class="mb-8">
            <a href="{{ route('edukasi.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-surface-500 hover:text-primary-600 dark:text-surface-400 dark:hover:text-white transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Kembali ke Katalog Edukasi
            </a>
        </div>

        {{-- Main Article Card --}}
        <article class="rounded-3xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/60 backdrop-blur-xl p-6 sm:p-10 shadow-sm">
            {{-- Category & Date Header --}}
            <div class="flex flex-wrap items-center gap-3 mb-6">
                @if($edukasi->kategori === 'artikel')
                    <span class="inline-flex items-center gap-1 rounded-lg border border-primary-200 dark:border-primary-500/30 bg-primary-50 dark:bg-primary-500/10 px-3 py-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                        Artikel Ilmiah & Edukasi
                    </span>
                @elseif($edukasi->kategori === 'kamus')
                    <span class="inline-flex items-center gap-1 rounded-lg border border-amber-200 dark:border-warning-500/30 bg-amber-50 dark:bg-warning-500/10 px-3 py-1 text-xs font-bold text-amber-700 dark:text-warning-400">
                        Kamus Istilah Narkoba
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 rounded-lg border border-emerald-200 dark:border-accent-500/30 bg-emerald-50 dark:bg-accent-500/10 px-3 py-1 text-xs font-bold text-emerald-700 dark:text-accent-400">
                        Siaran Media Resmi
                    </span>
                @endif

                <span class="text-xs text-surface-500 dark:text-surface-400">
                    Dipublikasikan pada {{ $edukasi->created_at->translatedFormat('l, d F Y - H:i') }} WITA
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl sm:text-4xl font-black text-surface-900 dark:text-white tracking-tight leading-tight mb-6">
                {{ $edukasi->judul }}
            </h1>

            {{-- Author Profile Bar --}}
            <div class="flex items-center justify-between border-y border-surface-200 dark:border-white/10 py-4 mb-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-600 text-white font-bold text-sm shadow-md">
                        {{ strtoupper(substr($edukasi->penulis->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-surface-900 dark:text-white">{{ $edukasi->penulis->name ?? 'BNNP Sulawesi Tengah' }}</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">
                            @if(isset($edukasi->penulis->role))
                                @switch($edukasi->penulis->role)
                                    @case('super_admin') Super Admin BNNP @break
                                    @case('admin') Admin BNNP @break
                                    @default Kontributor BNNP
                                @endswitch
                            @else
                                Kontributor Resmi
                            @endif
                        </p>
                    </div>
                </div>

                @if($edukasi->file_path)
                    <a href="{{ asset('storage/' . $edukasi->file_path) }}" target="_blank"
                       class="inline-flex items-center gap-2 rounded-xl border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-white/5 px-3.5 py-2 text-xs font-semibold text-surface-700 dark:text-surface-200 hover:bg-surface-200 dark:hover:bg-white/10 hover:text-surface-900 dark:hover:text-white transition">
                        <svg class="h-4 w-4 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        Lampiran File
                    </a>
                @endif
            </div>

            {{-- Featured Image Banner jika ada (Full dan tidak terpotong) --}}
            @if($edukasi->gambar)
                <div class="mb-8 overflow-hidden rounded-2xl border border-surface-200 dark:border-white/10 bg-surface-50 dark:bg-surface-950/40 p-2 sm:p-3 shadow-sm flex items-center justify-center">
                    <img src="{{ $edukasi->gambar_url }}" alt="{{ $edukasi->judul }}"
                         class="w-full h-auto rounded-xl object-contain max-w-full">
                </div>
            @endif

            {{-- Main Content Body --}}
            <div class="text-surface-800 dark:text-surface-200 text-base leading-relaxed space-y-4 font-normal">
                {!! nl2br(e($edukasi->konten)) !!}
            </div>

            {{-- Callout Alert BNNP --}}
            <div class="mt-10 rounded-2xl border border-primary-200 dark:border-primary-500/20 bg-primary-50 dark:bg-primary-500/5 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-surface-900 dark:text-white text-sm">Butuh Konsultasi atau Bantuan Rehabilitasi?</h3>
                    <p class="text-xs text-surface-600 dark:text-surface-400 mt-1">Layanan rehabilitasi BNNP Sulteng terbuka secara sukarela dan dilindungi kerahasiaannya.</p>
                </div>
                <a href="{{ route('faq-kontak') }}" class="shrink-0 inline-flex items-center gap-2 rounded-xl bg-primary-600 hover:bg-primary-700 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-primary-600/25 transition">
                    Hubungi Call Center BNN
                </a>
            </div>
        </article>

        {{-- Related Articles --}}
        @if(isset($terkait) && $terkait->count() > 0)
            <div class="mt-12">
                <h3 class="text-xl font-bold text-surface-900 dark:text-white mb-6">Materi Terkait Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach($terkait as $item)
                        <a href="{{ route('edukasi.show', $item->id) }}"
                           class="group block rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/40 p-5 transition hover:border-primary-500/40 hover:shadow-md shadow-xs">
                            <span class="text-[11px] font-bold text-primary-600 dark:text-primary-400 uppercase tracking-wider block mb-2">{{ $item->kategori }}</span>
                            <h4 class="font-bold text-surface-900 dark:text-white text-sm line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
                                {{ $item->judul }}
                            </h4>
                            <p class="text-xs text-surface-600 dark:text-surface-400 line-clamp-2">
                                {{ Str::limit(strip_tags($item->konten), 90) }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
