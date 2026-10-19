@extends('layouts.admin')

@section('title', 'Edit Materi Edukasi')
@section('page-title', 'Edit Materi Edukasi')

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
        <form action="{{ route('admin.edukasi.update', $edukasi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div>
                <label for="judul" class="block text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-300 mb-2">
                    Judul Materi / Artikel <span class="text-danger-500 dark:text-danger-400">*</span>
                </label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $edukasi->judul) }}" required
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
                    <option value="artikel" {{ old('kategori', $edukasi->kategori) === 'artikel' ? 'selected' : '' }}>Artikel Ilmiah & Edukasi</option>
                    <option value="kamus" {{ old('kategori', $edukasi->kategori) === 'kamus' ? 'selected' : '' }}>Kamus Istilah Narkoba</option>
                    <option value="media" {{ old('kategori', $edukasi->kategori) === 'media' ? 'selected' : '' }}>Siaran Pers & Rilis Media</option>
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
                          class="w-full rounded-xl border border-surface-300 dark:border-white/10 bg-surface-50 dark:bg-surface-950/70 px-4 py-3 text-sm text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition leading-relaxed @error('konten') border-danger-500 @enderror">{{ old('konten', $edukasi->konten) }}</textarea>
                @error('konten')
                    <p class="mt-1 text-xs text-danger-500 dark:text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload Gambar Sampul --}}
            <div>
                <label for="gambar" class="block text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-300 mb-2">
                    Foto / Gambar Sampul (Opsional)
                </label>

                {{-- Tampilkan gambar yang sudah ada --}}
                @if($edukasi->gambar)
                    <div class="mb-3 flex items-center gap-3 rounded-2xl border border-surface-200 dark:border-white/10 bg-surface-50 dark:bg-surface-950/50 p-3">
                        <div class="h-16 w-24 rounded-xl overflow-hidden bg-surface-200 dark:bg-surface-800 shrink-0">
                            <img src="{{ $edukasi->gambar_url }}" alt="{{ $edukasi->judul }}" class="h-full w-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-surface-700 dark:text-surface-200 truncate">{{ basename($edukasi->gambar) }}</p>
                            <a href="{{ $edukasi->gambar_url }}" target="_blank"
                               class="text-[11px] text-primary-600 dark:text-primary-400 hover:text-primary-500 transition">
                                Buka Gambar Ukuran Penuh
                            </a>
                        </div>
                        <label class="flex items-center gap-1.5 cursor-pointer shrink-0 px-2 py-1 rounded-lg hover:bg-danger-50 dark:hover:bg-danger-500/10 transition">
                            <input type="checkbox" name="hapus_gambar" value="1"
                                   class="rounded border-surface-300 dark:border-white/20 bg-white dark:bg-surface-950 text-danger-500 focus:ring-danger-500">
                            <span class="text-[11px] font-medium text-danger-500 dark:text-danger-400">Hapus Gambar</span>
                        </label>
                    </div>
                @endif

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
                    Format: JPG, PNG, WEBP. Maksimal: 5 MB. @if($edukasi->gambar) Mengunggah gambar baru akan menggantikan gambar yang ada saat ini. @endif
                </p>
                @error('gambar')
                    <p class="mt-1 text-xs text-danger-500 dark:text-danger-400">{{ $message }}</p>
                @enderror

                {{-- Live Image Preview --}}
                <div id="preview-container" class="hidden mt-3">
                    <p class="text-xs font-medium text-surface-500 dark:text-surface-400 mb-1.5">Pratinjau Gambar Baru:</p>
                    <div class="relative w-full max-w-sm h-48 rounded-2xl overflow-hidden border border-surface-200 dark:border-white/10 shadow-sm bg-surface-100 dark:bg-surface-950">
                        <img id="image-preview" src="#" alt="Pratinjau Gambar Baru" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            {{-- Upload Lampiran Dokumen --}}
            <div>
                <label for="lampiran" class="block text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-300 mb-2">
                    Upload Lampiran Dokumen (Opsional)
                </label>

                {{-- Tampilkan file yang sudah ada --}}
                @if($edukasi->file_path)
                    <div class="mb-3 flex items-center gap-3 rounded-xl border border-surface-200 dark:border-white/10 bg-surface-50 dark:bg-surface-950/50 px-4 py-3">
                        <svg class="h-5 w-5 text-primary-500 dark:text-primary-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-surface-600 dark:text-surface-300 truncate">{{ basename($edukasi->file_path) }}</p>
                            <a href="{{ asset('storage/' . $edukasi->file_path) }}" target="_blank"
                               class="text-[11px] text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300 transition">
                                Lihat / Unduh File
                            </a>
                        </div>
                        <label class="flex items-center gap-1.5 cursor-pointer shrink-0">
                            <input type="checkbox" name="hapus_lampiran" value="1"
                                   class="rounded border-surface-300 dark:border-white/20 bg-white dark:bg-surface-950 text-danger-500 focus:ring-danger-500 focus:ring-offset-white dark:focus:ring-offset-surface-900">
                            <span class="text-[11px] text-danger-500 dark:text-danger-400">Hapus</span>
                        </label>
                    </div>
                @endif

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
                    @if($edukasi->file_path)
                        Upload file baru akan menggantikan lampiran yang sudah ada.
                    @endif
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
                    Simpan Perubahan
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
