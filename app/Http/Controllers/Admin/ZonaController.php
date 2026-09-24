<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    /**
     * Tampilkan daftar semua zona.
     */
    public function index()
    {
        $zonas = Zona::latest()->paginate(10);

        return view('admin.zona.index', compact('zonas'));
    }

    /**
     * Tampilkan form tambah zona baru.
     */
    public function create()
    {
        return view('admin.zona.create');
    }

    /**
     * Simpan zona baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wilayah'      => ['required', 'string', 'max:255'],
            'koordinat_geojson' => ['nullable', 'string'],
            'status_zona'       => ['required', 'in:merah,kuning,hijau'],
            'jumlah_kasus'      => ['required', 'integer', 'min:0'],
            'deskripsi'         => ['nullable', 'string'],
        ]);

        $zona = Zona::create($validated);

        \App\Models\ActivityLog::record('CREATE_ZONA', "Menambahkan zona rawan baru: {$zona->nama_wilayah}");

        return redirect()->route('admin.zona.index')
            ->with('success', 'Zona berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit zona.
     */
    public function edit(Zona $zona)
    {
        return view('admin.zona.edit', compact('zona'));
    }

    /**
     * Update data zona di database.
     */
    public function update(Request $request, Zona $zona)
    {
        $validated = $request->validate([
            'nama_wilayah'      => ['required', 'string', 'max:255'],
            'koordinat_geojson' => ['nullable', 'string'],
            'status_zona'       => ['required', 'in:merah,kuning,hijau'],
            'jumlah_kasus'      => ['required', 'integer', 'min:0'],
            'deskripsi'         => ['nullable', 'string'],
        ]);

        $zona->update($validated);

        \App\Models\ActivityLog::record('UPDATE_ZONA', "Mengupdate data zona: {$zona->nama_wilayah}");

        return redirect()->route('admin.zona.index')
            ->with('success', 'Zona berhasil diperbarui.');
    }

    /**
     * Hapus zona dari database.
     */
    public function destroy(Zona $zona)
    {
        $nama = $zona->nama_wilayah;
        $zona->delete();

        \App\Models\ActivityLog::record('DELETE_ZONA', "Menghapus zona: {$nama}");

        return redirect()->route('admin.zona.index')
            ->with('success', 'Zona berhasil dihapus.');
    }
}
