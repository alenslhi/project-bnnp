<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EdukasiController as AdminEdukasiController;
use App\Http\Controllers\Admin\ZonaController as AdminZonaController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════════════
// ROUTE PUBLIK (tanpa autentikasi)
// ══════════════════════════════════════════════════════════════

// Beranda
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Peta Interaktif
Route::get('/peta', [PetaController::class, 'index'])->name('peta');
Route::get('/api/peta/geojson', [PetaController::class, 'geoJson'])->name('peta.geojson');

// Katalog Edukasi
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{edukasi}', [EdukasiController::class, 'show'])->name('edukasi.show');

// FAQ & Kontak
Route::get('/faq-kontak', [\App\Http\Controllers\FaqKontakController::class, 'index'])->name('faq-kontak');

// ══════════════════════════════════════════════════════════════
// AUTENTIKASI
// ══════════════════════════════════════════════════════════════

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ══════════════════════════════════════════════════════════════
// ROUTE ADMIN (memerlukan login + role)
// ══════════════════════════════════════════════════════════════

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:super_admin,admin_rehab,admin_brantas,admin_cegah'])
    ->group(function () {

        // Dashboard (semua admin)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ── Manajemen User (Super Admin) ──
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
            ->middleware('role:super_admin');

        // ── Log Aktivitas (Super Admin) ──
        Route::get('logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])
            ->name('logs.index')
            ->middleware('role:super_admin');

        // ── Manajemen Zona (Super Admin & Admin Pemberantasan) ──
        Route::resource('zona', AdminZonaController::class)
            ->middleware('role:super_admin,admin_brantas')
            ->except(['show']);

        // ── Manajemen Edukasi (Super Admin & semua Admin Bidang) ──
        Route::resource('edukasi', AdminEdukasiController::class)
            ->except(['show']);
    });
