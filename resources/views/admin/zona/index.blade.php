@extends('layouts.admin')

@section('title', 'Kelola Zona Kerawanan')
@section('page-title', 'Pengelolaan Peta & Zona Kerawanan')

@push('styles')
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #admin-peta-zona {
        height: 380px;
        max-height: 400px;
        border-radius: 1rem;
        z-index: 10;
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }
    @media (min-height: 850px) {
        #admin-peta-zona {
            height: 420px;
            max-height: 450px;
        }
    }
    .leaflet-popup-content-wrapper {
        background: #0f172a !important;
        color: #f8fafc !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 12px !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }
    .leaflet-popup-tip {
        background: #0f172a !important;
    }
    .leaflet-control-layers {
        border-radius: 10px !important;
        background: rgba(15, 23, 42, 0.9) !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        backdrop-filter: blur(8px);
        padding: 6px 10px !important;
    }
    .leaflet-control-layers label {
        color: #e2e8f0 !important;
        font-size: 13px !important;
        cursor: pointer;
    }
    .quick-kab-pill.active {
        background-color: #0284c7 !important;
        color: #ffffff !important;
        border-color: #38bdf8 !important;
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.35) !important;
        font-weight: 700 !important;
    }
    .quick-kab-pill:not(.active):hover {
        border-color: rgba(255, 255, 255, 0.3);
        color: #ffffff;
        transform: translateY(-1px);
    }
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .badge-status-merah {
        background-color: rgba(239, 68, 68, 0.18) !important;
        border: 1px solid rgba(239, 68, 68, 0.45) !important;
        color: #f87171 !important;
    }
    .badge-status-kuning {
        background-color: rgba(245, 158, 11, 0.18) !important;
        border: 1px solid rgba(245, 158, 11, 0.45) !important;
        color: #fbbf24 !important;
    }
    .badge-status-hijau {
        background-color: rgba(16, 185, 129, 0.18) !important;
        border: 1px solid rgba(16, 185, 129, 0.45) !important;
        color: #34d399 !important;
    }
</style>
@endpush

