<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Edukasi dan Informasi BNNP Sulawesi Tengah — Pemetaan zona kerawanan narkotika dan katalog edukasi.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BNNP Sulawesi Tengah') — Sistem Edukasi & Informasi</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Leaflet CSS (untuk peta) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-surface-950 text-surface-100 font-sans antialiased min-h-screen flex flex-col">

    {{-- ═══ NAVBAR ═══ --}}
    <nav class="sticky top-0 z-50 border-b border-white/10 bg-surface-950/80 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                {{-- Logo --}}
                <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-bnn.png') }}" alt="Logo BNNP Sulteng" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
                    <div class="hidden sm:block">
                        <span class="block text-sm font-bold leading-tight text-white">BNNP</span>
                        <span class="block text-[11px] font-medium leading-tight text-surface-400">Sulawesi Tengah</span>
                    </div>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('beranda') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('beranda') ? 'bg-primary-500/15 text-primary-400' : 'text-surface-300 hover:text-white hover:bg-white/5' }}">
                        Beranda
                    </a>
                    <a href="{{ route('peta') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('peta') ? 'bg-primary-500/15 text-primary-400' : 'text-surface-300 hover:text-white hover:bg-white/5' }}">
                        Peta Zona
                    </a>
                    <a href="{{ route('edukasi.index') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('edukasi.*') ? 'bg-primary-500/15 text-primary-400' : 'text-surface-300 hover:text-white hover:bg-white/5' }}">
                        Edukasi
                    </a>
                    <a href="{{ route('faq-kontak') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('faq-kontak') ? 'bg-primary-500/15 text-primary-400' : 'text-surface-300 hover:text-white hover:bg-white/5' }}">
                        FAQ & Kontak
                    </a>
                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                           class="hidden sm:inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition hover:bg-primary-500 hover:shadow-primary-500/30">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-surface-200 transition hover:bg-white/10 hover:text-white">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Login
                        </a>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-surface-400 hover:text-white hover:bg-white/5 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-white/5 bg-surface-900/95 backdrop-blur-xl">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('beranda') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('beranda') ? 'bg-primary-500/15 text-primary-400' : 'text-surface-300 hover:bg-white/5' }}">Beranda</a>
                <a href="{{ route('peta') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('peta') ? 'bg-primary-500/15 text-primary-400' : 'text-surface-300 hover:bg-white/5' }}">Peta Zona</a>
                <a href="{{ route('edukasi.index') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('edukasi.*') ? 'bg-primary-500/15 text-primary-400' : 'text-surface-300 hover:bg-white/5' }}">Edukasi</a>
                <a href="{{ route('faq-kontak') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('faq-kontak') ? 'bg-primary-500/15 text-primary-400' : 'text-surface-300 hover:bg-white/5' }}">FAQ & Kontak</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-primary-400 bg-primary-500/10">Dashboard Admin</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ═══ FLASH MESSAGES ═══ --}}
    @if(session('success'))
        <div class="mx-auto max-w-7xl px-4 pt-4">
            <div class="flex items-center gap-3 rounded-xl border border-accent-500/20 bg-accent-500/10 px-5 py-3 text-sm text-accent-400">
                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mx-auto max-w-7xl px-4 pt-4">
            <div class="flex items-center gap-3 rounded-xl border border-danger-500/20 bg-danger-500/10 px-5 py-3 text-sm text-danger-400">
                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="border-t border-white/5 bg-surface-950 mt-auto">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo-bnn.png') }}" alt="Logo BNNP Sulteng" class="h-11 w-auto object-contain">
                        <div>
                            <h3 class="font-bold text-white">BNNP Sulawesi Tengah</h3>
                            <p class="text-xs text-surface-400">Badan Narkotika Nasional Provinsi</p>
                        </div>
                    </div>
                    <p class="text-sm text-surface-400 leading-relaxed">
                        Sistem Edukasi dan Informasi untuk mendukung upaya pencegahan, pemberantasan, dan rehabilitasi penyalahgunaan narkotika di Sulawesi Tengah.
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('beranda') }}" class="text-sm text-surface-400 hover:text-primary-400 transition">Beranda</a></li>
                        <li><a href="{{ route('peta') }}" class="text-sm text-surface-400 hover:text-primary-400 transition">Peta Zona Kerawanan</a></li>
                        <li><a href="{{ route('edukasi.index') }}" class="text-sm text-surface-400 hover:text-primary-400 transition">Katalog Edukasi</a></li>
                        <li><a href="{{ route('faq-kontak') }}" class="text-sm text-surface-400 hover:text-primary-400 transition">FAQ & Kontak Darurat</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-surface-400">
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Jl. Soekarno Hatta, Kompleks Arena STQ Jabal Nur, Palu
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            bnnpsulteng@gmail.com
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            08114511344
                        </li>
                    </ul>
                    <div class="mt-4 flex items-center gap-3">
                        <a href="https://www.instagram.com/bnnpsulteng" target="_blank" class="p-2 rounded-lg bg-white/5 text-surface-400 hover:text-pink-400 hover:bg-pink-500/10 transition" title="Instagram">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/bnnpsulteng" target="_blank" class="p-2 rounded-lg bg-white/5 text-surface-400 hover:text-blue-400 hover:bg-blue-500/10 transition" title="Facebook">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://twitter.com/bnnp_sulteng" target="_blank" class="p-2 rounded-lg bg-white/5 text-surface-400 hover:text-sky-400 hover:bg-sky-500/10 transition" title="Twitter">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="https://www.youtube.com/@bnnpsulawesitengah" target="_blank" class="p-2 rounded-lg bg-white/5 text-surface-400 hover:text-red-400 hover:bg-red-500/10 transition" title="YouTube">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-white/5 pt-6 text-center">
                <p class="text-xs text-surface-500">&copy; {{ date('Y') }} BNNP Sulawesi Tengah. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Mobile Menu Toggle --}}
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
