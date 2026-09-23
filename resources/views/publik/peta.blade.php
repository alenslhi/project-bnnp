@extends('layouts.publik')

@section('title', 'Peta Zona Kerawanan')

@push('styles')
{{-- Mapbox CSS --}}
<link href="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.css" rel="stylesheet">
<style>
    #peta-zona { height: calc(100vh - 12rem); min-height: 500px; border-radius: 1rem; width: 100%; }
    .legend-color { width: 14px; height: 14px; border-radius: 4px; display: inline-block; }
    
    /* Mapbox Popup Dark Theme */
    .mapboxgl-popup-content {
        background-color: #0f172a;
        color: #f8fafc;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        padding: 1rem;
    }
    .mapboxgl-popup-anchor-bottom .mapboxgl-popup-tip { border-top-color: #0f172a; }
    .mapboxgl-popup-anchor-top .mapboxgl-popup-tip { border-bottom-color: #0f172a; }
    .mapboxgl-popup-close-button { color: #94a3b8; padding: 4px 8px; font-size: 16px; }
    .mapboxgl-popup-close-button:hover { background-color: transparent; color: #f8fafc; }
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
        <div class="rounded-2xl border border-white/5 bg-surface-900/60 p-2 overflow-hidden relative">
            <div id="peta-zona"></div>
            @if(!env('MAPBOX_ACCESS_TOKEN'))
            <div class="absolute inset-0 bg-surface-900/80 flex items-center justify-center z-10 flex-col gap-2 p-6 text-center rounded-xl backdrop-blur-sm">
                <svg class="w-12 h-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-xl font-bold text-white">Mapbox Access Token Belum Dikonfigurasi</h3>
                <p class="text-surface-300 max-w-md">Silakan tambahkan <code>MAPBOX_ACCESS_TOKEN=token_anda</code> di dalam file <code>.env</code> Anda untuk menampilkan peta ini.</p>
            </div>
            @endif
        </div>
    </section>

@endsection

@push('scripts')
{{-- Mapbox JS --}}
<script src="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapboxToken = '{{ env("MAPBOX_ACCESS_TOKEN") }}';
    
    if (!mapboxToken) return; // Hentikan eksekusi jika token tidak ada

    mapboxgl.accessToken = mapboxToken;

    const map = new mapboxgl.Map({
        container: 'peta-zona',
        style: 'mapbox://styles/mapbox/dark-v11', // Tampilan gelap modern
        center: [120.5, -1.0], // Longitude, Latitude Sulawesi Tengah
        zoom: 6,
        pitch: 45, // Sudut kemiringan 3D
        bearing: -17.6,
        antialias: true
    });

    // Menambahkan kontrol navigasi (zoom in/out)
    map.addControl(new mapboxgl.NavigationControl(), 'top-right');

    map.on('load', () => {
        // Fetch GeoJSON data dari route Laravel
        fetch('{{ route("peta.geojson") }}')
            .then(response => response.json())
            .then(data => {
                
                // Tambahkan source data GeoJSON
                map.addSource('zona-kerawanan', {
                    type: 'geojson',
                    data: data
                });

                // Layer untuk poligon / area (jika tipe data adalah Polygon)
                map.addLayer({
                    'id': 'zona-polygons',
                    'type': 'fill',
                    'source': 'zona-kerawanan',
                    'paint': {
                        'fill-color': [
                            'match',
                            ['get', 'status_zona'],
                            'merah', '#ef4444',
                            'kuning', '#f59e0b',
                            'hijau', '#10b981',
                            '#3b82f6' // Default color
                        ],
                        'fill-opacity': 0.4
                    },
                    'filter': ['==', '$type', 'Polygon']
                });

                // Layer outline untuk poligon
                map.addLayer({
                    'id': 'zona-polygons-outline',
                    'type': 'line',
                    'source': 'zona-kerawanan',
                    'paint': {
                        'line-color': [
                            'match',
                            ['get', 'status_zona'],
                            'merah', '#ef4444',
                            'kuning', '#f59e0b',
                            'hijau', '#10b981',
                            '#3b82f6'
                        ],
                        'line-width': 2
                    },
                    'filter': ['==', '$type', 'Polygon']
                });

                // Layer titik/points (jika data belum diupdate menjadi polygon)
                map.addLayer({
                    'id': 'zona-points',
                    'type': 'circle',
                    'source': 'zona-kerawanan',
                    'paint': {
                        'circle-radius': [
                            '+', 8, ['/', ['get', 'jumlah_kasus'], 5]
                        ],
                        'circle-color': [
                            'match',
                            ['get', 'status_zona'],
                            'merah', '#ef4444',
                            'kuning', '#f59e0b',
                            'hijau', '#10b981',
                            '#3b82f6'
                        ],
                        'circle-stroke-width': 2,
                        'circle-stroke-color': '#ffffff'
                    },
                    'filter': ['==', '$type', 'Point']
                });

                // Setup interaksi klik untuk Popup
                const popup = new mapboxgl.Popup({
                    closeButton: true,
                    closeOnClick: true,
                    className: 'zona-popup'
                });

                const statusLabel = {
                    'merah': '<span style="color:#ef4444;font-weight:700">⬤ MERAH — Rawan Tinggi</span>',
                    'kuning': '<span style="color:#f59e0b;font-weight:700">⬤ KUNING — Rawan Sedang</span>',
                    'hijau': '<span style="color:#10b981;font-weight:700">⬤ HIJAU — Rawan Rendah</span>',
                };

                // Fungsi click handler yang bisa dipakai di titik maupun poligon
                const clickHandler = (e) => {
                    const properties = e.features[0].properties;
                    const coordinates = e.lngLat;
                    
                    const nama = properties.nama_wilayah;
                    const status = properties.status_zona;
                    const kasus = properties.jumlah_kasus;
                    const deskripsi = properties.deskripsi;

                    const html = `
                        <div style="font-family:Inter,sans-serif;min-width:200px;">
                            <h3 style="font-size:16px;font-weight:700;margin:0 0 8px">${nama}</h3>
                            <div style="margin-bottom:6px">${statusLabel[status] || status}</div>
                            <div style="font-size:13px;color:#cbd5e1;margin-bottom:4px"><strong>Jumlah Kasus:</strong> ${kasus}</div>
                            <div style="font-size:12px;color:#94a3b8;margin-top:8px;line-height:1.4">${deskripsi || '-'}</div>
                        </div>
                    `;

                    popup.setLngLat(coordinates).setHTML(html).addTo(map);
                };

                // Bind klik ke layer poligon
                map.on('click', 'zona-polygons', clickHandler);
                
                // Ubah kursor jadi pointer saat hover poligon
                map.on('mouseenter', 'zona-polygons', () => { map.getCanvas().style.cursor = 'pointer'; });
                map.on('mouseleave', 'zona-polygons', () => { map.getCanvas().style.cursor = ''; });

                // Bind klik ke layer point
                map.on('click', 'zona-points', clickHandler);
                
                // Ubah kursor jadi pointer saat hover point
                map.on('mouseenter', 'zona-points', () => { map.getCanvas().style.cursor = 'pointer'; });
                map.on('mouseleave', 'zona-points', () => { map.getCanvas().style.cursor = ''; });
            });
    });
});
</script>
@endpush
