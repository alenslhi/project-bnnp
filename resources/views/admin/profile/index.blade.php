@extends('layouts.admin')

@section('title', 'Profil & Keamanan Akun')
@section('page-title', 'Profil & Keamanan Akun')

@section('content')
<div class="space-y-8 max-w-4xl">

    {{-- Header Banner Ringkasan Akun --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-surface-900 via-surface-900 to-surface-850 border border-white/5 p-6 sm:p-8 shadow-sm">
        <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full bg-primary-500/10 blur-3xl pointer-events-none"></div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 relative z-10">
            <div class="flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-accent-500 text-2xl sm:text-3xl font-extrabold text-white shadow-lg shadow-primary-500/20">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-3">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                        @if($user->role === 'super_admin') bg-danger-500/10 text-danger-400 border border-danger-500/20
                        @elseif($user->role === 'admin_brantas') bg-amber-500/10 text-amber-400 border border-amber-500/20
                        @elseif($user->role === 'admin_rehab') bg-primary-500/10 text-primary-400 border border-primary-500/20
                        @else bg-accent-500/10 text-accent-400 border border-accent-500/20 @endif">
                        {{ $user->role_label }}
                    </span>
                </div>
                <p class="text-sm text-surface-400 mt-1 flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-surface-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    {{ $user->email }}
                </p>
                <p class="text-xs text-surface-500 mt-1">
                    Terdaftar sejak: {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Form Ubah Data Profil --}}
        <div class="bg-surface-900 border border-white/5 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 pb-4 border-b border-white/5 mb-6">
                    <div class="p-2 rounded-xl bg-primary-500/10 text-primary-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-white">Data Profil Pegawai</h3>
                        <p class="text-xs text-surface-400">Perbarui informasi identitas akun Anda</p>
                    </div>
                </div>

                <form id="profile-form" action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-surface-200 mb-1.5">Nama Lengkap <span class="text-danger-400">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
                        @error('name') <p class="mt-1.5 text-xs text-danger-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-surface-200 mb-1.5">Alamat Email <span class="text-danger-400">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
                        @error('email') <p class="mt-1.5 text-xs text-danger-400">{{ $message }}</p> @enderror
                        <p class="mt-1 text-[11px] text-surface-500">Email ini digunakan untuk masuk (login) ke panel administrasi.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-surface-200 mb-1.5">Peran / Hak Akses</label>
                        <input type="text" value="{{ $user->role_label }}" disabled
                               class="w-full rounded-xl bg-surface-950/50 border border-white/5 px-4 py-2.5 text-surface-400 cursor-not-allowed outline-none">
                        <p class="mt-1 text-[11px] text-surface-500">Peran akun hanya dapat diubah oleh Super Admin.</p>
                    </div>
                </form>
            </div>

            <div class="pt-6 border-t border-white/5 mt-6 flex justify-end">
                <button type="submit" form="profile-form" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-500 text-white text-sm font-medium rounded-xl transition-all shadow-lg shadow-primary-500/20">
                    Simpan Perubahan Profil
                </button>
            </div>
        </div>

        {{-- Form Ubah Kata Sandi --}}
        <div class="bg-surface-900 border border-white/5 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 pb-4 border-b border-white/5 mb-6">
                    <div class="p-2 rounded-xl bg-accent-500/10 text-accent-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-white">Ganti Kata Sandi</h3>
                        <p class="text-xs text-surface-400">Ubah kata sandi secara mandiri dan berkala demi keamanan</p>
                    </div>
                </div>

                <form id="password-form" action="{{ route('admin.profile.password') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-surface-200 mb-1.5">Kata Sandi Saat Ini <span class="text-danger-400">*</span></label>
                        <input type="password" name="current_password" id="current_password" required placeholder="Masukkan kata sandi lama Anda"
                               class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition outline-none">
                        @error('current_password') <p class="mt-1.5 text-xs text-danger-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-surface-200 mb-1.5">Kata Sandi Baru <span class="text-danger-400">*</span></label>
                        <input type="password" name="password" id="password" required minlength="8" placeholder="Minimal 8 karakter"
                               class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition outline-none">
                        @error('password') <p class="mt-1.5 text-xs text-danger-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-surface-200 mb-1.5">Konfirmasi Kata Sandi Baru <span class="text-danger-400">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" placeholder="Ulangi kata sandi baru"
                               class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-500 focus:border-accent-500 focus:ring-1 focus:ring-accent-500 transition outline-none">
                    </div>

                    <div class="rounded-xl bg-white/[0.02] border border-white/5 p-3.5 text-xs text-surface-400 space-y-1">
                        <p class="font-medium text-surface-300">Tips Keamanan Sandi:</p>
                        <ul class="list-disc list-inside space-y-0.5 text-surface-400">
                            <li>Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.</li>
                            <li>Jangan gunakan sandi default (misal: "password").</li>
                            <li>Jangan bagikan kata sandi akun Anda kepada pihak lain.</li>
                        </ul>
                    </div>
                </form>
            </div>

            <div class="pt-6 border-t border-white/5 mt-6 flex justify-end">
                <button type="submit" form="password-form" class="px-5 py-2.5 bg-accent-600 hover:bg-accent-500 text-white text-sm font-medium rounded-xl transition-all shadow-lg shadow-accent-500/20">
                    Perbarui Kata Sandi
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
