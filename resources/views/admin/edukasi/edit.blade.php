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
        <form action="{{ route('admin.edukasi.update', $edukasi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                    <option value="artikel" {{ old('kategori', $edukasi->kategori) === 'artikel' ? 'selected' : '' }}>Artikel Ilmiah & Edukasi</option>
                    <option value="kamus" {{ old('kategori', $edukasi->kategori) === 'kamus' ? 'selected' : '' }}>Kamus Istilah Narkoba</option>
                    <option value="media" {{ old('kategori', $edukasi->kategori) === 'media' ? 'selected' : '' }}>Siaran Pers & Rilis Media</option>
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

            {{-- Upload Lampiran Dokumen --}}
            <div>
                <label for="lampiran" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                    Upload Lampiran Dokumen (Opsional)
                </label>

                {{-- Tampilkan file yang sudah ada --}}
                @if($edukasi->file_path)
                    <div class="mb-3 flex items-center gap-3 rounded-xl border border-white/10 bg-surface-950/50 px-4 py-3">
                        <svg class="h-5 w-5 text-primary-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-surface-300 truncate">{{ basename($edukasi->file_path) }}</p>
                            <a href="{{ asset('storage/' . $edukasi->file_path) }}" target="_blank"
                               class="text-[11px] text-primary-400 hover:text-primary-300 transition">
                                Lihat / Unduh File
                            </a>
                        </div>
                        <label class="flex items-center gap-1.5 cursor-pointer shrink-0">
                            <input type="checkbox" name="hapus_lampiran" value="1"
                                   class="rounded border-white/20 bg-surface-950 text-danger-500 focus:ring-danger-500 focus:ring-offset-surface-900">
                            <span class="text-[11px] text-danger-400">Hapus</span>
                        </label>
                    </div>
                @endif

                <div class="relative">
                    <input type="file" name="lampiran" id="lampiran"
                           accept=".pdf,.jpg,.jpeg,.png,.webp"
                           class="block w-full text-sm text-surface-300
                                  file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0
                                  file:text-xs file:font-semibold file:bg-primary-600/20 file:text-primary-400
                                  hover:file:bg-primary-600/30 file:cursor-pointer file:transition
                                  rounded-xl border border-white/10 bg-surface-950/70 px-4 py-2.5
                                  focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition
                                  cursor-pointer @error('lampiran') border-danger-500 @enderror">
                </div>
                <p class="mt-1.5 text-[11px] text-surface-500">
                    Format yang diterima: PDF, JPG, PNG, WEBP. Ukuran maksimal: 10 MB.
                    @if($edukasi->file_path)
                        Upload file baru akan menggantikan lampiran yang sudah ada.
                    @endif
                </p>
                @error('lampiran')
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

