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
        // Statistik ringkas untuk ditampilkan di beranda
        $totalZona = Zona::count();
        $zonaMerah = Zona::merah()->count();
        $zonaKuning = Zona::kuning()->count();
        $zonaHijau = Zona::hijau()->count();
        $totalKasus = Zona::sum('jumlah_kasus');

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
            'artikelTerbaru'
        ));
    }
}
