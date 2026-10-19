<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard utama admin.
     *
     * Konten dashboard disesuaikan berdasarkan role user:
     * - super_admin : akses penuh statistik, data konten, dan kelola user
     * - admin       : akses data operasional (zona, edukasi, statistik)
     */
    public function index()
    {
        $user = Auth::user();

        // Statistik umum tingkat Kabupaten/Kota (mencegah double-counting dengan kecamatan/kelurahan)
        $data = [
            'totalUsers'     => User::count(),
            'totalZona'      => Zona::kabupaten()->count(),
            'totalKecamatan' => Zona::kecamatan()->count(),
            'totalEdukasi'   => Edukasi::count(),
            'totalKasus'     => Zona::kabupaten()->sum('jumlah_kasus'),
            'zonaMerah'      => Zona::kabupaten()->merah()->count(),
            'zonaKuning'     => Zona::kabupaten()->kuning()->count(),
            'zonaHijau'      => Zona::kabupaten()->hijau()->count(),
        ];

        // Data tambahan berdasarkan role
        $data['zonasTerbaru'] = Zona::latest()->take(5)->get();
        $data['edukasiTerbaru'] = Edukasi::with('penulis')->latest()->take(5)->get();

        if ($user->isSuperAdmin()) {
            $data['users'] = User::latest()->take(5)->get();
        } else {
            $data['edukasiSaya'] = Edukasi::where('penulis_id', $user->id)->latest()->take(5)->get();
        }

        return view('admin.dashboard', $data);
    }
}
