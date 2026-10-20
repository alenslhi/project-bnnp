<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    /**
     * Endpoint API untuk filter data statistik pengunjung.
     * Mengembalikan JSON untuk update data pada popup modal secara real-time.
     */
    public function statistik(Request $request): JsonResponse
    {
        $hari  = $request->query('hari', 'Semua');
        $bulan = $request->query('bulan', Carbon::now()->month);
        $tahun = $request->query('tahun', Carbon::now()->year);

        $totalSepanjangWaktu = Pengunjung::count();
        $totalHariIni        = Pengunjung::hariIni()->count();
        $totalFilter         = Pengunjung::filterWaktu($hari, $bulan, $tahun)->count();

        return response()->json([
            'status'                         => 'success',
            'total_sepanjang_waktu'          => $totalSepanjangWaktu,
            'total_sepanjang_waktu_formatted'=> number_format($totalSepanjangWaktu, 0, ',', '.'),
            'total_hari_ini'                 => $totalHariIni,
            'total_hari_ini_formatted'       => number_format($totalHariIni, 0, ',', '.'),
            'total_filter'                   => $totalFilter,
            'total_filter_formatted'         => number_format($totalFilter, 0, ',', '.'),
            'filter' => [
                'hari'  => $hari,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ],
        ]);
    }

    /**
     * Data statistik pengunjung publik untuk view composer.
     */
    public static function getPublicStats(): array
    {
        $now = Carbon::now();

        return [
            'totalPengunjung'    => Pengunjung::count(),
            'pengunjungHariIni'  => Pengunjung::hariIni()->count(),
            'pengunjungBulanIni' => Pengunjung::bulanIni()->count(),
            'availableYears'     => Pengunjung::getAvailableYears(),
            'currentYear'        => (int) $now->year,
            'currentMonth'       => (int) $now->month,
        ];
    }
}
