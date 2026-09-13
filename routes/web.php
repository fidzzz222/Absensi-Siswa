<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PelanggaranController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Absensi SMKN 1 Kota Bekasi (Si Hadir)
|--------------------------------------------------------------------------
*/

// Root URL -> Redirect to dashboard or login
Route::get('/', function () {
    if (auth()->check()) {
        return (new AuthController)->redirectByRole(auth()->user()->role);
    }
    return redirect()->route('login');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Auth required)
Route::middleware('auth')->group(function () {

    // --- Role-based Dashboards ---
    Route::get('/dashboard/guru', [DashboardController::class, 'guru'])->name('dashboard.guru');
    Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])->name('dashboard.siswa');
    Route::get('/dashboard/sekretaris', [DashboardController::class, 'sekretaris'])->name('dashboard.sekretaris');
    Route::get('/dashboard/guru-bk', [DashboardController::class, 'guruBk'])->name('dashboard.guru_bk');
    Route::get('/dashboard/guru-piket', [DashboardController::class, 'guruPiket'])->name('dashboard.guru_piket');

    // Compatibility aliases for legacy routes
    Route::get('/dashboardd/guru', [DashboardController::class, 'guru'])->name('dashboardd.guru');
    Route::get('/dashboard/guru-mapel', [DashboardController::class, 'guru'])->name('dashboard.guru_mapel');

    // --- Absensi: Input Guru & Sekretaris ---
    Route::get('/dashboard/guru/absen', [AbsensiController::class, 'formGuru'])->name('guru.absen.form');
    Route::post('/dashboard/guru/absen/store', [AbsensiController::class, 'store'])->name('guru.absen.store');
    Route::get('/dashboardd/absen', [AbsensiController::class, 'formGuru'])->name('dashboardd.absen');
    Route::post('/dashboardd/absen/store', [AbsensiController::class, 'store'])->name('guru.absen.post');

    // --- Absensi: Rekap & Pencarian (Semua Role) ---
    Route::get('/dashboard/absen', [AbsensiController::class, 'absenView'])->name('dashboard.absen');
    Route::get('/dashboard/absen/search', [AbsensiController::class, 'searchAbsen'])->name('dashboard.absen.search');

    // --- Pelanggaran (Guru BK, Guru Piket) ---
    Route::get('/dashboard/pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::get('/dashboard/pelanggaran/create', [PelanggaranController::class, 'create'])->name('pelanggaran.create');
    Route::post('/dashboard/pelanggaran', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::delete('/dashboard/pelanggaran/{id}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
});

