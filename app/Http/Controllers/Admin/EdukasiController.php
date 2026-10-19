<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // Super Admin dan Admin dapat melihat seluruh materi edukasi
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
            'lampiran'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $validated['penulis_id'] = Auth::id();

        // Handle file upload lampiran
        if ($request->hasFile('lampiran')) {
            $validated['file_path'] = $request->file('lampiran')
                ->store('edukasi', 'public');
        }

        // Hapus key 'lampiran' agar tidak masuk mass-assignment
        unset($validated['lampiran']);

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
            'lampiran'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        // Handle file upload lampiran baru (hapus file lama jika ada)
        if ($request->hasFile('lampiran')) {
            // Hapus file lama dari storage
            if ($edukasi->file_path && Storage::disk('public')->exists($edukasi->file_path)) {
                Storage::disk('public')->delete($edukasi->file_path);
            }

            $validated['file_path'] = $request->file('lampiran')
                ->store('edukasi', 'public');
        }

        // Hapus lampiran jika user mencentang "hapus lampiran"
        if ($request->boolean('hapus_lampiran') && !$request->hasFile('lampiran')) {
            if ($edukasi->file_path && Storage::disk('public')->exists($edukasi->file_path)) {
                Storage::disk('public')->delete($edukasi->file_path);
            }
            $validated['file_path'] = null;
        }

        // Hapus key 'lampiran' dan 'hapus_lampiran' agar tidak masuk mass-assignment
        unset($validated['lampiran']);

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

        // Hapus file lampiran dari storage
        if ($edukasi->file_path && Storage::disk('public')->exists($edukasi->file_path)) {
            Storage::disk('public')->delete($edukasi->file_path);
        }

        $judul = $edukasi->judul;
        $edukasi->delete();

        \App\Models\ActivityLog::record('DELETE_EDUKASI', "Menghapus materi edukasi: {$judul}");

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Materi edukasi berhasil dihapus.');
    }

    /**
     * Pastikan user memiliki izin untuk mengubah konten (Super Admin dan Admin).
     */
    private function authorizeOwnership(Edukasi $edukasi): void
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && !$user->isAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses materi ini.');
        }
    }
}

