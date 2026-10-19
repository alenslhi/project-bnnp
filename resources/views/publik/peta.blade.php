@extends('layouts.publik')

@section('title', 'Peta Zona Kerawanan')

@push('styles')
<style>
    #peta-zona { height: calc(100vh - 13rem); min-height: 540px; border-radius: 1rem; z-index: 10; }
    .legend-color { width: 14px; height: 14px; border-radius: 4px; display: inline-block; }
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
</style>
@endpush

@section('content')

    {{-- Header --}}
    <section class="mx-auto max-w-7xl px-4 pt-8 pb-3 sm:px-6 lg:px-8">
        <div>
            <span class="inline-block text-xs font-bold text-primary-600 dark:text-primary-400 uppercase tracking-widest mb-1">SKENA • Monitoring Geografis BNNP Sulawesi Tengah</span>
            <h1 class="text-3xl sm:text-4xl font-black text-surface-900 dark:text-white tracking-tight">Peta Zona Kerawanan Narkotika</h1>
            <p class="mt-1 text-surface-600 dark:text-surface-400 text-sm max-w-3xl">
                Visualisasi interaktif batas geografis zona kerawanan narkotika se-Sulawesi Tengah melalui sistem SKENA (Sistem Informasi Kumpulan Edukasi Narkotika).
            </p>
        </div>
    </section>

    {{-- Unified Control Panel (Toolbar Filter Rapi & Kompak) --}}
    <section class="mx-auto max-w-7xl px-4 pb-3 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/80 p-3.5 sm:p-4 backdrop-blur-xl shadow-sm space-y-3">
            
            {{-- Baris 1: Status Wilayah Aktif & Filter Kerawanan --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-surface-100 dark:border-white/10">
                
                {{-- Kiri: Wilayah Info --}}
                <div class="flex items-center gap-2.5 flex-wrap">
                    <div id="status-icon-box" class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex items-center justify-center border border-primary-200 dark:border-primary-500/30 shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs text-surface-500 dark:text-surface-400 font-medium">Wilayah:</span>
                        <h3 id="current-view-title" class="text-sm sm:text-base font-bold text-surface-900 dark:text-white">Seluruh Sulawesi Tengah</h3>
                        <span id="current-view-badge" class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-50 dark:bg-primary-600/25 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-500/30 font-mono">
                            167 Kecamatan
                        </span>
                        <span id="current-view-status" class="hidden px-2.5 py-0.5 rounded-full text-[11px] font-semibold">
                            <!-- Status badge dinamis -->
                        </span>
                    </div>
                </div>

                {{-- Kanan: Ringkasan Hitungan & Filter Status --}}
                <div class="flex items-center gap-2 flex-wrap">
                    {{-- Mini Counter Status --}}
                    <div class="flex items-center gap-2 text-xs font-semibold bg-surface-100 dark:bg-surface-950/80 px-2.5 py-1.5 rounded-xl border border-surface-200 dark:border-white/10">
                        <span class="text-danger-600 dark:text-red-400 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span> <strong id="stat-m" class="font-bold">0</strong></span>
                        <span class="text-surface-300 dark:text-white/20">•</span>
                        <span class="text-amber-600 dark:text-amber-400 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span> <strong id="stat-k" class="font-bold">0</strong></span>
                        <span class="text-surface-300 dark:text-white/20">•</span>
                        <span class="text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> <strong id="stat-h" class="font-bold">0</strong></span>
                    </div>

                    {{-- Dropdown Filter Status Warna --}}
                    <select id="filter-status" onchange="onStatusChange(this.value)" class="rounded-xl bg-surface-50 dark:bg-surface-950 border border-surface-300 dark:border-white/10 px-3 py-1.5 text-xs text-surface-900 dark:text-white focus:border-primary-500 outline-none transition cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="merah">Rawan Tinggi (Merah)</option>
                        <option value="kuning">Rawan Sedang (Kuning)</option>
                        <option value="hijau">Rawan Rendah (Hijau)</option>
                    </select>

                    <button type="button" id="btn-reset-filter" onclick="selectQuickKabupaten('')" class="hidden px-3 py-1.5 rounded-xl border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-white/5 hover:bg-surface-200 dark:hover:bg-white/15 text-xs text-surface-700 dark:text-surface-200 hover:text-surface-900 dark:hover:text-white font-medium transition flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Reset Sulteng</span>
                    </button>
                </div>
            </div>

            {{-- Baris 2: Tombol Pilihan Wilayah Kabupaten (Scrollable Horizontal) --}}
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-surface-500 dark:text-surface-400 shrink-0 hidden md:inline">
                    Pilih Wilayah:
                </span>
                
                {{-- Tombol Geser Kiri --}}
                <button type="button" 
                        onclick="scrollKabupatenPills(-240)" 
                        aria-label="Geser ke kiri"
                        title="Geser ke kiri"
                        class="shrink-0 w-7 h-7 rounded-lg border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-surface-950/90 hover:bg-surface-200 dark:hover:bg-white/15 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white flex items-center justify-center text-sm font-bold transition shadow-xs">
                    ‹
                </button>

                {{-- Scrollable Container --}}
                <div id="kabupaten-pills-container" 
                     class="flex items-center gap-1.5 overflow-x-auto pb-1 max-w-full scrollbar-none flex-nowrap py-0.5 w-full select-none cursor-grab active:cursor-grabbing">
                    {{-- Seluruh Sulteng --}}
                    <button type="button" 
                            id="quick-kab-all"
                            onclick="selectQuickKabupaten('')" 
                            class="quick-kab-pill active px-3 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition border border-surface-200 dark:border-white/10 bg-surface-50 dark:bg-surface-950 text-surface-700 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:border-surface-300 dark:hover:border-white/20 shrink-0">
                        Seluruh Sulteng (167)
                    </button>

                    {{-- Parigi Moutong --}}
                    <button type="button" 
                            id="quick-kab-72_08"
                            onclick="selectQuickKabupaten('72.08')" 
                            class="quick-kab-pill px-3 py-1.5 rounded-xl text-xs font-medium whitespace-nowrap transition border border-surface-200 dark:border-white/10 bg-surface-50 dark:bg-surface-950 text-surface-700 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:border-surface-300 dark:hover:border-white/20 flex items-center gap-1 shrink-0">
                        <span>Kab. Parigi Moutong</span>
                        <span class="text-[10px] text-surface-400 font-mono">(23)</span>
                    </button>

                    {{-- Kabupaten Lainnya --}}
                    @foreach($kabupatens as $kab)
                        @if($kab->kode_wilayah !== '72.08')
                            @php
                                $kecCount = $kecamatanCounts[$kab->kode_wilayah] ?? null;
                                $codeSlug = str_replace('.', '_', $kab->kode_wilayah);
                            @endphp
                            <button type="button" 
                                    id="quick-kab-{{ $codeSlug }}"
                                    onclick="selectQuickKabupaten('{{ $kab->kode_wilayah }}')" 
                                    class="quick-kab-pill px-3 py-1.5 rounded-xl text-xs font-medium whitespace-nowrap transition border border-surface-200 dark:border-white/10 bg-surface-50 dark:bg-surface-950 text-surface-700 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:border-surface-300 dark:hover:border-white/20 flex items-center gap-1 shrink-0">
                                <span>{{ str_replace(['Kabupaten ', 'Kota '], '', $kab->nama_wilayah) }}</span>
                                @if($kecCount)
                                    <span class="text-[10px] text-surface-400 font-mono">({{ $kecCount }})</span>
                                @endif
                            </button>
                        @endif
                    @endforeach
                </div>

                {{-- Tombol Geser Kanan --}}
                <button type="button" 
                        onclick="scrollKabupatenPills(240)" 
                        aria-label="Geser ke kanan"
                        title="Geser ke kanan"
                        class="shrink-0 w-7 h-7 rounded-lg border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-surface-950/90 hover:bg-surface-200 dark:hover:bg-white/15 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white flex items-center justify-center text-sm font-bold transition shadow-xs">
                    ›
                </button>
            </div>

        </div>
    </section>

    {{-- Legend + Map + List Kecamatan --}}
    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">

        {{-- Legend Peta Ringkas --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-2 px-1">
            <div class="flex flex-wrap items-center gap-2">
                <div class="flex items-center gap-1.5 rounded-lg border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/60 px-2.5 py-1 text-xs shadow-xs">
                    <span class="legend-color bg-red-500"></span>
                    <span class="text-surface-700 dark:text-surface-200 font-medium">Merah — Rawan Tinggi</span>
                </div>
                <div class="flex items-center gap-1.5 rounded-lg border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/60 px-2.5 py-1 text-xs shadow-xs">
                    <span class="legend-color bg-amber-500"></span>
                    <span class="text-surface-700 dark:text-surface-200 font-medium">Kuning — Rawan Sedang</span>
                </div>
                <div class="flex items-center gap-1.5 rounded-lg border border-surface-200 dark:border-white/5 bg-white dark:bg-surface-900/60 px-2.5 py-1 text-xs shadow-xs">
                    <span class="legend-color bg-emerald-500"></span>
                    <span class="text-surface-700 dark:text-surface-200 font-medium">Hijau — Rawan Rendah</span>
                </div>
            </div>

            <div class="text-[11px] text-surface-500 dark:text-surface-400">
                Klik poligon kecamatan di peta atau kartu di bawah untuk detail
            </div>
        </div>

        {{-- Map Container --}}
        <div class="rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/80 p-2 shadow-sm relative">
            <div id="peta-zona"></div>
        </div>

        {{-- Section: Daftar / List Kecamatan di Wilayah Terpilih --}}
        <div id="section-list-kecamatan" class="mt-6 rounded-2xl border border-surface-200 dark:border-white/10 bg-white dark:bg-surface-900/80 p-5 backdrop-blur-xl shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-surface-100 dark:border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex items-center justify-center border border-primary-200 dark:border-primary-500/30">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-surface-900 dark:text-white flex items-center gap-2">
                            <span id="list-title">Daftar Kecamatan se-Sulawesi Tengah</span>
                            <span id="list-count-badge" class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-50 dark:bg-primary-600/30 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-500/30 font-mono">
                                167 Kecamatan
                            </span>
                        </h3>
                        <p id="list-subtitle" class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">
                            Klik nama kecamatan di bawah untuk menyorot poligon & membuka detailnya di peta Leaflet.
                        </p>
                    </div>
                </div>

                {{-- Filter Kabupaten & Quick Search di List Kecamatan --}}
                <div class="flex items-center gap-2 flex-wrap">
                    {{-- Dropdown Filter Kabupaten / Kota --}}
                    <div class="relative">
                        <select id="filter-kabupaten-dropdown" 
                                onchange="onSelectKabupatenFilter(this.value)" 
                                class="rounded-xl bg-surface-50 dark:bg-surface-950 border border-surface-300 dark:border-white/15 px-3 py-2 text-xs text-surface-900 dark:text-white font-medium focus:border-primary-500 outline-none transition cursor-pointer">
                            <option value="">Semua Wilayah (Seluruh Sulteng)</option>
                            @foreach($kabupatens as $kab)
                                @php
                                    $kCount = $kecamatanCounts[$kab->kode_wilayah] ?? 0;
                                @endphp
                                <option value="{{ $kab->kode_wilayah }}">
                                    {{ $kab->nama_wilayah }} ({{ $kCount }} Kec)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Quick Search di List Kecamatan --}}
                    <div class="relative">
                        <input type="text" 
                                id="search-kecamatan-input" 
                                oninput="onSearchKecamatan(this.value)" 
                                placeholder="Cari kecamatan..." 
                                class="w-36 sm:w-48 rounded-xl bg-surface-50 dark:bg-surface-950 border border-surface-300 dark:border-white/10 px-3.5 py-2 text-xs text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:border-primary-500 outline-none transition">
                    </div>
                    <button type="button" 
                            onclick="resetAllKecamatanFilters()" 
                            class="px-2.5 py-2 rounded-xl border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-white/5 hover:bg-surface-200 dark:hover:bg-white/10 text-xs text-surface-700 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white transition font-medium">
                        Reset
                    </button>
                </div>
            </div>

            {{-- Grid / List Cards Kecamatan (Maksimal 6 Kartu per Halaman) --}}
            <div id="grid-list-kecamatan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 mt-4 min-h-[160px]">
                <!-- Konten 6 kartu digenerate dinamis lewat JavaScript -->
            </div>

            {{-- Filter Halaman / Pagination --}}
            <div id="pagination-wrapper" class="mt-5 pt-4 border-t border-surface-100 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div id="pagination-info" class="text-surface-500 dark:text-surface-400">
                    Menampilkan <strong id="page-start" class="text-surface-900 dark:text-white">1</strong> - <strong id="page-end" class="text-surface-900 dark:text-white">6</strong> dari <strong id="page-total" class="text-surface-900 dark:text-white">167</strong> kecamatan
                </div>
                <div id="pagination-buttons" class="flex items-center gap-1.5 flex-wrap justify-center">
                    <!-- Tombol Prev, 1, 2, 3, 4, 5, Next -->
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
<style>
    /* Quick Filter Pills */
    .quick-kab-pill.active {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border-color: #60a5fa !important;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35) !important;
        font-weight: 700 !important;
    }
    .quick-kab-pill:not(.active):hover {
        transform: translateY(-1px);
    }

    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .kecamatan-card {
        transition: all 0.2s ease;
    }
    .kecamatan-card:hover {
        transform: translateY(-2px);
    }
    .kecamatan-card.highlighted {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.4) !important;
        background-color: rgba(37, 99, 235, 0.08) !important;
    }
</style>

<script>
// Peta sekarang selalu beroperasi di tingkat kecamatan
const currentTingkat = 'kecamatan';
let currentParentKode = '';
let currentStatus = '';

let map;
let geoJsonLayer;
let allLoadedKecamatans = [];
let currentFilteredKecamatans = [];
const layerMapByZonaId = {};

// Konfigurasi pagination daftar kecamatan (maksimal 6 kartu per tampilan)
const ITEMS_PER_PAGE = 6;
let currentPage = 1;

const statusColors = {
    'merah': '#ef4444',
    'kuning': '#f59e0b',
    'hijau': '#10b981',
};

// Metadata seluruh Kabupaten / Kota untuk instant inspector
const kabMeta = {
@foreach($kabupatens as $kab)
    '{{ $kab->kode_wilayah }}': {
        nama: @json($kab->nama_wilayah),
        status: @json($kab->status_zona),
        kasus: {{ $kab->jumlah_kasus ?? 0 }},
        deskripsi: @json($kab->deskripsi ?? ''),
        kec_count: {{ $kecamatanCounts[$kab->kode_wilayah] ?? 0 }}
    },
@endforeach
};

document.addEventListener('DOMContentLoaded', function() {
    // 1. Inisialisasi peta Leaflet — fokus di wilayah Sulawesi Tengah
    map = L.map('peta-zona', {
        zoomControl: true,
        scrollWheelZoom: true,
    }).setView([-1.0, 120.5], 7);

    // 2. Definisi Layer Peta
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors',
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

    const baseLayers = {
        "OpenStreetMap (Lengkap Perbatasan)": osmLayer,
        "Topografi Detail": esriTopo,
        "Satelit + Batas Wilayah": satelliteLayer,
    };
    L.control.layers(baseLayers, null, { position: 'topright' }).addTo(map);

    setTimeout(() => { map.invalidateSize(); }, 250);

    // 3. Inisialisasi scroll horizontal tombol kabupaten
    initPillsScroll();

    // 4. Load data awal per-kecamatan se-Sulteng
    loadDataPeta();
});

function loadDataPeta() {
    let url = `{{ route("peta.geojson") }}?tingkat=kecamatan`;
    if (currentStatus) url += `&status=${currentStatus}`;
    if (currentParentKode) url += `&parent_kode=${currentParentKode}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            if (geoJsonLayer) {
                map.removeLayer(geoJsonLayer);
            }
            for (let id in layerMapByZonaId) delete layerMapByZonaId[id];

            allLoadedKecamatans = (data.features || []).map(f => f.properties);

            geoJsonLayer = L.geoJSON(data, {
                style: function(feature) {
                    const color = statusColors[feature.properties.status_zona] || '#3b82f6';
                    return {
                        fillColor: color,
                        color: '#ffffff',
                        weight: 2,
                        opacity: 0.95,
                        fillOpacity: 0.6
                    };
                },
                onEachFeature: function(feature, layer) {
                    const p = feature.properties;
                    layerMapByZonaId[p.id] = layer;

                    const statusLabel = {
                        'merah': '<span style="color:#ef4444;font-weight:700;display:inline-flex;align-items:center;gap:4px;"><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ef4444;"></span> MERAH — Rawan Tinggi</span>',
                        'kuning': '<span style="color:#f59e0b;font-weight:700;display:inline-flex;align-items:center;gap:4px;"><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#f59e0b;"></span> KUNING — Rawan Sedang</span>',
                        'hijau': '<span style="color:#10b981;font-weight:700;display:inline-flex;align-items:center;gap:4px;"><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#10b981;"></span> HIJAU — Rawan Rendah</span>',
                    };

                    // Tooltip saat mouse hover
                    layer.bindTooltip(`
                        <div>
                            <strong>${p.nama_wilayah}</strong>
                            <div style="font-size:11px;opacity:0.85">${p.parent_nama || 'Kecamatan'} • ${p.status_zona.toUpperCase()}</div>
                        </div>
                    `, {
                        sticky: true,
                        direction: 'top',
                        className: 'bg-surface-900 text-white text-xs border border-white/20 rounded px-2.5 py-1.5 shadow-lg'
                    });

                    // Hover effects
                    layer.on({
                        mouseover: function(e) {
                            const l = e.target;
                            l.setStyle({
                                weight: 3.5,
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
                            highlightCardInList(p.id);
                        }
                    });

                    // Popup detail kecamatan
                    layer.bindPopup(`
                        <div style="font-family:Inter,sans-serif;min-width:240px;padding:4px 2px">
                            <span style="display:inline-block;font-size:10px;text-transform:uppercase;color:#38bdf8;font-weight:700;margin-bottom:2px">
                                Kecamatan • ${p.parent_nama || 'Sulawesi Tengah'}
                            </span>
                            <h3 style="font-size:16px;font-weight:700;margin:0 0 6px;color:#f8fafc">
                                ${p.nama_wilayah}
                            </h3>
                            <div style="margin-bottom:8px;font-size:13px">
                                ${statusLabel[p.status_zona] || p.status_zona}
                            </div>
                            <div style="font-size:12px;color:#cbd5e1;margin-bottom:4px">
                                <strong style="color:#fff">Jumlah Kasus:</strong> ${p.jumlah_kasus ?? 0} Kasus
                            </div>
                            <div style="font-size:12px;color:#94a3b8;line-height:1.4;margin-bottom:8px">
                                ${p.deskripsi || '-'}
                            </div>
                            <button type="button" onclick="highlightCardInList(${p.id})"
                                    style="width:100%;background:#0284c7;color:#fff;border:none;border-radius:8px;padding:6px 10px;font-size:11px;font-weight:700;cursor:pointer">
                                Lihat di Daftar Kecamatan
                            </button>
                        </div>
                    `);
                }
            }).addTo(map);

            if (geoJsonLayer.getBounds().isValid()) {
                map.fitBounds(geoJsonLayer.getBounds(), { padding: [25, 25], maxZoom: 13, animate: true });
            }

            updateBannerStats();
            renderKecamatanList(allLoadedKecamatans);
        })
        .catch(err => console.error('Gagal memuat data peta:', err));
}

// Handler Pilihan Cepat Kabupaten
function selectQuickKabupaten(kodeWilayah) {
    currentParentKode = kodeWilayah;

    document.querySelectorAll('.quick-kab-pill').forEach(btn => btn.classList.remove('active'));
    if (!kodeWilayah) {
        const allBtn = document.getElementById('quick-kab-all');
        if (allBtn) allBtn.classList.add('active');
    } else {
        const slug = kodeWilayah.replace('.', '_');
        const activeBtn = document.getElementById(`quick-kab-${slug}`);
        if (activeBtn) activeBtn.classList.add('active');
    }

    const titleEl = document.getElementById('current-view-title');
    const badgeEl = document.getElementById('current-view-badge');
    const statusBadge = document.getElementById('current-view-status');
    const iconBox = document.getElementById('status-icon-box');
    const resetBtn = document.getElementById('btn-reset-filter');

    if (!kodeWilayah) {
        if (titleEl) titleEl.textContent = 'Seluruh Sulawesi Tengah';
        if (badgeEl) badgeEl.textContent = '167 Kecamatan';
        if (statusBadge) statusBadge.classList.add('hidden');
        if (resetBtn) resetBtn.classList.add('hidden');
        if (iconBox) {
            iconBox.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
            iconBox.className = 'w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex items-center justify-center border border-primary-200 dark:border-primary-500/30 shrink-0';
        }
    } else {
        const meta = kabMeta[kodeWilayah];
        if (meta) {
            if (titleEl) titleEl.textContent = meta.nama;
            if (badgeEl) badgeEl.textContent = `${meta.kec_count} Kecamatan`;
            if (resetBtn) resetBtn.classList.remove('hidden');

            if (iconBox) {
                iconBox.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
                iconBox.className = 'w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex items-center justify-center border border-primary-200 dark:border-primary-500/30 shrink-0';
            }

            if (statusBadge) {
                statusBadge.classList.remove('hidden');
                if (meta.status === 'merah') {
                    statusBadge.className = 'px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-500/20 text-red-600 dark:text-red-400 border border-red-500/30 inline-flex items-center gap-1.5';
                    statusBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span> Rawan Tinggi (${meta.kasus} Kasus)`;
                } else if (meta.status === 'kuning') {
                    statusBadge.className = 'px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 inline-flex items-center gap-1.5';
                    statusBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span> Rawan Sedang (${meta.kasus} Kasus)`;
                } else {
                    statusBadge.className = 'px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 inline-flex items-center gap-1.5';
                    statusBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Rawan Rendah (${meta.kasus} Kasus)`;
                }
            }
        }
    }

    const kabDropdown = document.getElementById('filter-kabupaten-dropdown');
    if (kabDropdown) {
        kabDropdown.value = kodeWilayah || '';
    }

    const searchInput = document.getElementById('search-kecamatan-input');
    if (searchInput) searchInput.value = '';

    loadDataPeta();
}

