@extends('layouts.publik')

@section('title', 'Peta Zona Kerawanan')

@push('styles')
<style>
    #peta-zona { height: calc(100vh - 12rem); min-height: 500px; border-radius: 1rem; }
    .legend-color { width: 14px; height: 14px; border-radius: 4px; display: inline-block; }
</style>
@endpush

@section('content')

    {{-- Header --}}
    <section class="mx-auto max-w-7xl px-4 pt-10 pb-6 sm:px-6 lg:px-8">
        <span class="inline-block text-xs font-semibold text-primary-400 uppercase tracking-widest mb-2">Monitoring</span>
        <h1 class="text-3xl sm:text-4xl font-bold text-white">Peta Zona Kerawanan</h1>
        <p class="mt-2 text-surface-400 max-w-2xl">Visualisasi persebaran zona kerawanan narkotika di wilayah Sulawesi Tengah berdasarkan data BNNP.</p>
    </section>

    {{-- Legend + Map --}}
    <section class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        {{-- Legend --}}
        <div class="flex flex-wrap gap-4 mb-4">
            <div class="flex items-center gap-2 rounded-lg border border-white/5 bg-surface-900/60 px-4 py-2">
                <span class="legend-color bg-red-500"></span>
                <span class="text-sm text-surface-300">Merah — Rawan Tinggi</span>
            </div>
            <div class="flex items-center gap-2 rounded-lg border border-white/5 bg-surface-900/60 px-4 py-2">
                <span class="legend-color bg-yellow-500"></span>
                <span class="text-sm text-surface-300">Kuning — Rawan Sedang</span>
            </div>
            <div class="flex items-center gap-2 rounded-lg border border-white/5 bg-surface-900/60 px-4 py-2">
                <span class="legend-color bg-emerald-500"></span>
                <span class="text-sm text-surface-300">Hijau — Rawan Rendah</span>
            </div>
        </div>

        {{-- Map Container --}}
        <div class="rounded-2xl border border-white/5 bg-surface-900/60 p-2 overflow-hidden">
            <div id="peta-zona"></div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi peta Leaflet — center di Sulawesi Tengah
    const map = L.map('peta-zona', {
        zoomControl: true,
        scrollWheelZoom: true,
    }).setView([-1.0, 120.5], 7);

    // Tile layer (dark style)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/">CARTO</a>',
        maxZoom: 18,
    }).addTo(map);

    // Warna berdasarkan status zona
    const statusColors = {
        'merah': '#ef4444',
        'kuning': '#f59e0b',
        'hijau': '#10b981',
    };

    // Load data GeoJSON dari endpoint
    fetch('{{ route("peta.geojson") }}')
        .then(res => res.json())
        .then(data => {
            L.geoJSON(data, {
                pointToLayer: function(feature, latlng) {
                    const color = statusColors[feature.properties.status_zona] || '#3b82f6';
                    return L.circleMarker(latlng, {
                        radius: 10 + (feature.properties.jumlah_kasus / 5),
                        fillColor: color,
                        color: color,
                        weight: 2,
                        opacity: 0.9,
                        fillOpacity: 0.35,
                    });
                },
                onEachFeature: function(feature, layer) {
                    const p = feature.properties;
                    const statusLabel = {
                        'merah': '<span style="color:#ef4444;font-weight:700">⬤ MERAH — Rawan Tinggi</span>',
                        'kuning': '<span style="color:#f59e0b;font-weight:700">⬤ KUNING — Rawan Sedang</span>',
                        'hijau': '<span style="color:#10b981;font-weight:700">⬤ HIJAU — Rawan Rendah</span>',
                    };
                    layer.bindPopup(`
                        <div style="font-family:Inter,sans-serif;min-width:200px">
                            <h3 style="font-size:16px;font-weight:700;margin:0 0 8px">${p.nama_wilayah}</h3>
                            <div style="margin-bottom:6px">${statusLabel[p.status_zona]}</div>
                            <div style="font-size:13px;color:#64748b;margin-bottom:4px"><strong>Jumlah Kasus:</strong> ${p.jumlah_kasus}</div>
                            <div style="font-size:12px;color:#94a3b8">${p.deskripsi || '-'}</div>
                        </div>
                    `);
                }
            }).addTo(map);
        });
});
</script>
@endpush
