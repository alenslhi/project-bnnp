@extends('layouts.admin')

@section('title', 'Edit Zona ' . $zona->nama_wilayah)
@section('page-title', 'Edit Data Zona')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.zona.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-surface-400 hover:text-white transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Kembali ke Daftar Zona
        </a>
    </div>

    <div class="rounded-3xl border border-white/10 bg-surface-900/60 backdrop-blur-xl p-6 sm:p-8 shadow-xl">
        <form action="{{ route('admin.zona.update', $zona->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Wilayah --}}
            <div>
                <label for="nama_wilayah" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                    Nama Wilayah / Kabupaten / Kota <span class="text-danger-400">*</span>
                </label>
                <input type="text" name="nama_wilayah" id="nama_wilayah" value="{{ old('nama_wilayah', $zona->nama_wilayah) }}" required
                       class="w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('nama_wilayah') border-danger-500 @enderror">
                @error('nama_wilayah')
                    <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Grid Status & Jumlah Kasus --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Status Zona --}}
                <div>
                    <label for="status_zona" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                        Status Kerawanan <span class="text-danger-400">*</span>
                    </label>
                    <select name="status_zona" id="status_zona" required
                            class="w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-sm text-white focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('status_zona') border-danger-500 @enderror">
                        <option value="merah" {{ old('status_zona', $zona->status_zona) === 'merah' ? 'selected' : '' }}>🔴 Merah (Bahaya / Rawan Tinggi)</option>
                        <option value="kuning" {{ old('status_zona', $zona->status_zona) === 'kuning' ? 'selected' : '' }}>🟡 Kuning (Waspada / Rawan Sedang)</option>
                        <option value="hijau" {{ old('status_zona', $zona->status_zona) === 'hijau' ? 'selected' : '' }}>🟢 Hijau (Aman / Rawan Rendah)</option>
                    </select>
                    @error('status_zona')
                        <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah Kasus --}}
                <div>
                    <label for="jumlah_kasus" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                        Jumlah Kasus Tercatat <span class="text-danger-400">*</span>
                    </label>
                    <input type="number" name="jumlah_kasus" id="jumlah_kasus" value="{{ old('jumlah_kasus', $zona->jumlah_kasus) }}" min="0" required
                           class="w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition @error('jumlah_kasus') border-danger-500 @enderror">
                    @error('jumlah_kasus')
                        <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2">
                    Deskripsi / Catatan Lapangan (Opsional)
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="3"
                          class="w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition">{{ old('deskripsi', $zona->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Koordinat GeoJSON --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="koordinat_geojson" class="block text-xs font-semibold uppercase tracking-wider text-surface-300">
                        Data Koordinat GeoJSON (Opsional)
                    </label>
                    <span class="text-[11px] text-surface-500 font-mono">Format JSON Leaflet</span>
                </div>
                <textarea name="koordinat_geojson" id="koordinat_geojson" rows="4"
                          class="font-mono text-xs w-full rounded-xl border border-white/10 bg-surface-950/70 px-4 py-3 text-white placeholder-surface-600 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition">{{ old('koordinat_geojson', $zona->koordinat_geojson) }}</textarea>
                @error('koordinat_geojson')
                    <p class="mt-1 text-xs text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="pt-4 border-t border-white/5 flex items-center justify-end gap-3">
                <a href="{{ route('admin.zona.index') }}" class="px-5 py-2.5 rounded-xl border border-white/10 bg-white/5 text-xs font-semibold text-surface-300 hover:bg-white/10 hover:text-white transition">
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
