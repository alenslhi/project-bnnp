@extends('layouts.publik')

@section('title', 'Masuk Dasbor Petugas')

@section('content')
<div class="relative min-h-[calc(100vh-16rem)] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    {{-- Background decorative glows --}}
    <div class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2 w-96 h-96 bg-primary-600/15 blur-[130px] rounded-full"></div>
    <div class="pointer-events-none absolute bottom-10 right-1/4 w-80 h-80 bg-accent-500/10 blur-[120px] rounded-full"></div>

    <div class="relative w-full max-w-md">
        {{-- Card --}}
        <div class="rounded-3xl border border-white/10 bg-surface-900/80 backdrop-blur-2xl p-8 sm:p-10 shadow-2xl">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 shadow-xl shadow-primary-500/25 mb-4">
                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-white">Login Admin & Petugas</h1>
                <p class="text-xs text-surface-400 mt-1">Sistem Edukasi & Pemetaan BNNP Sulawesi Tengah</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               class="w-full rounded-xl border border-white/10 bg-surface-950/70 pl-11 pr-4 py-3 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('email') border-danger-500 @enderror"
                               placeholder="admin@bnnp.go.id">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required
                               class="w-full rounded-xl border border-white/10 bg-surface-950/70 pl-11 pr-4 py-3 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('password') border-danger-500 @enderror"
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-white/20 bg-surface-950 text-primary-600 focus:ring-primary-500 focus:ring-offset-surface-900">
                        <span class="text-xs text-surface-300">Ingat saya</span>
                    </label>
                    <span class="text-xs text-surface-500">Khusus Personel BNNP</span>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 py-3 px-4 text-sm font-bold text-white shadow-lg shadow-primary-600/30 hover:from-primary-500 hover:to-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/50 transition">
                    Masuk ke Dasbor
                </button>
            </form>

            {{-- Info Demo Akun RBAC --}}
            <div class="mt-8 pt-6 border-t border-white/10">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-surface-400 mb-3 text-center">Akun Percobaan (Seeder)</p>
                <div class="space-y-1.5 text-xs">
                    <button type="button" onclick="fillCreds('superadmin@bnnp.go.id', 'password')"
                            class="w-full flex items-center justify-between p-2 rounded-lg bg-white/5 hover:bg-white/10 text-left transition">
                        <span class="text-surface-300 font-medium">👑 Super Admin</span>
                        <span class="text-[11px] text-primary-400">klik isi otomatis</span>
                    </button>
                    <button type="button" onclick="fillCreds('brantas@bnnp.go.id', 'password')"
                            class="w-full flex items-center justify-between p-2 rounded-lg bg-white/5 hover:bg-white/10 text-left transition">
                        <span class="text-surface-300 font-medium">🎯 Admin Pemberantasan</span>
                        <span class="text-[11px] text-primary-400">klik isi otomatis</span>
                    </button>
                    <button type="button" onclick="fillCreds('rehab@bnnp.go.id', 'password')"
                            class="w-full flex items-center justify-between p-2 rounded-lg bg-white/5 hover:bg-white/10 text-left transition">
                        <span class="text-surface-300 font-medium">🏥 Admin Rehabilitasi</span>
                        <span class="text-[11px] text-primary-400">klik isi otomatis</span>
                    </button>
                    <button type="button" onclick="fillCreds('cegah@bnnp.go.id', 'password')"
                            class="w-full flex items-center justify-between p-2 rounded-lg bg-white/5 hover:bg-white/10 text-left transition">
                        <span class="text-surface-300 font-medium">🛡️ Admin Pencegahan</span>
                        <span class="text-[11px] text-primary-400">klik isi otomatis</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillCreds(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
</script>
@endsection
