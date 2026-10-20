{{-- ═══ BNN BRANDED SIDEBAR ═══ --}}
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out
    bg-gradient-to-b from-primary-800 to-primary-950 dark:from-surface-900 dark:to-surface-950
    border-r border-primary-700/50 dark:border-white/5 flex flex-col shadow-xl">

    {{-- Sidebar Header --}}
    <div class="flex items-center gap-3 px-5 h-16 border-b border-white/15 dark:border-white/5 shrink-0">
        <img src="{{ asset('images/logo-bnn.png') }}" alt="Logo SKENA BNNP Sulteng" class="h-9 w-auto object-contain drop-shadow-lg">
        <div>
            <div class="flex items-center gap-1.5">
                <span class="block text-sm font-black text-white leading-tight tracking-tight">SKENA</span>
                <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded bg-white/20 text-white">ADMIN</span>
            </div>
            <span class="block text-[10px] text-primary-200 dark:text-surface-400 font-medium truncate max-w-[145px]">Sistem Edukasi Narkotika</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <p class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-widest text-primary-300/70 dark:text-surface-500">Menu Utama</p>

        {{-- Dashboard Informasi --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-sm' : 'text-primary-100 dark:text-surface-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            Dashboard Informasi
        </a>

        {{-- Riwayat Pengunjung --}}
        <a href="{{ route('admin.pengunjung.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.pengunjung.*') ? 'bg-white/20 text-white shadow-sm' : 'text-primary-100 dark:text-surface-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            Riwayat Pengunjung
        </a>

        <p class="px-3 mt-5 mb-2 text-[10px] font-semibold uppercase tracking-widest text-primary-300/70 dark:text-surface-500">Manajemen Konten</p>

        {{-- Kelola Peta Zona --}}
        <a href="{{ route('admin.zona.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.zona.*') ? 'bg-white/20 text-white shadow-sm' : 'text-primary-100 dark:text-surface-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
            Kelola Peta Zona
        </a>

        {{-- Kelola Edukasi --}}
        <a href="{{ route('admin.edukasi.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.edukasi.*') ? 'bg-white/20 text-white shadow-sm' : 'text-primary-100 dark:text-surface-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            Kelola Edukasi
        </a>

        {{-- Kelola Statistik Klien & Rehabilitasi --}}
        <a href="{{ route('admin.statistik.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.statistik.*') ? 'bg-white/20 text-white shadow-sm' : 'text-primary-100 dark:text-surface-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            Statistik Rehabilitasi
        </a>

        <p class="px-3 mt-5 mb-2 text-[10px] font-semibold uppercase tracking-widest text-primary-300/70 dark:text-surface-500">Akun & Pengaturan</p>

        {{-- Profil & Keamanan (Semua Role) --}}
        <a href="{{ route('admin.profile.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.profile.*') ? 'bg-white/20 text-white shadow-sm' : 'text-primary-100 dark:text-surface-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            Profil & Sandi
        </a>

        {{-- Settings (Super Admin only for users/logs) --}}
        @if(auth()->user()->isSuperAdmin())
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white shadow-sm' : 'text-primary-100 dark:text-surface-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            Kelola Pengguna
        </a>
        <a href="{{ route('admin.logs.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                  {{ request()->routeIs('admin.logs.*') ? 'bg-white/20 text-white shadow-sm' : 'text-primary-100 dark:text-surface-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
            Log Aktivitas
        </a>
        @endif
        

    </nav>

    {{-- User Info --}}
    <div class="shrink-0 border-t border-white/15 dark:border-white/5 p-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.profile.index') }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/20 dark:bg-gradient-to-br dark:from-primary-400 dark:to-accent-500 text-sm font-bold text-white hover:opacity-85 transition" title="Profil & Ubah Sandi">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </a>
            <a href="{{ route('admin.profile.index') }}" class="flex-1 min-w-0 group" title="Buka Profil & Ubah Sandi">
                <p class="text-sm font-semibold text-white group-hover:text-primary-200 dark:group-hover:text-primary-400 transition truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-[11px] text-primary-200 dark:text-surface-400 truncate">{{ auth()->user()->role_label ?? 'Administrator' }}</p>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 rounded-lg text-primary-200 dark:text-surface-400 hover:text-white hover:bg-white/10 dark:hover:text-danger-400 dark:hover:bg-danger-500/10 transition" title="Logout">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Mobile Overlay --}}
<div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm hidden lg:hidden" onclick="toggleSidebar()"></div>
