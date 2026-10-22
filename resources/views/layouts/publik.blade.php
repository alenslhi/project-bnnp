<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SKENA (Sistem Informasi Kumpulan Edukasi Narkotika) BNNP Sulawesi Tengah — Pemetaan zona kerawanan narkotika dan katalog edukasi P4GN.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Beranda') — SKENA (Sistem Informasi Kumpulan Edukasi Narkotika) BNNP Sulteng</title>

    {{-- Favicon BNN --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-bnn.png') }}?v=2">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Inline script to set theme BEFORE paint --}}
    <script>
        (function() {
            const stored = localStorage.getItem('bnnp-theme');
            if (stored === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-surface-50 dark:bg-surface-950 text-surface-800 dark:text-surface-100 font-sans antialiased min-h-screen flex flex-col transition-colors">

    {{-- ═══ TOP BANNER (BNN Blue Govt Identity) ═══ --}}
    <div class="bg-gradient-to-r from-primary-800 via-primary-700 to-primary-900 text-white text-[11px] py-1.5 px-4 hidden sm:block border-b border-primary-600/30">
        <div class="mx-auto max-w-7xl flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 font-medium tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Portal Resmi SKENA — Badan Narkotika Nasional Provinsi Sulawesi Tengah
                </span>
                <span class="text-white/30">|</span>
                <span class="text-primary-200">SKENA: Sistem Informasi Kumpulan Edukasi Narkotika (P4GN)</span>
            </div>
            <div class="flex items-center gap-4 text-primary-100">
                <span class="flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Call Center: 08114511344
                </span>
            </div>
        </div>
    </div>

    {{-- ═══ NAVBAR ═══ --}}
    <nav class="sticky top-0 z-50 border-b border-surface-200 dark:border-white/10 bg-white/90 dark:bg-surface-950/80 backdrop-blur-xl shadow-xs dark:shadow-none transition-colors">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                {{-- Logo --}}
                <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-bnn.png') }}" alt="Logo SKENA BNNP Sulteng" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
                    <div>
                        <span class="block text-lg font-black leading-tight text-primary-900 dark:text-white tracking-tight">SKENA</span>
                        <span class="block text-[10px] sm:text-[11px] font-semibold leading-tight text-primary-600 dark:text-primary-400 tracking-wide">Sistem Informasi Kumpulan Edukasi Narkotika</span>
                    </div>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('beranda') }}"
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('beranda') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400 border border-primary-200/70 dark:border-primary-500/20' : 'text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/5' }}">
                        Beranda
                    </a>
                    <a href="{{ route('peta') }}"
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('peta') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400 border border-primary-200/70 dark:border-primary-500/20' : 'text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/5' }}">
                        Peta Zona
                    </a>
                    <a href="{{ route('edukasi.index') }}"
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('edukasi.*') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400 border border-primary-200/70 dark:border-primary-500/20' : 'text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/5' }}">
                        Katalog Edukasi
                    </a>
                    <a href="{{ route('statistik') }}"
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('statistik') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400 border border-primary-200/70 dark:border-primary-500/20' : 'text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/5' }}">
                        Statistik
                    </a>
                    <a href="{{ route('faq-kontak') }}"
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('faq-kontak') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400 border border-primary-200/70 dark:border-primary-500/20' : 'text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/5' }}">
                        FAQ & Kontak
                    </a>
                    <a href="{{ route('game.index') }}"
                       class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('game.*') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400 border border-primary-200/70 dark:border-primary-500/20 shadow-xs' : 'text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/5' }}">
                        Mini Games
                    </a>
                </div>

                {{-- Right Side Actions (Theme Toggle & Login/Dasbor) --}}
                <div class="flex items-center gap-2.5">
                    {{-- Theme Toggle Button --}}
                    <button type="button" onclick="toggleTheme()"
                            class="p-2 rounded-xl border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-white/5 text-surface-600 dark:text-surface-300 hover:text-primary-600 dark:hover:text-white hover:bg-surface-200 dark:hover:bg-white/10 transition"
                            title="Beralih Tema (Gelap / Terang)">
                        {{-- Sun Icon (shown in dark mode) --}}
                        <svg id="theme-icon-sun" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        {{-- Moon Icon (shown in light mode) --}}
                        <svg id="theme-icon-moon" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                    </button>


                    {{-- Mobile Menu Toggle --}}
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-xl text-surface-600 dark:text-surface-400 hover:text-primary-600 dark:hover:text-white hover:bg-surface-100 dark:hover:bg-white/5 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-surface-200 dark:border-white/5 bg-white/95 dark:bg-surface-900/95 backdrop-blur-xl">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('beranda') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('beranda') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5' }}">Beranda</a>
                <a href="{{ route('peta') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('peta') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5' }}">Peta Zona</a>
                <a href="{{ route('edukasi.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('edukasi.*') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5' }}">Katalog Edukasi</a>
                <a href="{{ route('statistik') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('statistik') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5' }}">Statistik</a>
                <a href="{{ route('faq-kontak') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('faq-kontak') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5' }}">FAQ & Kontak</a>
                <a href="{{ route('game.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('game.*') ? 'bg-primary-50 dark:bg-primary-500/15 text-primary-600 dark:text-primary-400' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-white/5' }}">Mini Games</a>
            </div>
        </div>
    </nav>

    {{-- ═══ FLASH MESSAGES ═══ --}}
    @if(session('success'))
        <div class="mx-auto max-w-7xl px-4 pt-4">
            <div class="flex items-center gap-3 rounded-xl border border-accent-500/30 bg-accent-500/10 px-5 py-3 text-sm text-accent-700 dark:text-accent-400">
                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mx-auto max-w-7xl px-4 pt-4">
            <div class="flex items-center gap-3 rounded-xl border border-danger-500/30 bg-danger-500/10 px-5 py-3 text-sm text-danger-700 dark:text-danger-400">
                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ═══ FOOTER (Deep BNN Navy) ═══ --}}
    <footer class="border-t border-primary-900 bg-gradient-to-b from-primary-950 to-surface-950 text-surface-300 mt-auto">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo-bnn.png') }}" alt="Logo SKENA BNNP Sulteng" class="h-11 w-auto object-contain">
                        <div>
                            <h3 class="font-bold text-white text-base">SKENA</h3>
                            <p class="text-xs text-primary-300">Sistem Informasi Kumpulan Edukasi Narkotika</p>
                        </div>
                    </div>
                    <p class="text-sm text-surface-400 leading-relaxed">
                        <strong class="text-white font-semibold">SKENA</strong> (Sistem Informasi Kumpulan Edukasi Narkotika) adalah platform resmi BNNP Sulawesi Tengah untuk mendukung program Pencegahan, Pemberantasan, Penyalahgunaan, dan Peredaran Gelap Narkotika (P4GN) serta rehabilitasi berbasis data geografis dan literasi publik terpadu.
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm tracking-wider uppercase text-primary-200">Navigasi Utama</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('beranda') }}" class="text-sm text-surface-400 hover:text-white transition flex items-center gap-1.5"><span class="text-primary-400">&rsaquo;</span> Beranda Utama</a></li>
                        <li><a href="{{ route('peta') }}" class="text-sm text-surface-400 hover:text-white transition flex items-center gap-1.5"><span class="text-primary-400">&rsaquo;</span> Peta Pemetaan Zona Kerawanan</a></li>
                        <li><a href="{{ route('edukasi.index') }}" class="text-sm text-surface-400 hover:text-white transition flex items-center gap-1.5"><span class="text-primary-400">&rsaquo;</span> Materi & Modul Edukasi P4GN</a></li>
                        <li><a href="{{ route('statistik') }}" class="text-sm text-surface-400 hover:text-white transition flex items-center gap-1.5"><span class="text-primary-400">&rsaquo;</span> Statistik & Dataset Kasus</a></li>
                        <li><a href="{{ route('faq-kontak') }}" class="text-sm text-surface-400 hover:text-white transition flex items-center gap-1.5"><span class="text-primary-400">&rsaquo;</span> Layanan FAQ & Kontak Darurat</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="font-bold text-white mb-4 text-sm tracking-wider uppercase text-primary-200">Kontak & Alamat Kantor</h4>
                    <ul class="space-y-2.5 text-sm text-surface-400">
                        <li class="flex items-start gap-2.5">
                            <svg class="h-4 w-4 text-primary-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Jl. Soekarno Hatta, Kompleks Arena STQ Jabal Nur, Kota Palu, Sulawesi Tengah</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-primary-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>bnnpsulteng@gmail.com</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 text-primary-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span class="font-semibold text-white">08114511344 (Hotline BNNP)</span>
                        </li>
                    </ul>
                    <div class="mt-4 flex items-center gap-2.5">
                        <a href="https://www.instagram.com/bnnpsulteng" target="_blank" class="p-2 rounded-xl bg-white/10 text-white hover:bg-pink-600 transition" title="Instagram">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/bnnpsulteng" target="_blank" class="p-2 rounded-xl bg-white/10 text-white hover:bg-blue-600 transition" title="Facebook">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://twitter.com/bnnp_sulteng" target="_blank" class="p-2 rounded-xl bg-white/10 text-white hover:bg-sky-500 transition" title="Twitter">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="https://www.youtube.com/@bnnpsulawesitengah" target="_blank" class="p-2 rounded-xl bg-white/10 text-white hover:bg-red-600 transition" title="YouTube">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <p class="text-xs text-primary-300">&copy; {{ date('Y') }} Badan Narkotika Nasional Provinsi (BNNP) Sulawesi Tengah. Seluruh hak cipta dilindungi undang-undang.</p>
                {{-- Quick visitor button trigger in footer --}}
                <button type="button"
                        onclick="openVisitorModal()"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 px-3.5 py-1.5 text-xs text-surface-300 hover:text-white transition cursor-pointer group"
                        title="Klik untuk melihat statistik lengkap pengunjung website">
                    <span class="w-2 h-2 rounded-full bg-primary-400 group-hover:animate-ping"></span>
                    <span>Pengunjung: <strong class="text-white font-bold">{{ number_format($totalPengunjung ?? 0, 0, ',', '.') }}</strong></span>
                    <span class="text-primary-300 font-semibold">(↑ {{ $pengunjungHariIni ?? 0 }} hari ini)</span>
                </button>
            </div>
        </div>
    </footer>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Scripts: Theme Toggle & Mobile Menu --}}
    <script>
        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            if (sunIcon && moonIcon) {
                sunIcon.classList.toggle('hidden', !isDark);
                moonIcon.classList.toggle('hidden', isDark);
            }
        }

        function toggleTheme() {
            document.documentElement.classList.add('theme-transition');
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('bnnp-theme', isDark ? 'dark' : 'light');
            updateThemeIcons();
            setTimeout(() => document.documentElement.classList.remove('theme-transition'), 350);
        }

        // Initialize icons on load
        updateThemeIcons();

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>


    {{-- Modal Statistik Pengunjung --}}
    @include('components.visitor-modal')

    @stack('scripts')
</body>
</html>
