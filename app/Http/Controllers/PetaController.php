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
        // Ambil semua zona untuk ditampilkan di peta
        $zonas = Zona::all();

        return view('publik.peta', compact('zonas'));
    }

    /**
     * API endpoint: Ambil data zona dalam format GeoJSON untuk Leaflet.
     * Digunakan oleh JavaScript di frontend.
     */
    public function geoJson(Request $request)
    {
        $query = Zona::query();

        if ($request->has('status') && in_array($request->status, ['merah', 'kuning', 'hijau'])) {
            $query->where('status_zona', $request->status);
        }

        $zonas = $query->get();

        $features = $zonas->map(function (Zona $zona) {
            return [
                'type'       => 'Feature',
                'geometry'   => json_decode($zona->koordinat_geojson, true),
                'properties' => [
                    'id'            => $zona->id,
                    'nama_wilayah'  => $zona->nama_wilayah,
                    'status_zona'   => $zona->status_zona,
                    'jumlah_kasus'  => $zona->jumlah_kasus,
                    'deskripsi'     => $zona->deskripsi,
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $features,
        ]);
    }
}