function updateBannerStats() {
    const statM = document.getElementById('stat-m');
    const statK = document.getElementById('stat-k');
    const statH = document.getElementById('stat-h');

    if (statM && statK && statH) {
        const countM = allLoadedKecamatans.filter(k => k.status_zona === 'merah').length;
        const countK = allLoadedKecamatans.filter(k => k.status_zona === 'kuning').length;
        const countH = allLoadedKecamatans.filter(k => k.status_zona === 'hijau').length;

        statM.textContent = countM;
        statK.textContent = countK;
        statH.textContent = countH;
    }
}

// Render Grid List Kecamatan dengan Pagination
function renderKecamatanList(items, page = 1) {
    currentFilteredKecamatans = items;
    currentPage = page;
    renderCurrentPage();
}

function renderCurrentPage() {
    const grid = document.getElementById('grid-list-kecamatan');
    const titleEl = document.getElementById('list-title');
    const countBadge = document.getElementById('list-count-badge');
    const paginationWrapper = document.getElementById('pagination-wrapper');

    if (!grid) return;

    if (currentParentKode && kabMeta[currentParentKode]) {
        titleEl.textContent = `Daftar Kecamatan di ${kabMeta[currentParentKode].nama}`;
    } else {
        titleEl.textContent = `Daftar Kecamatan se-Sulawesi Tengah`;
    }

    const totalItems = currentFilteredKecamatans.length;
    if (countBadge) countBadge.textContent = `${totalItems} Kecamatan`;

    if (totalItems === 0) {
        grid.innerHTML = `
            <div class="col-span-full py-10 text-center text-surface-500 dark:text-surface-400 text-sm">
                Tidak ada kecamatan yang sesuai dengan kriteria filter saat ini.
            </div>
        `;
        if (paginationWrapper) paginationWrapper.classList.add('hidden');
        return;
    }

    if (paginationWrapper) paginationWrapper.classList.remove('hidden');

    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE) || 1;
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
    const pageItems = currentFilteredKecamatans.slice(startIndex, startIndex + ITEMS_PER_PAGE);

    const html = pageItems.map(k => {
        let statusBadge = '';
        let borderClass = 'border-surface-200 dark:border-white/10';
        if (k.status_zona === 'merah') {
            statusBadge = '<span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-red-600 dark:bg-red-500/20 dark:text-red-400 border border-red-200 dark:border-red-500/30"><span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span> MERAH</span>';
            borderClass = 'border-red-200 dark:border-red-500/20 hover:border-red-400';
        } else if (k.status_zona === 'kuning') {
            statusBadge = '<span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span> KUNING</span>';
            borderClass = 'border-amber-200 dark:border-amber-500/20 hover:border-amber-400';
        } else {
            statusBadge = '<span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> HIJAU</span>';
            borderClass = 'border-emerald-200 dark:border-emerald-500/20 hover:border-emerald-400';
        }

        return `
            <div id="card-kec-${k.id}" 
                 onclick="focusKecamatan(${k.id})" 
                 onmouseenter="highlightPolygon(${k.id}, true)"
                 onmouseleave="highlightPolygon(${k.id}, false)"
                 class="kecamatan-card group relative rounded-xl border ${borderClass} bg-surface-50 dark:bg-surface-950/70 p-4 hover:bg-white dark:hover:bg-surface-950 transition cursor-pointer flex flex-col justify-between gap-3 shadow-xs">
                <div>
                    <div class="flex items-start justify-between gap-2 mb-1.5">
                        <span class="text-[10px] uppercase font-bold text-surface-500 dark:text-surface-400 tracking-wider truncate">
                            ${k.parent_nama || 'Sulawesi Tengah'}
                        </span>
                        ${statusBadge}
                    </div>
                    <h4 class="text-sm font-bold text-surface-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition line-clamp-1">
                        ${k.nama_wilayah}
                    </h4>
                </div>

                <div class="flex items-center justify-between text-xs text-surface-500 dark:text-surface-400 pt-2.5 border-t border-surface-200 dark:border-white/5">
                    <span>Kasus: <strong class="text-surface-900 dark:text-white font-mono font-bold">${k.jumlah_kasus ?? 0}</strong></span>
                    <span class="text-primary-600 dark:text-primary-400 text-[11px] font-semibold group-hover:translate-x-0.5 transition flex items-center gap-1">
                        <span>Sorot di Peta</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                </div>
            </div>
        `;
    }).join('');

    grid.innerHTML = html;
    renderPagination(totalItems, currentPage);
}