@section('content')
<div class="space-y-4 min-w-0 max-w-full overflow-hidden">

    {{-- Toast Notification --}}
    <div id="toast-notif" class="fixed top-6 right-6 z-50 hidden transition-all duration-300 transform translate-y-[-20px] opacity-0">
        <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl bg-emerald-500/90 text-white font-medium shadow-2xl backdrop-blur-xl border border-white/20">
            <svg class="h-5 w-5 text-white shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
            <span id="toast-text">Perubahan berhasil disimpan!</span>
        </div>
    </div>

    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 min-w-0 max-w-full pb-1">
        <div class="min-w-0">
            <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                Zona Kerawanan
            </h2>
            <p class="text-xs sm:text-sm text-surface-400 mt-0.5">
                Monitoring status kerawanan wilayah Sulawesi Tengah tingkat kecamatan & kelurahan
            </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('peta') }}" target="_blank"
               class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3.5 py-2 text-xs font-medium text-surface-300 hover:text-white hover:bg-white/10 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
                Lihat Peta Publik
            </a>
            <a href="{{ route('admin.zona.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-3.5 py-2 text-xs font-semibold text-white shadow-md shadow-primary-600/20 hover:bg-primary-500 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Tambah Wilayah
            </a>
        </div>
    </div>

    {{-- Unified Minimalist Toolbar --}}
    @php
        $countMerah = $allZonas->where('status_zona', 'merah')->count();
        $countKuning = $allZonas->where('status_zona', 'kuning')->count();
        $countHijau = $allZonas->where('status_zona', 'hijau')->count();
        $activeKab = $parentKode ? $kabupatens->firstWhere('kode_wilayah', $parentKode) : null;
    @endphp
    <div class="rounded-2xl border border-white/10 bg-surface-900/60 p-3 sm:p-3.5 backdrop-blur-xl shadow-lg space-y-3 min-w-0 max-w-full">
        
        {{-- Baris 1: Mode Switcher, Filter & Status Counter --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 min-w-0 max-w-full">
            
            {{-- Kiri: Switcher Tab (Peta vs Tabel) --}}
            <div class="flex items-center gap-1 p-1 rounded-xl bg-surface-950 border border-white/10 w-fit shrink-0">
                <button type="button" 
                        id="tab-btn-peta"
                        onclick="switchAdminView('peta')" 
                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-2 bg-primary-600 text-white shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                    </svg>
                    Peta Interaktif
                </button>
                <button type="button" 
                        id="tab-btn-tabel"
                        onclick="switchAdminView('tabel')" 
                        class="px-3.5 py-1.5 rounded-lg text-xs font-medium transition flex items-center gap-2 text-surface-400 hover:text-white hover:bg-white/5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    Tabel Data ({{ $allZonas->count() }})
                </button>
            </div>

            {{-- Kanan: Form Filter & Status Counter --}}
            <div class="flex items-center gap-2.5 flex-wrap min-w-0">
                <form action="{{ route('admin.zona.index') }}" method="GET" class="flex items-center gap-2 flex-wrap min-w-0">
                    <input type="hidden" name="tingkat" value="{{ $tingkat }}">

                    {{-- Dropdown Pilih Kabupaten --}}
                    <select name="parent_kode" onchange="this.form.submit()" class="rounded-xl bg-surface-950 border border-white/10 px-3 py-1.5 text-xs text-white focus:border-primary-500 outline-none transition cursor-pointer max-w-[190px]">
                        <option value="">Semua Kabupaten</option>
                        @foreach($kabupatens as $kab)
                            @php $kCount = $kecamatanCounts[$kab->kode_wilayah] ?? 0; @endphp
                            <option value="{{ $kab->kode_wilayah }}" {{ $parentKode === $kab->kode_wilayah ? 'selected' : '' }}>
                                {{ $kab->nama_wilayah }} ({{ $kCount }})
                            </option>
                        @endforeach
                    </select>

                    {{-- Input Cari dengan Icon --}}
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-surface-500">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari wilayah..."
                               class="w-32 sm:w-36 rounded-xl border border-white/10 bg-surface-950 pl-8 pr-3 py-1.5 text-xs text-white placeholder-surface-500 focus:border-primary-500 outline-none transition">
                    </div>

                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-medium text-white transition shrink-0">
                        Cari
                    </button>

                    @if($search || $parentKode || $tingkat !== 'kecamatan')
                        <a href="{{ route('admin.zona.index', ['tingkat' => 'kecamatan']) }}" 
                           class="px-2.5 py-1.5 rounded-xl border border-white/10 bg-white/5 hover:bg-white/15 text-xs text-surface-300 hover:text-white font-medium transition shrink-0"
                           title="Reset filter">
                            Reset
                        </a>
                    @endif
                </form>

                {{-- Status Counter Pill dengan Penanda Warna --}}
                <div class="flex items-center gap-2 text-xs bg-surface-950 px-3 py-1.5 rounded-xl border border-white/10 shrink-0">
                    <div class="flex items-center gap-1.5" title="Rawan Tinggi (Merah)">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>
                        <span class="text-white font-semibold">{{ $countMerah }}</span>
                    </div>
                    <span class="text-white/20">•</span>
                    <div class="flex items-center gap-1.5" title="Rawan Sedang (Kuning)">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 inline-block"></span>
                        <span class="text-white font-semibold">{{ $countKuning }}</span>
                    </div>
                    <span class="text-white/20">•</span>
                    <div class="flex items-center gap-1.5" title="Rawan Rendah (Hijau)">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                        <span class="text-white font-semibold">{{ $countHijau }}</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Baris 2: Quick Filter Kabupaten Scrollable --}}
        <div class="flex items-center gap-2 pt-2 border-t border-white/5 min-w-0 max-w-full overflow-hidden">
            <button type="button" 
                    onclick="scrollAdminPills(-240)" 
                    aria-label="Geser ke kiri"
                    class="shrink-0 w-6 h-6 rounded-lg border border-white/10 bg-surface-950/90 hover:bg-white/15 text-surface-400 hover:text-white flex items-center justify-center text-xs font-bold transition">
                ‹
            </button>

            <div id="admin-pills-container" 
                 class="flex-1 min-w-0 flex items-center gap-1.5 overflow-x-auto pb-0.5 scrollbar-none flex-nowrap py-0.5 select-none cursor-grab active:cursor-grabbing">
                
                <a href="{{ route('admin.zona.index', ['tingkat' => 'kecamatan', 'search' => $search]) }}"
                   class="quick-kab-pill {{ empty($parentKode) && $tingkat === 'kecamatan' ? 'active' : '' }} px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap transition border border-white/5 bg-surface-950 text-surface-400 hover:text-white hover:border-white/20 shrink-0">
                    Semua Wilayah ({{ $allZonas->count() }})
                </a>

                <a href="{{ route('admin.zona.index', ['tingkat' => 'kecamatan', 'parent_kode' => '72.08', 'search' => $search]) }}"
                   class="quick-kab-pill {{ $parentKode === '72.08' && $tingkat === 'kecamatan' ? 'active' : '' }} px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap transition border border-white/5 bg-surface-950 text-surface-400 hover:text-white hover:border-white/20 flex items-center gap-1 shrink-0">
                    <span>Parigi Moutong</span>
                    <span class="text-[10px] text-surface-500 font-mono">(23)</span>
                </a>

                @foreach($kabupatens as $kab)
                    @if($kab->kode_wilayah !== '72.08')
                        @php $kecCount = $kecamatanCounts[$kab->kode_wilayah] ?? null; @endphp
                        <a href="{{ route('admin.zona.index', ['tingkat' => 'kecamatan', 'parent_kode' => $kab->kode_wilayah, 'search' => $search]) }}"
                           class="quick-kab-pill {{ $parentKode === $kab->kode_wilayah && $tingkat === 'kecamatan' ? 'active' : '' }} px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap transition border border-white/5 bg-surface-950 text-surface-400 hover:text-white hover:border-white/20 flex items-center gap-1 shrink-0">
                            <span>{{ str_replace(['Kabupaten ', 'Kota '], '', $kab->nama_wilayah) }}</span>
                            @if($kecCount)
                                <span class="text-[10px] text-surface-500 font-mono">({{ $kecCount }})</span>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>

            <button type="button" 
                    onclick="scrollAdminPills(240)" 
                    aria-label="Geser ke kanan"
                    class="shrink-0 w-6 h-6 rounded-lg border border-white/10 bg-surface-950/90 hover:bg-white/15 text-surface-400 hover:text-white flex items-center justify-center text-xs font-bold transition">
                ›
            </button>
        </div>

    </div>

    {{-- 1. Container Tampilan Peta (Fit Screen) --}}
    <div id="view-peta-container" class="space-y-3 min-w-0 max-w-full overflow-hidden">
        <div class="rounded-2xl border border-white/10 bg-surface-900/60 backdrop-blur-xl p-3.5 sm:p-4 shadow-lg min-w-0 max-w-full overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 mb-3 min-w-0 max-w-full">
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2 truncate">
                        Peta Interaktif — {{ $activeKab ? $activeKab->nama_wilayah : ($tingkat === 'kelurahan' ? 'Kelurahan Kota Palu' : 'Sulawesi Tengah') }}
                    </h3>
                    <p class="text-xs text-surface-400 mt-0.5">
                        Klik poligon wilayah untuk mengubah status kerawanan dan jumlah kasus.
                    </p>
                </div>
                
                {{-- Legend Peta Ringkas --}}
                <div class="flex items-center gap-2 text-xs flex-wrap shrink-0">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold badge-status-merah">
                        <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span> Rawan Tinggi
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold badge-status-kuning">
                        <span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span> Rawan Sedang
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold badge-status-hijau">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Rawan Rendah
                    </span>
                </div>
            </div>

            <div id="admin-peta-zona" class="shadow-inner w-full max-w-full overflow-hidden"></div>
        </div>
    </div>

    {{-- 2. Container Tampilan Tabel Data --}}
    <div id="view-tabel-container" class="hidden space-y-3 min-w-0 max-w-full overflow-hidden">
        <div class="rounded-2xl border border-white/10 bg-surface-900/60 backdrop-blur-xl overflow-hidden shadow-lg min-w-0 max-w-full">
            <div class="p-4 sm:p-5 border-b border-white/10 flex items-center justify-between min-w-0">
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm sm:text-base font-semibold text-white truncate">Daftar Data Wilayah</h3>
                    <p class="text-xs text-surface-400 mt-0.5 truncate">Total {{ $allZonas->count() }} wilayah {{ $tingkat }} yang tersaring.</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm" id="table-zonas">
                    <thead class="bg-surface-950/60 text-xs uppercase tracking-wider text-surface-400 border-b border-white/5">
                        <tr>
                            <th class="py-3 px-4 font-semibold">Nama Wilayah</th>
                            <th class="py-3 px-4 font-semibold">Tingkat / Induk</th>
                            <th class="py-3 px-4 font-semibold">Status Kerawanan</th>
                            <th class="py-3 px-4 font-semibold text-center">Jumlah Kasus</th>
                            <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($zonas as $zona)
                            <tr class="hover:bg-white/[0.02] transition" id="row-zona-{{ $zona->id }}">
                                <td class="py-3 px-4">
                                    <span class="font-semibold text-white block nama-wilayah-text">{{ $zona->nama_wilayah }}</span>
                                    <span class="text-xs text-surface-400 line-clamp-1 deskripsi-text">{{ $zona->deskripsi ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-medium bg-white/5 text-primary-300 border border-white/10">
                                        {{ ucfirst($zona->tingkat) }}
                                    </span>
                                    @if($zona->parent_nama)
                                        <span class="block text-xs text-surface-400 mt-0.5">{{ $zona->parent_nama }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="status-badge" id="badge-zona-{{ $zona->id }}">
                                        @if($zona->status_zona === 'merah')
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold badge-status-merah">
                                                <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span> Rawan Tinggi
                                            </span>
                                        @elseif($zona->status_zona === 'kuning')
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold badge-status-kuning">
                                                <span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span> Rawan Sedang
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold badge-status-hijau">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Rawan Rendah
                                            </span>
                                        @endif
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-medium text-white jumlah-kasus-text">
                                    {{ number_format($zona->jumlah_kasus) }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <button type="button"
                                                onclick="openEditModal({{ $zona->id }})"
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 text-xs font-medium text-surface-200 hover:text-white transition"
                                                title="Ubah Status Wilayah">
                                            <svg class="h-3.5 w-3.5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-3.877a2.25 2.25 0 00-3.182-3.182l-3.877 3.877a15.995 15.995 0 00-4.647 4.764m3.046.066l.004-.004"/>
                                            </svg>
                                            Ubah Status
                                        </button>
                                        <a href="{{ route('admin.zona.edit', $zona->id) }}"
                                           class="p-1.5 rounded-lg bg-white/5 text-surface-400 hover:text-white hover:bg-white/10 transition"
                                           title="Edit Detail Form">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-surface-500 text-sm">
                                    Tidak ada data wilayah untuk filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($zonas->hasPages())
                <div class="p-3.5 border-t border-white/5">
                    {{ $zonas->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ═══ MODAL CEPAT UBAH WARNA & STATUS ZONA ═══ --}}
<div id="modal-edit-zona" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="w-full max-w-lg rounded-3xl border border-white/15 bg-surface-900 p-6 sm:p-7 shadow-2xl relative transform transition-all duration-300">
        
        {{-- Close Button --}}
        <button type="button" onclick="closeEditModal()" class="absolute top-5 right-5 text-surface-400 hover:text-white p-2 rounded-xl bg-white/5 hover:bg-white/10 transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="mb-5">
            <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-semibold uppercase tracking-wider bg-primary-500/20 text-primary-400 border border-primary-500/30 mb-2" id="modal-tingkat-label">
                Wilayah
            </span>
            <h3 class="text-xl font-bold text-white" id="modal-nama-wilayah">Nama Wilayah</h3>
            <p class="text-xs text-surface-400 mt-1">Pilih warna status kerawanan untuk diterapkan pada seluruh batas wilayah ini.</p>
        </div>

        <form id="form-edit-zona" onsubmit="submitEditZona(event)" class="space-y-5">
            <input type="hidden" id="modal-zona-id" value="">

            {{-- Pilihan Warna / Status Kerawanan (Radio Cards) --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-2.5">
                    Pilih Warna & Status Kerawanan <span class="text-danger-400">*</span>
                </label>
                <div class="grid grid-cols-3 gap-3">
                    {{-- Merah --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="modal_status_zona" value="merah" class="peer sr-only">
                        <div class="rounded-2xl border-2 border-white/10 bg-surface-950/60 p-3.5 text-center transition-all peer-checked:border-red-500 peer-checked:bg-red-500/15 peer-checked:shadow-lg peer-checked:shadow-red-500/25 hover:border-white/20">
                            <span class="h-6 w-6 rounded-full bg-red-500 inline-block shadow-md shadow-red-500/50 mb-1.5"></span>
                            <div class="font-bold text-xs text-white">Merah</div>
                            <div class="text-[10px] text-red-400 mt-0.5">Rawan Tinggi</div>
                        </div>
                    </label>

                    {{-- Kuning --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="modal_status_zona" value="kuning" class="peer sr-only">
                        <div class="rounded-2xl border-2 border-white/10 bg-surface-950/60 p-3.5 text-center transition-all peer-checked:border-amber-500 peer-checked:bg-amber-500/15 peer-checked:shadow-lg peer-checked:shadow-amber-500/25 hover:border-white/20">
                            <span class="h-6 w-6 rounded-full bg-amber-500 inline-block shadow-md shadow-amber-500/50 mb-1.5"></span>
                            <div class="font-bold text-xs text-white">Kuning</div>
                            <div class="text-[10px] text-amber-400 mt-0.5">Rawan Sedang</div>
                        </div>
                    </label>

                    {{-- Hijau --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="modal_status_zona" value="hijau" class="peer sr-only">
                        <div class="rounded-2xl border-2 border-white/10 bg-surface-950/60 p-3.5 text-center transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-500/15 peer-checked:shadow-lg peer-checked:shadow-emerald-500/25 hover:border-white/20">
                            <span class="h-6 w-6 rounded-full bg-emerald-500 inline-block shadow-md shadow-emerald-500/50 mb-1.5"></span>
                            <div class="font-bold text-xs text-white">Hijau</div>
                            <div class="text-[10px] text-emerald-400 mt-0.5">Rawan Rendah</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Input Jumlah Kasus --}}
            <div>
                <label for="modal-jumlah-kasus" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-1.5">
                    Jumlah Kasus Tercatat <span class="text-danger-400">*</span>
                </label>
                <input type="number" id="modal-jumlah-kasus" min="0" required
                       class="w-full rounded-xl border border-white/10 bg-surface-950/80 px-4 py-2.5 text-sm text-white focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition">
            </div>

            {{-- Input Deskripsi / Catatan --}}
            <div>
                <label for="modal-deskripsi" class="block text-xs font-semibold uppercase tracking-wider text-surface-300 mb-1.5">
                    Deskripsi / Catatan Lapangan (Opsional)
                </label>
                <textarea id="modal-deskripsi" rows="3"
                          class="w-full rounded-xl border border-white/10 bg-surface-950/80 px-4 py-2.5 text-sm text-white placeholder-surface-500 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/20 transition"></textarea>
            </div>

            {{-- Actions --}}
            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl border border-white/10 bg-white/5 text-xs font-medium text-surface-300 hover:bg-white/10 hover:text-white transition">
                    Batal
                </button>
                <button type="submit" id="btn-save-modal" class="px-5 py-2 rounded-xl bg-primary-600 text-xs font-semibold text-white shadow-md shadow-primary-600/20 hover:bg-primary-500 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Data zona halaman saat ini dari server
const currentTingkat = @json($tingkat);
const currentParentKode = @json($parentKode);
const zonasData = @json($allZonas);
const zonaMapById = {};
zonasData.forEach(z => {
    zonaMapById[z.id] = z;
});

// Warna peta
const statusColors = {
    'merah': '#ef4444',
    'kuning': '#f59e0b',
    'hijau': '#10b981',
};

let map;
let geoJsonLayer;
const layerMapByZonaId = {};

// Switcher Tab antara Peta dan Tabel Data
function switchAdminView(view) {
    const petaContainer = document.getElementById('view-peta-container');
    const tabelContainer = document.getElementById('view-tabel-container');
    const btnPeta = document.getElementById('tab-btn-peta');
    const btnTabel = document.getElementById('tab-btn-tabel');

    if (!petaContainer || !tabelContainer || !btnPeta || !btnTabel) return;

    const activeClass = "px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-2 bg-primary-600 text-white shadow-sm";
    const inactiveClass = "px-3.5 py-1.5 rounded-lg text-xs font-medium transition flex items-center gap-2 text-surface-400 hover:text-white hover:bg-white/5";

    if (view === 'tabel') {
        petaContainer.classList.add('hidden');
        tabelContainer.classList.remove('hidden');

        btnTabel.className = activeClass;
        btnPeta.className = inactiveClass;

        localStorage.setItem('admin_zona_view', 'tabel');
    } else {
        tabelContainer.classList.add('hidden');
        petaContainer.classList.remove('hidden');

        btnPeta.className = activeClass;
        btnTabel.className = inactiveClass;

        localStorage.setItem('admin_zona_view', 'peta');

        setTimeout(() => {
            if (map) {
                map.invalidateSize();
                if (geoJsonLayer && geoJsonLayer.getBounds().isValid()) {
                    map.fitBounds(geoJsonLayer.getBounds(), { padding: [15, 15], maxZoom: 12 });
                }
            }
        }, 150);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Tampilan Tab Aktif (Peta vs Tabel)
    const urlParams = new URLSearchParams(window.location.search);
    const hasSearch = urlParams.has('search') && urlParams.get('search').trim() !== '';
    const hasPage = urlParams.has('page');
    const savedView = localStorage.getItem('admin_zona_view');

    if (hasPage || hasSearch) {
        switchAdminView('tabel');
    } else if (savedView === 'tabel') {
        switchAdminView('tabel');
    } else {
        switchAdminView('peta');
    }

    // 1. Inisialisasi Peta Leaflet Admin dengan batas wilayah terkunci (Fit Sulteng, tidak bisa digeser ke pulau lain)
    const sultengBounds = L.latLngBounds(
        L.latLng(-3.8, 119.0), // Barat daya Sulteng
        L.latLng(1.6, 124.5)   // Timur laut Sulteng
    );

    map = L.map('admin-peta-zona', {
        zoomControl: true,
        scrollWheelZoom: true,
        minZoom: 7,
        maxBounds: sultengBounds.pad(0.08),
        maxBoundsViscosity: 0.9,
    }).setView([-1.0, 120.5], 7);

    // 2. Base Tile Layers (OpenStreetMap resmi lengkap perbatasan)
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19,
    });

    const esriTopo = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Esri Topo',
        maxZoom: 18,
    });

    const satelliteLayer = L.layerGroup([
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Esri Imagery',
            maxZoom: 18,
        }),
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Batas Esri',
            maxZoom: 18,
        })
    ]);

    osmLayer.addTo(map);

    L.control.layers({
        "OpenStreetMap (Lengkap Perbatasan)": osmLayer,
        "Topografi Detail": esriTopo,
        "Satelit + Batas Wilayah": satelliteLayer,
    }, null, { position: 'topright' }).addTo(map);

    setTimeout(() => { map.invalidateSize(); }, 300);

    // Inisialisasi scroll horizontal tombol kabupaten admin
    initAdminPillsScroll();

    // 3. Load & Render GeoJSON Poligon Wilayah sesuai filter aktif
    loadAdminPeta();
});

function loadAdminPeta() {
    let url = `{{ route("peta.geojson") }}?tingkat=${currentTingkat}`;
    if (currentParentKode) {
        url += `&parent_kode=${currentParentKode}`;
    }

    fetch(url)
        .then(res => res.json())
        .then(data => {
            if (geoJsonLayer) {
                map.removeLayer(geoJsonLayer);
            }

            geoJsonLayer = L.geoJSON(data, {
                style: function(feature) {
                    const color = statusColors[feature.properties.status_zona] || '#3b82f6';
                    return {
                        fillColor: color,
                        color: '#ffffff',
                        weight: currentTingkat === 'kelurahan' ? 1.5 : 2,
                        opacity: 0.95,
                        fillOpacity: currentTingkat === 'kelurahan' ? 0.65 : 0.6
                    };
                },
                onEachFeature: function(feature, layer) {
                    const p = feature.properties;
                    layerMapByZonaId[p.id] = layer;

                    const labelTingkat = p.tingkat === 'kabupaten' ? 'Kabupaten/Kota' : (p.tingkat === 'kecamatan' ? 'Kecamatan' : 'Kelurahan / Desa');

                    // Tooltip
                    layer.bindTooltip(`
                        <div style="font-weight:700">${p.nama_wilayah}</div>
                        <div style="font-size:11px;opacity:0.85">${labelTingkat} • ${p.status_zona.toUpperCase()} • Klik untuk ubah warna</div>
                    `, {
                        sticky: true,
                        direction: 'top',
                        className: 'bg-surface-900 text-white text-xs border border-white/20 rounded-lg px-2.5 py-1.5 shadow-xl'
                    });

                    // Hover & Click events
                    layer.on({
                        mouseover: function(e) {
                            const l = e.target;
                            l.setStyle({
                                weight: 3,
                                color: '#38bdf8',
                                fillOpacity: 0.85
                            });
                            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                l.bringToFront();
                            }
                        },
                        mouseout: function(e) {
                            geoJsonLayer.resetStyle(e.target);
                        },
                        click: function(e) {
                            openEditModal(p.id);
                        }
                    });
                }
            }).addTo(map);

            if (geoJsonLayer.getBounds().isValid()) {
                map.fitBounds(geoJsonLayer.getBounds(), { padding: [15, 15], maxZoom: 12 });
            }
        })
        .catch(err => console.error('Gagal memuat poligon peta:', err));
}

// 4. Modal Edit Handlers
function openEditModal(zonaId) {
    const zona = zonaMapById[zonaId];
    if (!zona) return;

    document.getElementById('modal-zona-id').value = zona.id;
    document.getElementById('modal-nama-wilayah').textContent = zona.nama_wilayah;
    document.getElementById('modal-tingkat-label').textContent = `${zona.tingkat.toUpperCase()} ${zona.parent_nama ? '• ' + zona.parent_nama : ''}`;
    document.getElementById('modal-jumlah-kasus').value = zona.jumlah_kasus;
    document.getElementById('modal-deskripsi').value = zona.deskripsi || '';

    // Set radio status
    const radios = document.getElementsByName('modal_status_zona');
    radios.forEach(r => {
        r.checked = (r.value === zona.status_zona);
    });

    // Tampilkan modal
    const modal = document.getElementById('modal-edit-zona');
    modal.classList.remove('hidden');

    // Sorot poligon di peta jika layer tersedia
    const layer = layerMapByZonaId[zona.id];
    if (layer && layer.getBounds) {
        map.panTo(layer.getBounds().getCenter());
    }
}

function closeEditModal() {
    document.getElementById('modal-edit-zona').classList.add('hidden');
}

// 5. Submit Perubahan Warna / Status Zona via AJAX
function submitEditZona(e) {
    e.preventDefault();

    const zonaId = document.getElementById('modal-zona-id').value;
    const zona = zonaMapById[zonaId];
    if (!zona) return;

    const selectedRadio = document.querySelector('input[name="modal_status_zona"]:checked');
    const statusZona = selectedRadio ? selectedRadio.value : zona.status_zona;
    const jumlahKasus = parseInt(document.getElementById('modal-jumlah-kasus').value) || 0;
    const deskripsi = document.getElementById('modal-deskripsi').value;

    const btnSave = document.getElementById('btn-save-modal');
    btnSave.disabled = true;
    btnSave.textContent = 'Menyimpan...';

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/admin/zona/${zonaId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-HTTP-Method-Override': 'PUT',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            _method: 'PUT',
            nama_wilayah: zona.nama_wilayah,
            status_zona: statusZona,
            jumlah_kasus: jumlahKasus,
            deskripsi: deskripsi
        })
    })
    .then(res => res.json())
    .then(data => {
        btnSave.disabled = false;
        btnSave.textContent = 'Simpan Perubahan';

        if (data.success || data.zona) {
            // Update cache lokal
            zona.status_zona = statusZona;
            zona.jumlah_kasus = jumlahKasus;
            zona.deskripsi = deskripsi;

            // 1. Update warna poligon di peta secara instan
            const layer = layerMapByZonaId[zonaId];
            if (layer) {
                layer.feature.properties.status_zona = statusZona;
                layer.feature.properties.jumlah_kasus = jumlahKasus;
                layer.feature.properties.deskripsi = deskripsi;
                layer.setStyle({
                    fillColor: statusColors[statusZona],
                    color: '#ffffff',
                    fillOpacity: currentTingkat === 'kelurahan' ? 0.65 : 0.6
                });
            }

            // 2. Update baris di tabel
            updateTableRow(zona);

            // 3. Update ringkasan statistik
            updateStats();

            // Tutup modal
            closeEditModal();

            // Tampilkan Toast
            showToast(`Status wilayah ${zona.nama_wilayah} berhasil diperbarui!`);
        } else {
            alert('Gagal menyimpan data: ' + (data.message || 'Terjadi kesalahan.'));
        }
    })
    .catch(err => {
        btnSave.disabled = false;
        btnSave.textContent = 'Simpan Perubahan';
        console.error('Error:', err);
        alert('Terjadi kesalahan saat menyimpan perubahan zona.');
    });
}

