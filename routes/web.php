<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', fn () => redirect()->route('reports.index'))
    ->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Pelapor: buat laporan
    Route::middleware('role:pelapor')->group(function () {
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    });

    // Detail dan evidence boleh diakses semua role yang berhak,
    // hak akses detail tetap dicek oleh Gate di controller.
    Route::get('/reports/{report}', [ReportController::class, 'show'])
        ->whereNumber('report')->name('reports.show');

    Route::get('/reports/{report}/evidence', [ReportController::class, 'evidence'])
        ->whereNumber('report')->name('reports.evidence');

    // Pelapor: edit/update hanya saat menunggu_review
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])
        ->whereNumber('report')->middleware('role:pelapor')->name('reports.edit');

    Route::put('/reports/{report}', [ReportController::class, 'update'])
        ->whereNumber('report')->middleware('role:pelapor')->name('reports.update');

    // Relawan: review
    Route::patch('/reports/{report}/review', [ReportController::class, 'review'])
        ->whereNumber('report')->middleware('role:relawan')->name('reports.review');

    // Koordinator: forward
    Route::patch('/reports/{report}/forward', [ReportController::class, 'forward'])
        ->whereNumber('report')->middleware('role:koordinator')->name('reports.forward');

    // Async info area
    Route::get('/areas/{area}/info', [AreaController::class, 'info'])->name('areas.info');

    // Rekap hanya koordinator
    Route::get('/recap', [RecapController::class, 'index'])
        ->middleware('role:koordinator')->name('recap');

    // Profile semua role yang login
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';