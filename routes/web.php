<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Routes dengan Authentication & Email Verification
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Student Routes
    Route::get('/student/data', [StudentController::class, 'data'])->name('student.data');
    Route::resource('student', StudentController::class);

    // Guru Routes
    Route::get('/guru/data', [GuruController::class, 'data'])->name('guru.data');
    Route::resource('guru', GuruController::class);

    // Inventory Routes
    Route::get('/inventory/data', [InventoryController::class, 'data'])->name('inventory.data');
    Route::resource('inventory', InventoryController::class);

    // Peminjaman Routes
    Route::get('/peminjaman/data', [PeminjamanController::class, 'data'])->name('peminjaman.data');
    Route::get('/peminjaman/get-peminjam/{role}', [PeminjamanController::class, 'getPeminjam'])->name('peminjaman.getPeminjam');
    Route::resource('peminjaman', PeminjamanController::class);

    // Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');

    // History Route
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