function updateTableRow(zona) {
    const row = document.getElementById(`row-zona-${zona.id}`);
    if (!row) return;

    // Update jumlah kasus
    const kasusEl = row.querySelector('.jumlah-kasus-text');
    if (kasusEl) kasusEl.textContent = new Intl.NumberFormat().format(zona.jumlah_kasus);

    // Update deskripsi
    const descEl = row.querySelector('.deskripsi-text');
    if (descEl) descEl.textContent = zona.deskripsi || '-';

    // Update badge status
    const badgeEl = document.getElementById(`badge-zona-${zona.id}`);
    if (badgeEl) {
        if (zona.status_zona === 'merah') {
            badgeEl.innerHTML = `
                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold badge-status-merah">
                    <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span> Rawan Tinggi
                </span>`;
        } else if (zona.status_zona === 'kuning') {
            badgeEl.innerHTML = `
                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold badge-status-kuning">
                    <span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span> Rawan Sedang
                </span>`;
        } else {
            badgeEl.innerHTML = `
                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold badge-status-hijau">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Rawan Rendah
                </span>`;
        }
    }
}

function updateStats() {
    let merah = 0, kuning = 0, hijau = 0;
    Object.values(zonaMapById).forEach(z => {
        if (z.status_zona === 'merah') merah++;
        else if (z.status_zona === 'kuning') kuning++;
        else if (z.status_zona === 'hijau') hijau++;
    });

    const elM = document.getElementById('stat-merah');
    const elK = document.getElementById('stat-kuning');
    const elH = document.getElementById('stat-hijau');
    if (elM) elM.textContent = merah + ' Wilayah';
    if (elK) elK.textContent = kuning + ' Wilayah';
    if (elH) elH.textContent = hijau + ' Wilayah';
}

