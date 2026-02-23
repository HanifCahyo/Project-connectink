<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrangTuaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route Kelas
    Route::resource('kelas', KelasController::class);

    // Route Siswa
    Route::resource('siswa', SiswaController::class);

    // Route Guru
    Route::resource('guru', GuruController::class);

    // Route Orang Tua
    Route::resource('orangtua', OrangTuaController::class);

    Route::prefix('laporan')->group(function () {
        Route::get('/siswa', [LaporanController::class, 'siswaPerKelas'])->name('laporan.siswa');
        Route::get('/guru', [LaporanController::class, 'guruPerKelas'])->name('laporan.guru');
        Route::get('/semua', [LaporanController::class, 'semua'])->name('laporan.semua');
    });

});

require __DIR__ . '/auth.php';
