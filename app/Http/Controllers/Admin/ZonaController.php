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
    public function index(Request $request)
    {
        $tingkat = $request->get('tingkat', 'kecamatan');
        $parentKode = $request->get('parent_kode');
        $search = $request->get('search');

        $kabupatens = Zona::where('tingkat', 'kabupaten')
            ->orderBy('nama_wilayah')
            ->get();

        $kecamatanCounts = Zona::where('tingkat', 'kecamatan')
            ->selectRaw('parent_kode, count(*) as count')
            ->groupBy('parent_kode')
            ->pluck('count', 'parent_kode')
            ->toArray();

        $query = Zona::query();

        if (in_array($tingkat, ['kabupaten', 'kecamatan', 'kelurahan'])) {
            $query->where('tingkat', $tingkat);
        } else {
            $query->where('tingkat', 'kecamatan');
        }

        if ($parentKode) {
            if ($tingkat === 'kabupaten') {
                $query->where('kode_wilayah', $parentKode);
            } else {
                $query->where('parent_kode', $parentKode);
            }
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_wilayah', 'LIKE', "%{$search}%")
                  ->orWhere('parent_nama', 'LIKE', "%{$search}%");
            });
        }

        $allZonas = (clone $query)->orderBy('nama_wilayah')->get();
        $zonas = $query->orderBy('nama_wilayah')->paginate(15)->withQueryString();

        return view('admin.zona.index', compact('zonas', 'allZonas', 'kabupatens', 'kecamatanCounts', 'tingkat', 'parentKode', 'search'));
    }

    /**
     * Tampilkan form tambah zona baru.
     */
    public function create()
    {
        $kabupatens = Zona::where('tingkat', 'kabupaten')->orderBy('nama_wilayah')->get();
        return view('admin.zona.create', compact('kabupatens'));
    }

    /**
     * Simpan zona baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wilayah'      => ['required', 'string', 'max:255'],
            'tingkat'           => ['nullable', 'string', 'in:kabupaten,kecamatan,kelurahan'],
            'kode_wilayah'      => ['nullable', 'string', 'max:50'],
            'parent_kode'       => ['nullable', 'string', 'max:50'],
            'parent_nama'       => ['nullable', 'string', 'max:255'],
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
            'nama_wilayah'      => ['sometimes', 'required', 'string', 'max:255'],
            'tingkat'           => ['nullable', 'string', 'in:kabupaten,kecamatan,kelurahan'],
            'kode_wilayah'      => ['nullable', 'string', 'max:50'],
            'parent_kode'       => ['nullable', 'string', 'max:50'],
            'parent_nama'       => ['nullable', 'string', 'max:255'],
            'koordinat_geojson' => ['nullable', 'string'],
            'status_zona'       => ['required', 'in:merah,kuning,hijau'],
            'jumlah_kasus'      => ['required', 'integer', 'min:0'],
            'deskripsi'         => ['nullable', 'string'],
        ]);

        if (empty($validated['koordinat_geojson'])) {
            unset($validated['koordinat_geojson']);
        }

        $zona->update($validated);

        \App\Models\ActivityLog::record('UPDATE_ZONA', "Mengupdate data zona: {$zona->nama_wilayah} menjadi status {$zona->status_zona}");

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Zona {$zona->nama_wilayah} berhasil diperbarui.",
                'zona'    => $zona,
            ]);
        }

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
