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
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-surface-400">
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Jl. Contoh No.123, Palu, Sulawesi Tengah
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            info@bnnp-sulteng.go.id
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            (0451) 123-4567
                        </li>
                    </ul>
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
