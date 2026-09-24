@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-surface-400 hover:text-white transition">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar User
    </a>
</div>

<div class="bg-surface-900 border border-white/5 rounded-2xl overflow-hidden shadow-sm max-w-2xl">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-surface-200 mb-1.5">Nama Lengkap <span class="text-danger-400">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                   class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
            @error('name') <p class="mt-1 text-sm text-danger-400">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-surface-200 mb-1.5">Email <span class="text-danger-400">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                   class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
            @error('email') <p class="mt-1 text-sm text-danger-400">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-surface-200 mb-1.5">Role (Peran) <span class="text-danger-400">*</span></label>
            <select name="role" id="role" required
                    class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none appearance-none">
                <option value="">-- Pilih Role --</option>
                @foreach($roles as $val => $label)
                    <option value="{{ $val }}" {{ old('role', $user->role) == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('role') <p class="mt-1 text-sm text-danger-400">{{ $message }}</p> @enderror
        </div>

        <hr class="border-white/5">
        <div>
            <p class="text-sm font-medium text-surface-200 mb-4">Ganti Password (Opsional)</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-surface-400 mb-1.5">Password Baru</label>
                    <input type="password" name="password" id="password" minlength="8" placeholder="Kosongkan jika tidak diubah"
                           class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-600 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
                    @error('password') <p class="mt-1 text-sm text-danger-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-surface-400 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" minlength="8"
                           class="w-full rounded-xl bg-surface-950 border border-white/10 px-4 py-2.5 text-white placeholder-surface-600 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none">
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-500 text-white font-medium rounded-xl transition-all shadow-lg shadow-primary-500/25">
                Update User
            </button>
        </div>
    </form>
</div>
@endsection
