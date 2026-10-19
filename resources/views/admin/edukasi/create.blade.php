@extends('layouts.admin')

@section('title', 'Tulis Materi Edukasi Baru')
@section('page-title', 'Tulis Materi Edukasi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.edukasi.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-white transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Kembali ke Daftar Edukasi
        </a>
    </div>

    <div class="rounded-3xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/60 backdrop-blur-xl p-6 sm:p-8 shadow-sm dark:shadow-xl">
        <form action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Judul --}}
            <div>
                <label for="judul" class="block text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-300 mb-2">
                    Judul Materi / Artikel <span class="text-danger-500 dark:text-danger-400">*</span>
                </label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                       placeholder="Contoh: Bahaya Penyalahgunaan Sabu-Sabu bagi Generasi Muda Sulteng"
                       class="w-full rounded-xl border border-surface-300 dark:border-white/10 bg-surface-50 dark:bg-surface-950/70 px-4 py-3 text-sm text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('judul') border-danger-500 @enderror">
                @error('judul')
                    <p class="mt-1 text-xs text-danger-500 dark:text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori" class="block text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-300 mb-2">
                    Kategori Konten <span class="text-danger-500 dark:text-danger-400">*</span>
                </label>
                <select name="kategori" id="kategori" required
                        class="w-full rounded-xl border border-surface-300 dark:border-white/10 bg-surface-50 dark:bg-surface-950/70 px-4 py-3 text-sm text-surface-900 dark:text-white focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('kategori') border-danger-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    <option value="artikel" {{ old('kategori') === 'artikel' ? 'selected' : '' }}>Artikel Ilmiah & Edukasi</option>
                    <option value="kamus" {{ old('kategori') === 'kamus' ? 'selected' : '' }}>Kamus Istilah Narkoba</option>
                    <option value="media" {{ old('kategori') === 'media' ? 'selected' : '' }}>Siaran Pers & Rilis Media</option>
                </select>
                @error('kategori')
                    <p class="mt-1 text-xs text-danger-500 dark:text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konten --}}
            <div>
                <label for="konten" class="block text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-300 mb-2">
                    Isi Konten / Materi Lengkap <span class="text-danger-500 dark:text-danger-400">*</span>
                </label>
                <textarea name="konten" id="konten" rows="10" required
                          placeholder="Tuliskan materi edukasi, definisi bahaya, tahapan rehabilitasi, atau informasi pencegahan secara lengkap..."
                          class="w-full rounded-xl border border-surface-300 dark:border-white/10 bg-surface-50 dark:bg-surface-950/70 px-4 py-3 text-sm text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition leading-relaxed @error('konten') border-danger-500 @enderror">{{ old('konten') }}</textarea>
                @error('konten')
                    <p class="mt-1 text-xs text-danger-500 dark:text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload Gambar Sampul --}}
            <div>
                <label for="gambar" class="block text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-300 mb-2">
                    Foto / Gambar Sampul (Opsional)
                </label>
                <div class="relative">
                    <input type="file" name="gambar" id="gambar"
                           accept="image/jpeg,image/png,image/webp,image/jpg"
                           onchange="previewGambar(this)"
                           class="block w-full text-sm text-surface-600 dark:text-surface-300
                                  file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0
                                  file:text-xs file:font-semibold file:bg-primary-100 dark:file:bg-primary-600/20 file:text-primary-700 dark:file:text-primary-400
                                  hover:file:bg-primary-200 dark:hover:file:bg-primary-600/30 file:cursor-pointer file:transition
                                  rounded-xl border border-surface-300 dark:border-white/10 bg-surface-50 dark:bg-surface-950/70 px-4 py-2.5
                                  focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition
                                  cursor-pointer @error('gambar') border-danger-500 @enderror">
                </div>
                <p class="mt-1.5 text-[11px] text-surface-400 dark:text-surface-500">
                    Format: JPG, PNG, WEBP. Maksimal: 5 MB. Gambar akan dijadikan thumbnail kartu & banner artikel.
                </p>
                @error('gambar')
                    <p class="mt-1 text-xs text-danger-500 dark:text-danger-400">{{ $message }}</p>
                @enderror

                {{-- Live Image Preview --}}
                <div id="preview-container" class="hidden mt-3">
                    <p class="text-xs font-medium text-surface-500 dark:text-surface-400 mb-1.5">Pratinjau Gambar:</p>
                    <div class="relative w-full max-w-sm h-48 rounded-2xl overflow-hidden border border-surface-200 dark:border-white/10 shadow-sm bg-surface-100 dark:bg-surface-950">
                        <img id="image-preview" src="#" alt="Pratinjau Gambar" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            {{-- Upload Lampiran Dokumen --}}
            <div>
                <label for="lampiran" class="block text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-300 mb-2">
                    Upload Lampiran Dokumen (Opsional)
                </label>
                <div class="relative">
                    <input type="file" name="lampiran" id="lampiran"
                           accept=".pdf,.jpg,.jpeg,.png,.webp"
                           class="block w-full text-sm text-surface-600 dark:text-surface-300
                                  file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0
                                  file:text-xs file:font-semibold file:bg-primary-100 dark:file:bg-primary-600/20 file:text-primary-700 dark:file:text-primary-400
                                  hover:file:bg-primary-200 dark:hover:file:bg-primary-600/30 file:cursor-pointer file:transition
                                  rounded-xl border border-surface-300 dark:border-white/10 bg-surface-50 dark:bg-surface-950/70 px-4 py-2.5
                                  focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition
                                  cursor-pointer @error('lampiran') border-danger-500 @enderror">
                </div>
                <p class="mt-1.5 text-[11px] text-surface-400 dark:text-surface-500">
                    Format yang diterima: PDF, JPG, PNG, WEBP. Ukuran maksimal: 10 MB.
                </p>
                @error('lampiran')
                    <p class="mt-1 text-xs text-danger-500 dark:text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="pt-4 border-t border-surface-200 dark:border-white/5 flex items-center justify-end gap-3">
                <a href="{{ route('admin.edukasi.index') }}" class="px-5 py-2.5 rounded-xl border border-surface-300 dark:border-white/10 bg-white dark:bg-white/5 text-xs font-semibold text-surface-600 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-white/10 hover:text-surface-900 dark:hover:text-white transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 text-xs font-bold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-500 transition">
                    Terbitkan Materi
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    function previewGambar(input) {
        const container = document.getElementById('preview-container');
        const preview = document.getElementById('image-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
