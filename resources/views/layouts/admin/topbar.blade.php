<header class="sticky top-0 z-20 h-16 border-b border-surface-200 dark:border-white/5 bg-white/80 dark:bg-surface-950/80 backdrop-blur-xl flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-sm dark:shadow-none">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-white hover:bg-primary-50 dark:hover:bg-white/5 transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h1 class="text-lg font-semibold text-surface-900 dark:text-white">@yield('page-title', 'Dashboard')</h1>
    </div>

    <div class="flex items-center gap-3 sm:gap-4 text-sm">
        <div class="hidden sm:flex items-center gap-2 text-surface-500 dark:text-surface-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span id="current-time"></span>
        </div>

        {{-- Theme Toggle Button --}}
        <button onclick="toggleTheme()" class="p-2 rounded-xl border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-white/5 hover:bg-surface-200 dark:hover:bg-white/10 text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition" title="Ganti tema gelap/terang">
            {{-- Sun icon (shown in dark mode) --}}
            <svg id="theme-icon-sun" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
            {{-- Moon icon (shown in light mode) --}}
            <svg id="theme-icon-moon" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
        </button>

        {{-- Profile --}}
        <a href="{{ route('admin.profile.index') }}"
           class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-surface-200 dark:border-white/5 bg-surface-100 dark:bg-white/[0.03] hover:bg-primary-50 dark:hover:bg-white/10 text-surface-600 dark:text-surface-300 hover:text-primary-700 dark:hover:text-white transition text-xs font-medium"
           title="Buka Profil & Ubah Sandi">
            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-primary-700 text-[10px] font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </span>
            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
            <span class="text-[10px] text-surface-500 dark:text-surface-400 bg-surface-200 dark:bg-white/5 px-1.5 py-0.5 rounded-md hidden lg:inline">{{ auth()->user()->role_label }}</span>
        </a>
    </div>
</header>

{{-- Initialize theme icon state --}}
<script>
    (function() {
        const isDark = document.documentElement.classList.contains('dark');
        const sun = document.getElementById('theme-icon-sun');
        const moon = document.getElementById('theme-icon-moon');
        if (sun && moon) {
            sun.classList.toggle('hidden', !isDark);
            moon.classList.toggle('hidden', isDark);
        }
    })();
</script>
