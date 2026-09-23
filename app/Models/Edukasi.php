<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Edukasi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     */
    protected $table = 'edukasis';

    /**
     * Kolom yang boleh diisi secara mass assignment.
     *
     * @var list<string>
     */
    protected $fillable = [
        'judul',
        'kategori',
        'konten',
        'file_path',
        'penulis_id',
    ];

    // ──────────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────────

    /**
     * Edukasi ditulis oleh seorang User (penulis).
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    // ──────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────

    /**
     * Scope: filter berdasarkan kategori.
     */
    public function scopeByKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope: hanya artikel.
     */
    public function scopeArtikel($query)
    {
        return $query->where('kategori', 'artikel');
    }

    /**
     * Scope: hanya kamus narkotika.
     */
    public function scopeKamus($query)
    {
        return $query->where('kategori', 'kamus');
    }

    /**
     * Scope: hanya media (video/infografis).
     */
    public function scopeMedia($query)
    {
        return $query->where('kategori', 'media');
    }
}
