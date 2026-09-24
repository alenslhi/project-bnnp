<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EdukasiController extends Controller
{
    /**
     * Tampilkan daftar edukasi.
     * Super Admin melihat semua, admin lain hanya melihat miliknya.
     */
    public function index()
    {
        $user = Auth::user();

        $query = Edukasi::with('penulis')->latest();

        // Non-super-admin hanya melihat konten milik sendiri
        if (!$user->isSuperAdmin()) {
            $query->where('penulis_id', $user->id);
        }

        $edukasis = $query->paginate(10);

        return view('admin.edukasi.index', compact('edukasis'));
    }

    /**
     * Tampilkan form tambah edukasi baru.
     */
    public function create()
    {
        return view('admin.edukasi.create');
    }

    /**
     * Simpan edukasi baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'kategori'  => ['required', 'in:artikel,kamus,media'],
            'konten'    => ['required', 'string'],
            'file_path' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['penulis_id'] = Auth::id();

        $edukasi = Edukasi::create($validated);

        \App\Models\ActivityLog::record('CREATE_EDUKASI', "Menambahkan materi edukasi: {$edukasi->judul}");

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Materi edukasi berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit edukasi.
     */
    public function edit(Edukasi $edukasi)
    {
        // Non-super-admin hanya bisa edit milik sendiri
        $this->authorizeOwnership($edukasi);

        return view('admin.edukasi.edit', compact('edukasi'));
    }

    /**
     * Update data edukasi di database.
     */
    public function update(Request $request, Edukasi $edukasi)
    {
        $this->authorizeOwnership($edukasi);

        $validated = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'kategori'  => ['required', 'in:artikel,kamus,media'],
            'konten'    => ['required', 'string'],
            'file_path' => ['nullable', 'string', 'max:255'],
        ]);

        $edukasi->update($validated);

        \App\Models\ActivityLog::record('UPDATE_EDUKASI', "Mengupdate materi edukasi: {$edukasi->judul}");

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Materi edukasi berhasil diperbarui.');
    }

    /**
     * Hapus edukasi dari database.
     */
    public function destroy(Edukasi $edukasi)
    {
        $this->authorizeOwnership($edukasi);

        $judul = $edukasi->judul;
        $edukasi->delete();

        \App\Models\ActivityLog::record('DELETE_EDUKASI', "Menghapus materi edukasi: {$judul}");

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Materi edukasi berhasil dihapus.');
    }

    /**
     * Pastikan user hanya mengakses konten milik sendiri (kecuali super admin).
     */
    private function authorizeOwnership(Edukasi $edukasi): void
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && $edukasi->penulis_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses materi ini.');
        }
    }
}
