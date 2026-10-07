@extends('layouts.publik')

@section('title', 'Peta Zona Kerawanan')

@push('styles')
<style>
    #peta-zona { height: calc(100vh - 12rem); min-height: 520px; border-radius: 1rem; z-index: 10; }
    .legend-color { width: 14px; height: 14px; border-radius: 4px; display: inline-block; }
    /* Leaflet popup styling enhancement */
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
    <section class="mx-auto max-w-7xl px-4 pt-10 pb-6 sm:px-6 lg:px-8">
        <span class="inline-block text-xs font-semibold text-primary-400 uppercase tracking-widest mb-2">Monitoring Geografis</span>
        <h1 class="text-3xl sm:text-4xl font-bold text-white">Peta Zona Kerawanan</h1>
        <p class="mt-2 text-surface-400 max-w-2xl">Visualisasi persebaran zona kerawanan narkotika di wilayah Sulawesi Tengah lengkap dengan batas wilayah administratif dan titik sebaran.</p>
    </section>

    {{-- Legend + Map --}}
    <section class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
            {{-- Legend --}}
            <div class="flex flex-wrap gap-3">
                <div class="flex items-center gap-2 rounded-lg border border-white/5 bg-surface-900/60 px-3.5 py-2">
                    <span class="legend-color bg-red-500 shadow-sm shadow-red-500/50"></span>
                    <span class="text-xs sm:text-sm text-surface-200 font-medium">Merah — Rawan Tinggi</span>
                </div>
                <div class="flex items-center gap-2 rounded-lg border border-white/5 bg-surface-900/60 px-3.5 py-2">
                    <span class="legend-color bg-amber-500 shadow-sm shadow-amber-500/50"></span>
                    <span class="text-xs sm:text-sm text-surface-200 font-medium">Kuning — Rawan Sedang</span>
                </div>
                <div class="flex items-center gap-2 rounded-lg border border-white/5 bg-surface-900/60 px-3.5 py-2">
                    <span class="legend-color bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                    <span class="text-xs sm:text-sm text-surface-200 font-medium">Hijau — Rawan Rendah</span>
                </div>
            </div>
            
            {{-- Filter --}}
            <div class="flex items-center gap-2">
                <label for="filter-status" class="text-xs text-surface-400 font-medium hidden sm:inline">Filter:</label>
                <select id="filter-status" class="rounded-xl bg-surface-900 border border-white/10 px-4 py-2 text-sm text-white focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition outline-none shadow-sm cursor-pointer">
                    <option value="">Semua Zona</option>
                    <option value="merah">Hanya Rawan Tinggi (Merah)</option>
                    <option value="kuning">Hanya Rawan Sedang (Kuning)</option>
                    <option value="hijau">Hanya Rawan Rendah (Hijau)</option>
                </select>
            </div>
        </div>

        {{-- Map Container --}}
        <div class="rounded-2xl border border-white/10 bg-surface-900/80 p-2 shadow-2xl relative">
            <div id="peta-zona"></div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Inisialisasi peta Leaflet — fokus di wilayah Sulawesi Tengah
    const map = L.map('peta-zona', {
        zoomControl: true,
        scrollWheelZoom: true,
    }).setView([-1.0, 120.5], 7);

    // 2. Definisi Layer Peta (OpenStreetMap Standar lengkap batas, Topografi, Satelit)
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors',
        maxZoom: 19,
    });

    const esriTopo = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community',
        maxZoom: 18,
    });

    const satelliteLayer = L.layerGroup([
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            maxZoom: 18,
        }),
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Batas &copy; Esri',
            maxZoom: 18,
        })
    ]);

    // Default gunakan OpenStreetMap yang jelas perbatasan & kotanya
    osmLayer.addTo(map);

    // Tambahkan kontrol pilihan layer peta di pojok kanan atas
    const baseLayers = {
        "🗺️ OpenStreetMap (Lengkap Perbatasan)": osmLayer,
        "⛰️ Topografi Detail": esriTopo,
        "🛰️ Satelit + Batas Wilayah": satelliteLayer,
    };
    L.control.layers(baseLayers, null, { position: 'topright' }).addTo(map);

    // Pastikan ukuran peta terhitung tepat jika ada transisi rendering
    setTimeout(() => {
        map.invalidateSize();
    }, 250);

    // Warna berdasarkan status zona
    const statusColors = {
        'merah': '#ef4444',
        'kuning': '#f59e0b',
        'hijau': '#10b981',
    };

    // Load data GeoJSON dari endpoint
    let geoJsonLayer;

    function loadDataPeta(status = '') {
        const url = `{{ route("peta.geojson") }}${status ? '?status=' + status : ''}`;
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
                            weight: 2,
                            opacity: 0.95,
                            fillOpacity: 0.55
                        };
                    },
                    pointToLayer: function(feature, latlng) {
                        const color = statusColors[feature.properties.status_zona] || '#3b82f6';
                        const radius = Math.max(10, Math.min(26, 10 + ((feature.properties.jumlah_kasus || 0) / 4)));
                        return L.circleMarker(latlng, {
                            radius: radius,
                            fillColor: color,
                            color: '#ffffff',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.85,
                        });
                    },
                    onEachFeature: function(feature, layer) {
                        const p = feature.properties;
                        const statusLabel = {
                            'merah': '<span style="color:#ef4444;font-weight:700">🔴 MERAH — Rawan Tinggi</span>',
                            'kuning': '<span style="color:#f59e0b;font-weight:700">🟡 KUNING — Rawan Sedang</span>',
                            'hijau': '<span style="color:#10b981;font-weight:700">🟢 HIJAU — Rawan Rendah</span>',
                        };

                        // Hover tooltip
                        layer.bindTooltip(`<strong>${p.nama_wilayah}</strong>`, {
                            sticky: true,
                            direction: 'top',
                            className: 'bg-surface-900 text-white text-xs border border-white/20 rounded px-2 py-1 shadow-lg'
                        });

                        // Hover effect
                        layer.on({
                            mouseover: function(e) {
                                const l = e.target;
                                l.setStyle({
                                    weight: 3.5,
                                    color: '#38bdf8',
                                    fillOpacity: 0.8
                                });
                                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                    l.bringToFront();
                                }
                            },
                            mouseout: function(e) {
                                geoJsonLayer.resetStyle(e.target);
                            }
                        });

                        // Popup detail
                        layer.bindPopup(`
                            <div style="font-family:Inter,sans-serif;min-width:220px;padding:4px 2px">
                                <h3 style="font-size:15px;font-weight:700;margin:0 0 6px;color:#f8fafc;border-bottom:1px solid rgba(255,255,255,0.1);padding-bottom:5px">
                                    ${p.nama_wilayah}
                                </h3>
                                <div style="margin-bottom:8px;font-size:13px">
                                    ${statusLabel[p.status_zona] || p.status_zona}
                                </div>
                                <div style="font-size:12px;color:#cbd5e1;margin-bottom:4px">
                                    <strong style="color:#fff">Jumlah Kasus:</strong> ${p.jumlah_kasus ?? 0} Kasus
                                </div>
                                <div style="font-size:12px;color:#94a3b8;line-height:1.4">
                                    ${p.deskripsi || '-'}
                                </div>
                            </div>
                        `);
                    }
                }).addTo(map);

                if (geoJsonLayer.getBounds().isValid()) {
                    map.fitBounds(geoJsonLayer.getBounds(), { padding: [20, 20] });
                }
            })
            .catch(err => console.error('Gagal memuat data peta:', err));
    }

    // Load data awal
    loadDataPeta();

    // Event listener untuk filter dropdown
    const filterEl = document.getElementById('filter-status');
    if (filterEl) {
        filterEl.addEventListener('change', function() {
            loadDataPeta(this.value);
        });
    }
});
</script>
@endpush
