<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Models\Edukasi;

class BerandaController extends Controller
{
    /**
     * Tampilkan halaman beranda publik.
     */
    public function index()
    {
        // Statistik ringkas agregasi tingkat Kabupaten/Kota (mencegah double-counting dengan kecamatan/kelurahan)
        $totalZona = Zona::kabupaten()->count();
        $zonaMerah = Zona::kabupaten()->merah()->count();
        $zonaKuning = Zona::kabupaten()->kuning()->count();
        $zonaHijau = Zona::kabupaten()->hijau()->count();
        $totalKasus = Zona::kabupaten()->sum('jumlah_kasus');
        $totalKecamatan = Zona::kecamatan()->count();

        // 3 artikel terbaru
        $artikelTerbaru = Edukasi::artikel()
            ->with('penulis')
            ->latest()
            ->take(3)
            ->get();

        return view('publik.beranda', compact(
            'totalZona',
            'zonaMerah',
            'zonaKuning',
            'zonaHijau',
            'totalKasus',
            'totalKecamatan',
            'artikelTerbaru'
        ));
    }
}
