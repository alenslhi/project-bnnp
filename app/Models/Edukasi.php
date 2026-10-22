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
        'gambar',
        'gambar_cover',
        'file_path',
        'penulis_id',
    ];

    /**
     * Accessor untuk field gambar.
     * Kompatibel dengan database lama/live yang mungkin masih bernama 'gambar_cover'.
     */
    public function getGambarAttribute(): ?string
    {
        return $this->attributes['gambar'] ?? $this->attributes['gambar_cover'] ?? null;
    }

    /**
     * Mutator untuk field gambar.
     * Menyesuaikan target kolom jika tabel database masih menggunakan 'gambar_cover'.
     */
    public function setGambarAttribute($value): void
    {
        if (array_key_exists('gambar_cover', $this->attributes)) {
            $this->attributes['gambar_cover'] = $value;
            return;
        }

        if (!array_key_exists('gambar', $this->attributes)) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasColumn('edukasis', 'gambar_cover') &&
                    !\Illuminate\Support\Facades\Schema::hasColumn('edukasis', 'gambar')) {
                    $this->attributes['gambar_cover'] = $value;
                    return;
                }
            } catch (\Throwable $e) {
                // Abaikan jika koneksi/schema query gagal
            }
        }

        $this->attributes['gambar'] = $value;
    }

    /**
     * URL publik untuk gambar sampul/thumbnail.
     */
    public function getGambarUrlAttribute(): ?string
    {
        $gambar = $this->gambar;

        if (!$gambar) {
            return null;
        }

        if (str_starts_with($gambar, 'http://') || str_starts_with($gambar, 'https://')) {
            return $gambar;
        }

        return asset('storage/' . $gambar);
    }

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
