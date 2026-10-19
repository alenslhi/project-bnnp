@extends('layouts.admin')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-surface-500 hover:text-primary-600 dark:text-surface-400 dark:hover:text-white transition">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar User
    </a>
</div>

<div class="bg-white dark:bg-surface-900 border border-surface-200 dark:border-white/10 rounded-2xl overflow-hidden shadow-sm max-w-2xl">
    <div class="p-6 border-b border-surface-100 dark:border-white/5 bg-surface-50/50 dark:bg-surface-800/30">
        <h2 class="text-base font-bold text-surface-900 dark:text-white">Formulir Tambah Pengguna Baru</h2>
        <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Buat akun untuk personel atau administrator sistem.</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-200 mb-1.5">Nama Lengkap <span class="text-danger-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full rounded-xl bg-surface-50 dark:bg-surface-950 border border-surface-300 dark:border-white/10 px-4 py-2.5 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
            @error('name') <p class="mt-1 text-sm text-danger-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-200 mb-1.5">Email <span class="text-danger-500">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="w-full rounded-xl bg-surface-50 dark:bg-surface-950 border border-surface-300 dark:border-white/10 px-4 py-2.5 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
            @error('email') <p class="mt-1 text-sm text-danger-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-surface-700 dark:text-surface-200 mb-1.5">Role (Peran) <span class="text-danger-500">*</span></label>
            <select name="role" id="role" required
                    class="w-full rounded-xl bg-surface-50 dark:bg-surface-950 border border-surface-300 dark:border-white/10 px-4 py-2.5 text-surface-900 dark:text-white focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none appearance-none">
                <option value="">-- Pilih Role --</option>
                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }} {{ $adminExists ? 'disabled' : '' }}>
                    Admin {{ $adminExists ? '(Sudah Ada - Kuota 1 Akun Penuh)' : '(Maksimal 1 Akun)' }}
                </option>
            </select>
            @error('role') <p class="mt-1 text-sm text-danger-500">{{ $message }}</p> @enderror
            @if($adminExists)
                <p class="mt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center gap-1.5 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 p-2.5 rounded-lg">
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Sistem dibatasi hanya untuk 1 user akun Admin. Akun admin sudah terdaftar.
                </p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="password" class="block text-sm font-medium text-surface-700 dark:text-surface-200 mb-1.5">Password <span class="text-danger-500">*</span></label>
                <input type="password" name="password" id="password" required minlength="8"
                       class="w-full rounded-xl bg-surface-50 dark:bg-surface-950 border border-surface-300 dark:border-white/10 px-4 py-2.5 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
                @error('password') <p class="mt-1 text-sm text-danger-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-surface-700 dark:text-surface-200 mb-1.5">Konfirmasi Password <span class="text-danger-500">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                       class="w-full rounded-xl bg-surface-50 dark:bg-surface-950 border border-surface-300 dark:border-white/10 px-4 py-2.5 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
            </div>
        </div>

        <div class="pt-4 border-t border-surface-100 dark:border-white/5 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-all shadow-md shadow-primary-500/25">
                Simpan User
            </button>
        </div>
    </form>
</div>
@endsection
