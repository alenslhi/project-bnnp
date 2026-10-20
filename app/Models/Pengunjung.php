<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Pengunjung extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'session_id',
        'url',
        'visit_date',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    /**
     * Catat kunjungan pengunjung:
     * - Hanya tercatat 1 kali sehari per pengunjung (berdasarkan cookie, session, dan IP).
     * - Reset otomatis pada pukul 00:00 (pergantian tanggal baru).
     * - Jika pengunjung membuka halaman berulang kali di hari yang sama, tidak akan dihitung lagi.
     */
    public static function recordVisit(Request $request): ?self
    {
        try {
            $today = Carbon::today()->toDateString();

            // 1. Cek cookie browser (reset otomatis jam 12 malam saat cookie kadaluarsa)
            if ($request->cookie('bnnp_visited_date') === $today) {
                return null;
            }

            // 2. Cek session aktif pengguna
            if ($request->hasSession() && $request->session()->get('bnnp_visited_date') === $today) {
                return null;
            }

            $ip = $request->ip() ?? '127.0.0.1';
            $userAgent = $request->userAgent() ?? '';

            // Abaikan bot crawler
            if (preg_match('/bot|crawl|slurp|spider|mediapartners/i', $userAgent)) {
                return null;
            }

            // 3. Cek database apakah IP ini sudah tercatat pada hari ini
            $hasVisited = static::where('ip_address', $ip)
                ->where('visit_date', $today)
                ->exists();

            if (!$hasVisited) {
                if ($request->hasSession()) {
                    $request->session()->put('bnnp_visited_date', $today);
                }

                return static::create([
                    'ip_address' => $ip,
                    'user_agent' => substr($userAgent, 0, 500),
                    'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                    'url'        => substr($request->fullUrl(), 0, 255),
                    'visit_date' => $today,
                ]);
            } else {
                if ($request->hasSession()) {
                    $request->session()->put('bnnp_visited_date', $today);
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return null;
    }

    /**
     * Scope filter waktu akses (Hari, Bulan, Tahun).
     */
    public function scopeFilterWaktu($query, $hari = null, $bulan = null, $tahun = null)
    {
        if (!empty($tahun) && $tahun !== 'Semua') {
            $query->whereYear('visit_date', (int) $tahun);
        }

        if (!empty($bulan) && $bulan !== 'Semua') {
            $query->whereMonth('visit_date', (int) $bulan);
        }

        if (!empty($hari) && $hari !== 'Semua') {
            $query->whereDay('visit_date', (int) $hari);
        }

        return $query;
    }

    /**
     * Scope kunjungan hari ini.
     */
    public function scopeHariIni($query)
    {
        return $query->where('visit_date', Carbon::today()->toDateString());
    }

    /**
     * Scope kunjungan bulan ini.
     */
    public function scopeBulanIni($query)
    {
        return $query->whereYear('visit_date', Carbon::now()->year)
                     ->whereMonth('visit_date', Carbon::now()->month);
    }

    /**
     * Scope kunjungan minggu ini.
     */
    public function scopeMingguIni($query)
    {
        return $query->whereBetween('visit_date', [
            Carbon::now()->startOfWeek()->toDateString(),
            Carbon::now()->endOfWeek()->toDateString()
        ]);
    }

    /**
     * Scope kunjungan tahun ini.
     */
    public function scopeTahunIni($query)
    {
        return $query->whereYear('visit_date', Carbon::now()->year);
    }

    /**
     * Parse nama browser ringkas.
     */
    public function getBrowserAttribute(): string
    {
        $ua = $this->user_agent ?? '';
        if (empty($ua)) return 'Web Browser';
        if (str_contains($ua, 'Edg')) return 'Microsoft Edge';
        if (str_contains($ua, 'Chrome')) return 'Google Chrome';
        if (str_contains($ua, 'Firefox')) return 'Mozilla Firefox';
        if (str_contains($ua, 'Safari') && !str_contains($ua, 'Chrome')) return 'Apple Safari';
        if (str_contains($ua, 'Opera') || str_contains($ua, 'OPR')) return 'Opera';
        return 'Web Browser';
    }

    /**
     * Parse sistem operasi / perangkat ringkas.
     */
    public function getPlatformAttribute(): string
    {
        $ua = $this->user_agent ?? '';
        if (str_contains($ua, 'Windows NT 10.0')) return 'Windows 10/11';
        if (str_contains($ua, 'Windows')) return 'Windows';
        if (str_contains($ua, 'Android')) return 'Android';
        if (str_contains($ua, 'iPhone')) return 'iPhone (iOS)';
        if (str_contains($ua, 'iPad')) return 'iPad (iPadOS)';
        if (str_contains($ua, 'Macintosh') || str_contains($ua, 'Mac OS')) return 'macOS';
        if (str_contains($ua, 'Linux')) return 'Linux';
        return 'Perangkat Lain';
    }

    /**
     * Ambil daftar tahun unik yang tersedia untuk filter.
     */
    public static function getAvailableYears(): array
    {
        $currentYear = (int) Carbon::now()->year;

        $years = static::selectRaw('YEAR(visit_date) as year')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->filter(fn($y) => $y > 0)
            ->values()
            ->toArray();

        if (!in_array($currentYear, $years)) {
            $years[] = $currentYear;
        }

        rsort($years);

        return $years;
    }
}
