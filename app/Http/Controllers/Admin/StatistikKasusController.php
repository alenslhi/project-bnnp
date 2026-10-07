<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatistikKasus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StatistikKasusController extends Controller
{
    // Halaman kelola statistik (tabel dan form upload)
    public function index()
    {
        $datasets = StatistikKasus::select('nama_dataset', 'tahun')
            ->groupBy('nama_dataset', 'tahun')
            ->orderBy('tahun', 'desc')
            ->get();
            
        return view('admin.statistik.index', compact('datasets'));
    }

    // Proses import CSV
    public function import(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:2048',
            'nama_dataset' => 'required|string|max:255',
            'tahun' => 'required|integer'
        ]);

        $file = $request->file('file_csv');
        $path = $file->getRealPath();

        // Buka file CSV
        if (($handle = fopen($path, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ","); // baca header (baris pertama)
            
            DB::beginTransaction();
            try {
                // Hapus data lama jika dataset dengan nama yang sama di-upload ulang (Opsional: Update & Insert)
                StatistikKasus::where('nama_dataset', $request->nama_dataset)->delete();

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Pastikan baris memiliki jumlah kolom yang sesuai template
                    if(count($data) >= 4) {
                        StatistikKasus::create([
                            'nama_dataset'    => $request->nama_dataset,
                            'tahun'           => $request->tahun,
                            'kelompok_umur'   => $data[0] ?? null,
                            'jenis_kelamin'   => $data[1] ?? null,
                            'jenis_narkotika' => $data[2] ?? null,
                            'pekerjaan'       => $data[3] ?? null,
                            'jumlah_kasus'    => (int) ($data[4] ?? 0),
                        ]);
                    }
                }
                DB::commit();
                fclose($handle);
                return redirect()->back()->with('success', 'Data Statistik berhasil di-import!');
            } catch (\Exception $e) {
                DB::rollBack();
                fclose($handle);
                return redirect()->back()->with('error', 'Gagal memproses file CSV: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'File tidak dapat dibaca.');
    }

    // Hapus dataset
    public function destroyDataset($nama_dataset)
    {
        StatistikKasus::where('nama_dataset', urldecode($nama_dataset))->delete();
        return redirect()->back()->with('success', 'Dataset berhasil dihapus!');
    }
}
