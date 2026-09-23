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
     * - super_admin   : melihat semua statistik
     * - admin_rehab   : fokus data rehabilitasi
     * - admin_brantas : fokus data pemberantasan (zona)
     * - admin_cegah   : fokus data pencegahan (edukasi)
     */
    public function index()
    {
        $user = Auth::user();

        // Statistik umum (tersedia untuk semua role)
        $data = [
            'totalUsers'    => User::count(),
            'totalZona'     => Zona::count(),
            'totalEdukasi'  => Edukasi::count(),
            'totalKasus'    => Zona::sum('jumlah_kasus'),
            'zonaMerah'     => Zona::merah()->count(),
            'zonaKuning'    => Zona::kuning()->count(),
            'zonaHijau'     => Zona::hijau()->count(),
        ];

        // Data tambahan berdasarkan role
        switch ($user->role) {
            case 'super_admin':
                $data['users'] = User::latest()->take(5)->get();
                $data['zonasTerbaru'] = Zona::latest()->take(5)->get();
                $data['edukasiTerbaru'] = Edukasi::with('penulis')->latest()->take(5)->get();
                break;

            case 'admin_rehab':
                // Admin Rehabilitasi fokus pada artikel rehabilitasi
                $data['edukasiSaya'] = Edukasi::where('penulis_id', $user->id)->latest()->take(5)->get();
                break;

            case 'admin_brantas':
                // Admin Pemberantasan fokus pada zona kerawanan
                $data['zonasTerbaru'] = Zona::latest()->take(10)->get();
                break;

            case 'admin_cegah':
                // Admin Pencegahan fokus pada konten edukasi
                $data['edukasiSaya'] = Edukasi::where('penulis_id', $user->id)->latest()->take(5)->get();
                $data['edukasiTerbaru'] = Edukasi::with('penulis')->latest()->take(5)->get();
                break;
        }

        return view('admin.dashboard', $data);
    }
}
