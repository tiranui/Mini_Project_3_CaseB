<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', fn () => redirect()->route('reports.index'))
    ->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::middleware('role:pelapor')->group(function () {
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
       
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::get('/reports/{report}/evidence', [ReportController::class, 'evidence'])->name('reports.evidence');

        Route::patch('/reports/{report}/review', [ReportController::class, 'review'])
        ->middleware('role:relawan')->name('reports.review');
        Route::patch('/reports/{report}/forward', [ReportController::class, 'forward'])
        ->middleware('role:koordinator')->name('reports.forward');
       
        Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/areas/{area}/info', [AreaController::class, 'info'])->name('areas.info');

        Route::get('/recap', [RecapController::class, 'index'])
        ->middleware('role:koordinator')->name('recap');
    });
});

require __DIR__.'/auth.php';
