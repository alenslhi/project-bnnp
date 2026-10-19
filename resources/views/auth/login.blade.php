@extends('layouts.publik')

@section('title', 'Login')

@section('content')
<div class="relative min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    {{-- Background decorative glows --}}
    <div class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2 w-96 h-96 bg-primary-500/10 dark:bg-primary-600/15 blur-[130px] rounded-full"></div>
    <div class="pointer-events-none absolute bottom-10 right-1/4 w-80 h-80 bg-accent-500/10 blur-[120px] rounded-full"></div>

    <div class="relative w-full max-w-md">
        {{-- Card --}}
        <div class="rounded-3xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/80 backdrop-blur-2xl p-8 sm:p-10 shadow-xl dark:shadow-2xl">
            {{-- Header --}}
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo-bnn.png') }}" alt="Logo BNNP Sulteng" class="mx-auto h-16 w-auto object-contain mb-4 drop-shadow-md">
                <h1 class="text-2xl font-black text-surface-900 dark:text-white tracking-tight">Login</h1>
                <div class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-0.5 rounded-md bg-primary-50 dark:bg-primary-500/10 border border-primary-200 dark:border-primary-500/20">
                    <span class="text-xs font-black text-primary-700 dark:text-primary-300 tracking-wider">SKENA</span>
                    <span class="text-[10px] text-primary-600 dark:text-primary-400 font-semibold">• BNNP Sulteng</span>
                </div>
                <p class="text-xs font-medium text-surface-500 dark:text-surface-400 mt-1">Sistem Informasi Kumpulan Edukasi Narkotika</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               class="w-full rounded-xl border border-surface-300 dark:border-white/10 bg-surface-50 dark:bg-surface-950/70 pl-11 pr-4 py-3 text-sm text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('email') border-danger-500 @enderror"
                               placeholder="admin@bnn.id">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-danger-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required
                               class="w-full rounded-xl border border-surface-300 dark:border-white/10 bg-surface-50 dark:bg-surface-950/70 pl-11 pr-4 py-3 text-sm text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('password') border-danger-500 @enderror"
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-danger-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-surface-300 dark:border-white/20 bg-surface-50 dark:bg-surface-950 text-primary-600 focus:ring-primary-500">
                        <span class="text-xs font-medium text-surface-600 dark:text-surface-300">Ingat saya</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full rounded-xl bg-primary-600 hover:bg-primary-700 py-3 px-4 text-sm font-bold text-white shadow-lg shadow-primary-600/30 focus:outline-none focus:ring-2 focus:ring-primary-500/50 transition">
                    Masuk ke Dasbor
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
