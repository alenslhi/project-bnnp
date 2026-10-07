@extends('layouts.admin')

@section('title', 'Kelola Zona Kerawanan')
@section('page-title', 'Pengelolaan Peta & Zona Kerawanan')

@push('styles')
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #admin-peta-zona {
        height: 520px;
        border-radius: 1rem;
        z-index: 10;
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
</style>
@endpush

@section('content')
<div class="space-y-6">

    {{-- Toast Notification --}}
    <div id="toast-notif" class="fixed top-6 right-6 z-50 hidden transition-all duration-300 transform translate-y-[-20px] opacity-0">
        <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl bg-emerald-500/90 text-white font-medium shadow-2xl backdrop-blur-xl border border-white/20">
            <svg class="h-5 w-5 text-white shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
            <span id="toast-text">Perubahan berhasil disimpan!</span>
        </div>
    </div>

    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center gap-2">
                <span>🗺️</span> Peta Interaktif & Kelola Zona Kerawanan
            </h2>
            <p class="text-xs sm:text-sm text-surface-400 mt-1">
                Seluruh 13 kabupaten/kota se-Sulawesi Tengah telah dibentuk persis sesuai batas wilayah resminya. Klik langsung wilayah pada peta untuk mengubah warna status (Merah, Kuning, Hijau).
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('peta') }}" target="_blank"
               class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-xs font-semibold text-surface-300 hover:text-white hover:bg-white/10 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
                Lihat Peta Publik
            </a>
            <a href="{{ route('admin.zona.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-500 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Tambah Wilayah
            </a>
        </div>
    </div>

    {{-- Ringkasan Status Zona --}}
    @php
        $countMerah = $allZonas->where('status_zona', 'merah')->count();
        $countKuning = $allZonas->where('status_zona', 'kuning')->count();
        $countHijau = $allZonas->where('status_zona', 'hijau')->count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-white/10 bg-surface-900/60 p-4 backdrop-blur-xl">
            <span class="text-xs text-surface-400 font-medium">Total Wilayah</span>
            <div class="mt-1 text-2xl font-bold text-white" id="stat-total">{{ $allZonas->count() }} Wilayah</div>
            <div class="mt-1 text-[11px] text-surface-500">Provinsi Sulawesi Tengah</div>
        </div>
        <div class="rounded-2xl border border-red-500/20 bg-red-500/10 p-4 backdrop-blur-xl">
            <span class="text-xs text-red-400 font-semibold flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                Rawan Tinggi (Merah)
            </span>
            <div class="mt-1 text-2xl font-bold text-red-400" id="stat-merah">{{ $countMerah }} Wilayah</div>
            <div class="mt-1 text-[11px] text-red-400/80">Wilayah zona merah bahaya</div>
        </div>
        <div class="rounded-2xl border border-amber-500/20 bg-amber-500/10 p-4 backdrop-blur-xl">
            <span class="text-xs text-amber-400 font-semibold flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                Rawan Sedang (Kuning)
            </span>
            <div class="mt-1 text-2xl font-bold text-amber-400" id="stat-kuning">{{ $countKuning }} Wilayah</div>
            <div class="mt-1 text-[11px] text-amber-400/80">Wilayah zona waspada</div>
        </div>
        <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 backdrop-blur-xl">
            <span class="text-xs text-emerald-400 font-semibold flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Rawan Rendah (Hijau)
            </span>
            <div class="mt-1 text-2xl font-bold text-emerald-400" id="stat-hijau">{{ $countHijau }} Wilayah</div>
            <div class="mt-1 text-[11px] text-emerald-400/80">Wilayah zona aman</div>
        </div>
    </div>

    {{-- Map Card --}}
    <div class="rounded-3xl border border-white/10 bg-surface-900/60 backdrop-blur-xl p-4 sm:p-5 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div>
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <span>📍</span> Peta Wilayah Sulawesi Tengah
                </h3>
                <p class="text-xs text-surface-400 mt-0.5">
                    Arahkan kursor atau klik poligon wilayah untuk langsung memperbarui status kerawanan (warna zona).
                </p>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-950 border border-white/10 text-surface-300">
                    <span class="h-2 w-2 rounded-full bg-red-500"></span> Merah
                </span>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-950 border border-white/10 text-surface-300">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span> Kuning
                </span>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-surface-950 border border-white/10 text-surface-300">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Hijau
                </span>
            </div>
        </div>

        <div id="admin-peta-zona" class="shadow-inner"></div>
    </div>

    {{-- Table Card --}}
    <div class="rounded-3xl border border-white/10 bg-surface-900/60 backdrop-blur-xl overflow-hidden shadow-xl">
        <div class="p-6 border-b border-white/5 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Daftar Rinci Data Wilayah</h3>
                <p class="text-xs text-surface-400 mt-0.5">Tabel data wilayah yang sinkron secara real-time dengan peta di atas.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm" id="table-zonas">
                <thead class="bg-surface-950/50 text-xs uppercase tracking-wider text-surface-400 border-b border-white/5">
                    <tr>
                        <th class="py-4 px-6 font-semibold">Nama Wilayah</th>
                        <th class="py-4 px-6 font-semibold">Status Kerawanan</th>
                        <th class="py-4 px-6 font-semibold text-center">Jumlah Kasus</th>
                        <th class="py-4 px-6 font-semibold">Batas Wilayah</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($allZonas as $zona)
                        <tr class="hover:bg-white/[0.02] transition" id="row-zona-{{ $zona->id }}">
                            <td class="py-4 px-6">
                                <span class="font-bold text-white block nama-wilayah-text">{{ $zona->nama_wilayah }}</span>
                                <span class="text-xs text-surface-400 line-clamp-1 deskripsi-text">{{ $zona->deskripsi ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="status-badge" id="badge-zona-{{ $zona->id }}">
                                    @if($zona->status_zona === 'merah')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-danger-500/15 border border-danger-500/30 px-3 py-1 text-xs font-semibold text-danger-400">
                                            <span class="h-2 w-2 rounded-full bg-danger-500 animate-pulse"></span>
                                            🔴 Merah (Rawan Tinggi)
                                        </span>
                                    @elseif($zona->status_zona === 'kuning')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-500/15 border border-warning-500/30 px-3 py-1 text-xs font-semibold text-warning-400">
                                            <span class="h-2 w-2 rounded-full bg-warning-500"></span>
                                            🟡 Kuning (Rawan Sedang)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 border border-accent-500/30 px-3 py-1 text-xs font-semibold text-accent-400">
                                            <span class="h-2 w-2 rounded-full bg-accent-500"></span>
                                            🟢 Hijau (Rawan Rendah)
                                        </span>
                                    @endif
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-white jumlah-kasus-text">
                                {{ number_format($zona->jumlah_kasus) }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1 rounded-md bg-emerald-500/10 border border-emerald-500/20 px-2 py-1 text-[11px] font-medium text-emerald-400">
                                    ✓ Poligon Resmi
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button type="button"
                                            onclick="openEditModal({{ $zona->id }})"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary-600/20 text-primary-400 border border-primary-500/30 hover:bg-primary-600 hover:text-white text-xs font-semibold transition"
                                            title="Ubah Warna & Data">
                                        <span>🎨</span> Ubah Warna
                                    </button>
                                    <a href="{{ route('admin.zona.edit', $zona->id) }}"
                                       class="p-2 rounded-lg bg-white/5 text-surface-300 hover:text-white hover:bg-white/10 transition"
                                       title="Edit Form Lengkap">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-surface-500 text-sm">
                                Belum ada data wilayah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
            <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-semibold uppercase tracking-wider bg-primary-500/20 text-primary-400 border border-primary-500/30 mb-2">
                Pengaturan Wilayah
            </span>
            <h3 class="text-xl font-bold text-white" id="modal-nama-wilayah">Nama Wilayah</h3>
            <p class="text-xs text-surface-400 mt-1">Pilih warna zona kerawanan yang akan diterapkan pada seluruh batas wilayah ini.</p>
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
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl border border-white/10 bg-white/5 text-xs font-semibold text-surface-300 hover:bg-white/10 hover:text-white transition">
                    Batal
                </button>
                <button type="submit" id="btn-save-modal" class="px-6 py-2.5 rounded-xl bg-primary-600 text-xs font-bold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-500 transition flex items-center gap-2">
                    <span>💾</span> Simpan & Terapkan Warna
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
// Data seluruh zona dari server
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

document.addEventListener('DOMContentLoaded', function() {
    // 1. Inisialisasi Peta Leaflet Admin
    map = L.map('admin-peta-zona', {
        zoomControl: true,
        scrollWheelZoom: true,
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
        "🗺️ OpenStreetMap (Lengkap Perbatasan)": osmLayer,
        "⛰️ Topografi Detail": esriTopo,
        "🛰️ Satelit + Batas Wilayah": satelliteLayer,
    }, null, { position: 'topright' }).addTo(map);

    setTimeout(() => { map.invalidateSize(); }, 300);

    // 3. Load & Render GeoJSON Poligon Wilayah
    loadAdminPeta();
});

function loadAdminPeta() {
    fetch('{{ route("peta.geojson") }}')
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
                        fillOpacity: 0.6
                    };
                },
                onEachFeature: function(feature, layer) {
                    const p = feature.properties;
                    layerMapByZonaId[p.id] = layer;

                    // Tooltip
                    layer.bindTooltip(`
                        <div style="font-weight:700">${p.nama_wilayah}</div>
                        <div style="font-size:11px;opacity:0.85">Status: ${p.status_zona.toUpperCase()} • Klik untuk ubah warna</div>
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
                            openEditModal(p.id);
                        }
                    });
                }
            }).addTo(map);

            if (geoJsonLayer.getBounds().isValid()) {
                map.fitBounds(geoJsonLayer.getBounds(), { padding: [20, 20] });
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
    btnSave.innerHTML = `<span>⏳</span> Menyimpan...`;

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
        btnSave.innerHTML = `<span>💾</span> Simpan & Terapkan Warna`;

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
                    fillOpacity: 0.65
                });
            }

            // 2. Update baris di tabel
            updateTableRow(zona);

            // 3. Update ringkasan statistik
            updateStats();

            // Tutup modal
            closeEditModal();

            // Tampilkan Toast
            showToast(`Warna wilayah ${zona.nama_wilayah} berhasil diubah menjadi ${statusZona.toUpperCase()}!`);
        } else {
            alert('Gagal menyimpan data: ' + (data.message || 'Terjadi kesalahan.'));
        }
    })
    .catch(err => {
        btnSave.disabled = false;
        btnSave.innerHTML = `<span>💾</span> Simpan & Terapkan Warna`;
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
                <span class="inline-flex items-center gap-1.5 rounded-full bg-danger-500/15 border border-danger-500/30 px-3 py-1 text-xs font-semibold text-danger-400">
                    <span class="h-2 w-2 rounded-full bg-danger-500 animate-pulse"></span>
                    🔴 Merah (Rawan Tinggi)
                </span>`;
        } else if (zona.status_zona === 'kuning') {
            badgeEl.innerHTML = `
                <span class="inline-flex items-center gap-1.5 rounded-full bg-warning-500/15 border border-warning-500/30 px-3 py-1 text-xs font-semibold text-warning-400">
                    <span class="h-2 w-2 rounded-full bg-warning-500"></span>
                    🟡 Kuning (Rawan Sedang)
                </span>`;
        } else {
            badgeEl.innerHTML = `
                <span class="inline-flex items-center gap-1.5 rounded-full bg-accent-500/15 border border-accent-500/30 px-3 py-1 text-xs font-semibold text-accent-400">
                    <span class="h-2 w-2 rounded-full bg-accent-500"></span>
                    🟢 Hijau (Rawan Rendah)
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
</script>
@endpush