// Render Kontrol Halaman (Pagination: 1, 2, 3, 4, 5...)
function renderPagination(totalItems, activePage) {
    const buttonsContainer = document.getElementById('pagination-buttons');
    const pageStartEl = document.getElementById('page-start');
    const pageEndEl = document.getElementById('page-end');
    const pageTotalEl = document.getElementById('page-total');

    if (!buttonsContainer) return;

    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE) || 1;
    const start = (activePage - 1) * ITEMS_PER_PAGE + 1;
    const end = Math.min(activePage * ITEMS_PER_PAGE, totalItems);

    if (pageStartEl) pageStartEl.textContent = start;
    if (pageEndEl) pageEndEl.textContent = end;
    if (pageTotalEl) pageTotalEl.textContent = totalItems;

    if (totalPages <= 1) {
        buttonsContainer.innerHTML = '';
        return;
    }

    let buttonsHtml = '';

    // Tombol Prev
    const prevDisabled = activePage === 1 ? 'disabled opacity-30 cursor-not-allowed' : 'hover:bg-surface-200 dark:hover:bg-white/10 text-surface-700 dark:text-white cursor-pointer';
    buttonsHtml += `
        <button type="button" 
                onclick="goToPage(${activePage - 1})" 
                ${activePage === 1 ? 'disabled' : ''}
                class="px-2.5 py-1.5 rounded-lg border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-surface-950 text-surface-700 dark:text-surface-300 ${prevDisabled} transition font-semibold text-xs flex items-center gap-1">
            ◀ Prev
        </button>
    `;

    // Deretan Nomor Halaman (1, 2, 3, 4, 5, ...)
    const pages = [];
    const maxVisibleButtons = 7;

    if (totalPages <= maxVisibleButtons) {
        for (let i = 1; i <= totalPages; i++) pages.push(i);
    } else {
        pages.push(1);
        if (activePage > 3) pages.push('...');

        const startPage = Math.max(2, activePage - 1);
        const endPage = Math.min(totalPages - 1, activePage + 1);

        for (let i = startPage; i <= endPage; i++) {
            if (!pages.includes(i)) pages.push(i);
        }

        if (activePage < totalPages - 2) pages.push('...');
        if (!pages.includes(totalPages)) pages.push(totalPages);
    }

    pages.forEach(p => {
        if (p === '...') {
            buttonsHtml += `<span class="px-2 py-1 text-surface-400 font-bold select-none text-xs">...</span>`;
        } else {
            const isActive = p === activePage;
            const btnClass = isActive 
                ? 'bg-primary-600 text-white border-primary-500 font-bold shadow-sm shadow-primary-500/30 ring-1 ring-primary-400' 
                : 'bg-surface-100 dark:bg-surface-950 text-surface-700 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:bg-surface-200 dark:hover:bg-white/10 border-surface-200 dark:border-white/10 font-medium';
            buttonsHtml += `
                <button type="button" 
                        onclick="goToPage(${p})" 
                        class="min-w-[32px] h-8 px-2 rounded-lg border text-xs ${btnClass} transition cursor-pointer">
                    ${p}
                </button>
            `;
        }
    });

    // Tombol Next
    const nextDisabled = activePage === totalPages ? 'disabled opacity-30 cursor-not-allowed' : 'hover:bg-surface-200 dark:hover:bg-white/10 text-surface-700 dark:text-white cursor-pointer';
    buttonsHtml += `
        <button type="button" 
                onclick="goToPage(${activePage + 1})" 
                ${activePage === totalPages ? 'disabled' : ''}
                class="px-2.5 py-1.5 rounded-lg border border-surface-200 dark:border-white/10 bg-surface-100 dark:bg-surface-950 text-surface-700 dark:text-surface-300 ${nextDisabled} transition font-semibold text-xs flex items-center gap-1">
            Next ▶
        </button>
    `;

    buttonsContainer.innerHTML = buttonsHtml;
}

