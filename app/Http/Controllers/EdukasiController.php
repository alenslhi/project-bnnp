<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;

class EdukasiController extends Controller
{
    /**
     * Tampilkan katalog edukasi publik (dengan filter kategori).
     */
    public function index()
    {
        $kategori = request('kategori');

        $query = Edukasi::with('penulis')->latest();

        // Filter berdasarkan kategori jika ada
        if ($kategori && in_array($kategori, ['artikel', 'kamus', 'media'])) {
            $query->byKategori($kategori);
        }

        $edukasis = $query->paginate(9);
        $kategoriAktif = $kategori;

        return view('publik.edukasi.index', compact('edukasis', 'kategoriAktif'));
    }

    /**
     * Tampilkan detail satu materi edukasi.
     */
    public function show(Edukasi $edukasi)
    {
        $edukasi->load('penulis');

        // Ambil artikel terkait (kategori sama, kecuali yang sedang dilihat)
        $terkait = Edukasi::where('kategori', $edukasi->kategori)
            ->where('id', '!=', $edukasi->id)
            ->latest()
            ->take(3)
            ->get();

        return view('publik.edukasi.show', compact('edukasi', 'terkait'));
    }
}
