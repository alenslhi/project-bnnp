<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    /**
     * Tampilkan halaman peta interaktif publik.
     */
    public function index()
    {
        $kabupatens = Zona::where('tingkat', 'kabupaten')
            ->orderByRaw("CASE WHEN kode_wilayah = '72.08' THEN 0 ELSE 1 END, nama_wilayah ASC")
            ->get();

        // Ambil jumlah kecamatan per kabupaten untuk badge filter
        $kecamatanCounts = Zona::where('tingkat', 'kecamatan')
            ->selectRaw('parent_kode, count(*) as count')
            ->groupBy('parent_kode')
            ->pluck('count', 'parent_kode')
            ->toArray();

        return view('publik.peta', compact('kabupatens', 'kecamatanCounts'));
    }

    /**
     * API endpoint: Ambil data zona dalam format GeoJSON untuk Leaflet.
     * Mendukung filter status, tingkat (kabupaten/kecamatan/kelurahan), dan parent_kode / kabupaten.
     */
    public function geoJson(Request $request)
    {
        $query = Zona::query();

        // Default tingkat wilayah adalah kecamatan
        $tingkat = $request->input('tingkat', 'kecamatan');
        $parentKode = $request->input('parent_kode') ?? $request->input('kabupaten');

        if (in_array($tingkat, ['kabupaten', 'kecamatan', 'kelurahan'])) {
            $query->where('tingkat', $tingkat);
        } else {
            $query->where('tingkat', 'kecamatan');
        }

        // Filter parent wilayah / kabupaten tertentu
        if (!empty($parentKode)) {
            // Jika dikirim kata kunci nama seperti 'parigi' atau 'banggai', cari kodenya
            if (!preg_match('/^\d+(\.\d+)*$/', $parentKode)) {
                $matchedKab = Zona::where('tingkat', 'kabupaten')
                    ->where('nama_wilayah', 'LIKE', "%{$parentKode}%")
                    ->first();
                if ($matchedKab) {
                    $parentKode = $matchedKab->kode_wilayah;
                }
            }

            if ($tingkat === 'kabupaten') {
                $query->where(function ($q) use ($parentKode) {
                    $q->where('kode_wilayah', $parentKode)
                      ->orWhere('parent_kode', $parentKode);
                });
            } else {
                $query->where('parent_kode', $parentKode);
            }
        }

        if ($request->filled('parent_nama')) {
            $query->where('parent_nama', 'LIKE', "%{$request->parent_nama}%");
        }

        // Filter status zona (merah, kuning, hijau)
        if ($request->has('status') && in_array($request->status, ['merah', 'kuning', 'hijau'])) {
            $query->where('status_zona', $request->status);
        }

        $zonas = $query->get();

        $features = $zonas->map(function (Zona $zona) {
            return [
                'type'       => 'Feature',
                'geometry'   => json_decode($zona->koordinat_geojson, true),
                'properties' => [
                    'id'           => $zona->id,
                    'nama_wilayah' => $zona->nama_wilayah,
                    'tingkat'      => $zona->tingkat,
                    'kode_wilayah' => $zona->kode_wilayah,
                    'parent_kode'  => $zona->parent_kode,
                    'parent_nama'  => $zona->parent_nama,
                    'status_zona'  => $zona->status_zona,
                    'jumlah_kasus' => $zona->jumlah_kasus,
                    'deskripsi'    => $zona->deskripsi,
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $features,
        ]);
    }
}