function showToast(msg) {
    const toast = document.getElementById('toast-notif');
    const text = document.getElementById('toast-text');
    if (!toast || !text) return;

    text.textContent = msg;
    toast.classList.remove('hidden', 'translate-y-[-20px]', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');

    setTimeout(() => {
        toast.classList.add('translate-y-[-20px]', 'opacity-0');
        setTimeout(() => toast.classList.add('hidden'), 300);
    }, 3500);
}

// Fitur Geser Horizontal Tombol Kabupaten Admin (Tombol, Drag Mouse, dan Mouse Wheel)
function initAdminPillsScroll() {
    const container = document.getElementById('admin-pills-container');
    if (!container) return;

    // 1. Mouse wheel horizontal scroll
    container.addEventListener('wheel', (e) => {
        if (e.deltaY !== 0) {
            e.preventDefault();
            container.scrollBy({ left: e.deltaY * 1.5, behavior: 'smooth' });
        }
    }, { passive: false });

    // 2. Drag-to-scroll dengan klik & tahan mouse
    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;

    container.addEventListener('mousedown', (e) => {
        isDown = true;
        container.classList.add('cursor-grabbing');
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
    });

    container.addEventListener('mouseleave', () => {
        isDown = false;
        container.classList.remove('cursor-grabbing');
    });

    container.addEventListener('mouseup', () => {
        isDown = false;
        container.classList.remove('cursor-grabbing');
    });

    container.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - container.offsetLeft;
        const walk = (x - startX) * 1.5;
        container.scrollLeft = scrollLeft - walk;
    });

    // Otomatis geser tombol aktif ke tengah
    const activePill = container.querySelector('.quick-kab-pill.active');
    if (activePill) {
        activePill.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }
}

function scrollAdminPills(distance) {
    const container = document.getElementById('admin-pills-container');
    if (container) {
        container.scrollBy({ left: distance, behavior: 'smooth' });
    }
}
</script>
@endpush
