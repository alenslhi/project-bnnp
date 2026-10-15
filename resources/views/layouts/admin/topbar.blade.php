<header class="sticky top-0 z-20 h-16 border-b border-white/5 bg-surface-950/80 backdrop-blur-xl flex items-center justify-between px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-surface-400 hover:text-white hover:bg-white/5 transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h1 class="text-lg font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
    </div>

    <div class="flex items-center gap-3 sm:gap-4 text-sm">
        <div class="hidden sm:flex items-center gap-2 text-surface-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span id="current-time"></span>
        </div>
        <a href="{{ route('admin.profile.index') }}"
           class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-white/5 bg-white/[0.03] hover:bg-white/10 text-surface-300 hover:text-white transition text-xs font-medium"
           title="Buka Profil & Ubah Sandi">
            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-br from-primary-400 to-accent-500 text-[10px] font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </span>
            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
            <span class="text-[10px] text-surface-400 bg-white/5 px-1.5 py-0.5 rounded-md hidden lg:inline">{{ auth()->user()->role_label }}</span>
        </a>
    </div>
</header>
