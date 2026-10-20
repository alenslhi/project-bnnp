<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Rate limiter untuk endpoint login.
         * Maksimal 5 percobaan per menit berdasarkan IP + email.
         * Mencegah brute-force dan dictionary attack.
         */
        RateLimiter::for('login', function (Request $request) {
            $key = $request->ip() . '|' . strtolower($request->input('email', ''));

            return Limit::perMinute(5)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    $retryAfter = $headers['Retry-After'] ?? 60;

                    return back()
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors([
                            'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$retryAfter} detik.",
                        ]);
                });
        });

        // View Composer untuk Statistik Pengunjung Website
        \Illuminate\Support\Facades\View::composer(['layouts.publik', 'publik.*'], function ($view) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('pengunjungs')) {
                    $stats = \App\Http\Controllers\PengunjungController::getPublicStats();
                    $view->with([
                        'visitorStats'       => $stats,
                        'totalPengunjung'    => $stats['totalPengunjung'],
                        'pengunjungHariIni'  => $stats['pengunjungHariIni'],
                        'pengunjungBulanIni' => $stats['pengunjungBulanIni'],
                        'availableYears'     => $stats['availableYears'],
                        'currentYear'        => $stats['currentYear'],
                        'currentMonth'       => $stats['currentMonth'],
                    ]);
                    return;
                }
            } catch (\Throwable $e) {
                // Fallback jika database belum dimigrasi
            }

            $currentYear = (int) date('Y');
            $currentMonth = (int) date('n');
            $view->with([
                'visitorStats'       => [
                    'totalPengunjung'    => 0,
                    'pengunjungHariIni'  => 0,
                    'pengunjungBulanIni' => 0,
                    'availableYears'     => [$currentYear],
                    'currentYear'        => $currentYear,
                    'currentMonth'       => $currentMonth,
                ],
                'totalPengunjung'    => 0,
                'pengunjungHariIni'  => 0,
                'pengunjungBulanIni' => 0,
                'availableYears'     => [$currentYear],
                'currentYear'        => $currentYear,
                'currentMonth'       => $currentMonth,
            ]);
        });
    }
}
