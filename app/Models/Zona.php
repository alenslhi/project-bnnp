<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     */
    protected $table = 'zonas';

    /**
     * Kolom yang boleh diisi secara mass assignment.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_wilayah',
        'tingkat',
        'kode_wilayah',
        'parent_kode',
        'parent_nama',
        'koordinat_geojson',
        'status_zona',
        'jumlah_kasus',
        'deskripsi',
    ];

    /**
     * Casting atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jumlah_kasus' => 'integer',
        ];
    }

    // ──────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────

    /**
     * Scope: filter zona berdasarkan status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status_zona', $status);
    }

    /**
     * Scope: zona merah (kerawanan tinggi).
     */
    public function scopeMerah($query)
    {
        return $query->where('status_zona', 'merah');
    }

    /**
     * Scope: zona kuning (kerawanan sedang).
     */
    public function scopeKuning($query)
    {
        return $query->where('status_zona', 'kuning');
    }

    /**
     * Scope: zona hijau (kerawanan rendah).
     */
    public function scopeHijau($query)
    {
        return $query->where('status_zona', 'hijau');
    }

    /**
     * Scope: filter zona berdasarkan tingkat hierarki.
     */
    public function scopeTingkat($query, string $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    /**
     * Scope: tingkat kabupaten/kota.
     */
    public function scopeKabupaten($query)
    {
        return $query->where('tingkat', 'kabupaten');
    }

    /**
     * Scope: tingkat kecamatan.
     */
    public function scopeKecamatan($query)
    {
        return $query->where('tingkat', 'kecamatan');
    }

    /**
     * Scope: tingkat kelurahan/desa.
     */
    public function scopeKelurahan($query)
    {
        return $query->where('tingkat', 'kelurahan');
    }
}
