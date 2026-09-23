@extends('layouts.admin')

@section('title', 'Kelola Zona Kerawanan')
@section('page-title', 'Kelola Zona Kerawanan Narkotika')

@section('content')
<div class="space-y-6">
    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white">Daftar Wilayah & Zona</h2>
            <p class="text-xs text-surface-400 mt-1">Pemetaan kerawanan penyalahgunaan narkotika di kabupaten/kota Sulawesi Tengah.</p>
        </div>

        <a href="{{ route('admin.zona.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-500 transition shrink-0">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Zona Baru
        </a>
    </div>

    {{-- Table Card --}}
    <div class="rounded-3xl border border-white/10 bg-surface-900/60 backdrop-blur-xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-surface-950/50 text-xs uppercase tracking-wider text-surface-400 border-b border-white/5">
                    <tr>
                        <th class="py-4 px-6 font-semibold">Nama Wilayah</th>
                        <th class="py-4 px-6 font-semibold">Status Kerawanan</th>
                        <th class="py-4 px-6 font-semibold text-center">Jumlah Kasus</th>
                        <th class="py-4 px-6 font-semibold">GeoJSON</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($zonas as $zona)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="py-4 px-6">
                                <span class="font-bold text-white block">{{ $zona->nama_wilayah }}</span>
                                <span class="text-xs text-surface-400 line-clamp-1">{{ $zona->deskripsi ?? 'Tidak ada deskripsi' }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($zona->status_zona === 'merah')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-danger-500/15 border border-danger-500/30 px-3 py-1 text-xs font-semibold text-danger-400">
                                        <span class="h-2 w-2 rounded-full bg-danger-500 animate-pulse"></span>
                                        Bahaya (Merah)
                                    </span>
                                @elseif($zona->status_zona === 'kuning')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-500/15 border border-warning-500/30 px-3 py-1 text-xs font-semibold text-warning-400">
                                        <span class="h-2 w-2 rounded-full bg-warning-500"></span>
                                        Waspada (Kuning)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 border border-accent-500/30 px-3 py-1 text-xs font-semibold text-accent-400">
                                        <span class="h-2 w-2 rounded-full bg-accent-500"></span>
                                        Aman (Hijau)
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-white">
                                {{ number_format($zona->jumlah_kasus) }}
                            </td>
                            <td class="py-4 px-6">
                                @if($zona->koordinat_geojson)
                                    <span class="inline-flex items-center gap-1 rounded-md bg-white/5 px-2 py-1 text-[11px] font-mono text-primary-400">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="text-xs text-surface-500">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.zona.edit', $zona->id) }}"
                                       class="p-2 rounded-lg bg-white/5 text-surface-300 hover:text-white hover:bg-white/10 transition"
                                       title="Edit Zona">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.zona.destroy', $zona->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data wilayah ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg bg-danger-500/10 text-danger-400 hover:bg-danger-500/20 transition"
                                                title="Hapus Zona">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-surface-500 text-sm">
                                Belum ada data zona yang diinput. Silakan klik tombol "Tambah Zona Baru".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($zonas->hasPages())
            <div class="p-4 border-t border-white/5">
                {{ $zonas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
