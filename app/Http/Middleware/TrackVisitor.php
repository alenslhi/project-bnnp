<?php

namespace App\Http\Middleware;

use App\Models\Pengunjung;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya catat request GET publik yang sukses (HTTP 200)
        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            // Hindari tracking route admin, api, aset internal, dan ajax filter
            if (
                !$request->is('admin*') &&
                !$request->is('api*') &&
                !$request->is('storage*') &&
                !$request->is('_debugbar*') &&
                !$request->ajax()
            ) {
                Pengunjung::recordVisit($request);

                // Pasang cookie hingga pukul 00:00 (tengah malam pergantian hari)
                $today = Carbon::today()->toDateString();
                $minutesUntilMidnight = max(1, Carbon::now()->diffInMinutes(Carbon::tomorrow()));
                $response->headers->setCookie(cookie('bnnp_visited_date', $today, $minutesUntilMidnight));
            }
        }

        return $response;
    }
}
