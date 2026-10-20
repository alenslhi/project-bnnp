<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Pengunjung;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengunjungController extends Controller
{
    /**
     * Tampilkan halaman riwayat & statistik pengunjung website.
     */
    public function index(Request $request): View
    {
        $totalPengunjung     = Pengunjung::count();
        $pengunjungHariIni   = Pengunjung::hariIni()->count();
        $pengunjungMingguIni = Pengunjung::mingguIni()->count();
        $pengunjungBulanIni  = Pengunjung::bulanIni()->count();

        // Ambil riwayat log kunjungan terbaru dengan pagination
        $logs = Pengunjung::latest('id')->paginate(15);

        return view('admin.pengunjung.index', compact(
            'totalPengunjung',
            'pengunjungHariIni',
            'pengunjungMingguIni',
            'pengunjungBulanIni',
            'logs'
        ));
    }

    /**
     * Reset seluruh data riwayat pengunjung ke 0.
     */
    public function reset(Request $request): RedirectResponse
    {
        Pengunjung::truncate();

        // Catat di log aktivitas sistem
        ActivityLog::record('RESET_PENGUNJUNG', 'Mereset seluruh data riwayat pengunjung website ke 0.');

        return redirect()
            ->route('admin.pengunjung.index')
            ->with('success', 'Semua data riwayat pengunjung berhasil di-reset menjadi 0.');
    }
}