// Pindah Halaman
function goToPage(page, shouldScroll = true) {
    const totalPages = Math.ceil(currentFilteredKecamatans.length / ITEMS_PER_PAGE);
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderCurrentPage();

    if (shouldScroll) {
        const section = document.getElementById('section-list-kecamatan');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
}

// Sorot dan fokus ke polygon di Leaflet saat card kecamatan diklik
function focusKecamatan(zonaId) {
    const layer = layerMapByZonaId[zonaId];
    if (layer) {
        if (layer.getBounds) {
            map.fitBounds(layer.getBounds(), { padding: [50, 50], maxZoom: 14, animate: true });
        } else if (layer.getLatLng) {
            map.setView(layer.getLatLng(), 13, { animate: true });
        }

        setTimeout(() => {
            layer.openPopup();
            layer.setStyle({ weight: 4.5, color: '#38bdf8', fillOpacity: 0.9 });
            setTimeout(() => {
                if (geoJsonLayer) geoJsonLayer.resetStyle(layer);
            }, 2500);
        }, 200);

        if (window.innerWidth < 768) {
            const mapEl = document.getElementById('peta-zona');
            if (mapEl) mapEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

// Hover efek dari card ke polygon
function highlightPolygon(zonaId, isHover) {
    const layer = layerMapByZonaId[zonaId];
    if (layer && geoJsonLayer) {
        if (isHover) {
            layer.setStyle({ weight: 3.5, color: '#38bdf8', fillOpacity: 0.85 });
            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }
        } else {
            geoJsonLayer.resetStyle(layer);
        }
    }
}

// Sorot card di list saat polygon di peta diklik
function highlightCardInList(zonaId) {
    const index = currentFilteredKecamatans.findIndex(k => k.id == zonaId);
    if (index !== -1) {
        const targetPage = Math.floor(index / ITEMS_PER_PAGE) + 1;
        if (targetPage !== currentPage) {
            goToPage(targetPage, false);
        }
    }

    setTimeout(() => {
        const card = document.getElementById(`card-kec-${zonaId}`);
        if (card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            card.classList.add('highlighted');
            setTimeout(() => card.classList.remove('highlighted'), 2500);
        }
    }, 150);
}

// Search di list kecamatan
function onSearchKecamatan(query) {
    const q = query.toLowerCase().trim();
    if (!q) {
        renderKecamatanList(allLoadedKecamatans, 1);
        return;
    }

    const filtered = allLoadedKecamatans.filter(k => 
        k.nama_wilayah.toLowerCase().includes(q) || 
        (k.parent_nama && k.parent_nama.toLowerCase().includes(q))
    );
    renderKecamatanList(filtered, 1);
}

function resetSearchKecamatan() {
    const input = document.getElementById('search-kecamatan-input');
    if (input) input.value = '';
    renderKecamatanList(allLoadedKecamatans, 1);
}

function onSelectKabupatenFilter(kodeWilayah) {
    selectQuickKabupaten(kodeWilayah);
}

function resetAllKecamatanFilters() {
    const input = document.getElementById('search-kecamatan-input');
    if (input) input.value = '';
    const dropdown = document.getElementById('filter-kabupaten-dropdown');
    if (dropdown) dropdown.value = '';
    selectQuickKabupaten('');
}

function onParentChange(parentKode) {
    selectQuickKabupaten(parentKode);
}

function onStatusChange(status) {
    currentStatus = status;
    loadDataPeta();
}

function resetToProvince() {
    selectQuickKabupaten('');
}

// Fitur Geser Horizontal Tombol Kabupaten
function initPillsScroll() {
    const container = document.getElementById('kabupaten-pills-container');
    if (!container) return;

    container.addEventListener('wheel', (e) => {
        if (e.deltaY !== 0) {
            e.preventDefault();
            container.scrollBy({ left: e.deltaY * 1.5, behavior: 'smooth' });
        }
    }, { passive: false });

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
}

function scrollKabupatenPills(distance) {
    const container = document.getElementById('kabupaten-pills-container');
    if (container) {
        container.scrollBy({ left: distance, behavior: 'smooth' });
    }
}
</script>
@endpush
