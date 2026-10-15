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
    }
}
