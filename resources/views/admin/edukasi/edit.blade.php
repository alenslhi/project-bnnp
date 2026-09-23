@extends('layouts.admin')

@section('title', 'Edit Materi Edukasi')
@section('page-title', 'Edit Materi Edukasi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.edukasi.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-surface-400 hover:text-white transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Kembali ke Daftar Edukasi
        </a>
    </div>

    <div class="rounded-3xl border border-white/10 bg-surface-900/60 backdrop-blur-xl p-6 sm:p-8 shadow-xl">
        <form action="{{ route('admin.edukasi.update', $edukasi->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div>
                <label for="judul" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                    Judul Materi / Artikel <span class="text-danger-400">*</span>
                </label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $edukasi->judul) }}" required
                       class="w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('judul') border-danger-500 @enderror">
                @error('judul')
                    <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                    Kategori Konten <span class="text-danger-400">*</span>
                </label>
                <select name="kategori" id="kategori" required
                        class="w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-sm text-white focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('kategori') border-danger-500 @enderror">
                    <option value="artikel" {{ old('kategori', $edukasi->kategori) === 'artikel' ? 'selected' : '' }}>📖 Artikel Ilmiah & Edukasi</option>
                    <option value="kamus" {{ old('kategori', $edukasi->kategori) === 'kamus' ? 'selected' : '' }}>🔍 Kamus Istilah Narkoba</option>
                    <option value="media" {{ old('kategori', $edukasi->kategori) === 'media' ? 'selected' : '' }}>📢 Siaran Pers & Rilis Media</option>
                </select>
                @error('kategori')
                    <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konten --}}
            <div>
                <label for="konten" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                    Isi Konten / Materi Lengkap <span class="text-danger-400">*</span>
                </label>
                <textarea name="konten" id="konten" rows="10" required
                          class="w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition leading-relaxed @error('konten') border-danger-500 @enderror">{{ old('konten', $edukasi->konten) }}</textarea>
                @error('konten')
                    <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- File Path / URL Lampiran --}}
            <div>
                <label for="file_path" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                    Lampiran URL / Dokumen (Opsional)
                </label>
                <input type="text" name="file_path" id="file_path" value="{{ old('file_path', $edukasi->file_path) }}"
                       class="w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition">
                @error('file_path')
                    <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="pt-4 border-t border-white/5 flex items-center justify-end gap-3">
                <a href="{{ route('admin.edukasi.index') }}" class="px-5 py-2.5 rounded-xl border border-white/10 bg-white/5 text-xs font-semibold text-surface-300 hover:bg-white/10 hover:text-white transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 text-xs font-bold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-500 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
