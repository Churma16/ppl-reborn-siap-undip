<?php

use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\MahasiswaKelolaIrs;
use App\Http\Controllers\MahasiswaKelolaKhs;
use App\Http\Controllers\MahasiswaKelolaPkl;
use App\Http\Controllers\BerandaGuestController;
use App\Http\Controllers\DashboardMhsController;
use App\Http\Controllers\MahasiswaKelolaSkripsi;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDepartemenController;
use App\Http\Controllers\Departemen\DosenController;
use App\Http\Controllers\Dosen\IrsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

// Guest
Route::resource('/', BerandaGuestController::class);

// Departemen
Route::middleware(['auth', 'role:' . UserRole::Departemen->value])->group(function () {
    Route::get('/dashboard-departemen', [DashboardDepartemenController::class, 'index']);
    Route::get('/dashboard-departemen/data-mahasiswa', [DashboardDepartemenController::class, 'dataMahasiswa']);
    Route::get('/dashboard-departemen/data-mahasiswa-pkl', [DashboardDepartemenController::class, 'dataMahasiswaPkl']);
    Route::get('/dashboard-departemen/data-mahasiswa-skripsi', [DashboardDepartemenController::class, 'dataMahasiswaSkripsi']);
    Route::match(['get', 'post'], '/dashboard-departemen/pkl/export', [DashboardDepartemenController::class, 'exportPklExcel']);
    Route::match(['get', 'post'], '/dashboard-departemen/skripsi/export', [DashboardDepartemenController::class, 'exportSkripsiExcel']);
    Route::get('/dashboard-departemen/dosen', [DosenController::class, 'index']);
    Route::get('/dashboard-departemen/cetak-perwalian/{nip}', [DosenController::class, 'cetakPdfPerwalian']);
});

// Dosen
Route::middleware(['auth', 'role:' . UserRole::Dosen->value])->group(function () {
    Route::get('/dashboard-dosen', [DashboardDosenController::class, 'index']);

    Route::get('/dashboard-dosen/verifikasi-irs/table', [IrsController::class, 'getIrsVerificationTable']);
    Route::post('/dashboard-dosen/irs/validate/{id}/{action}', [IrsController::class, 'verifikasiIrs']);
    Route::get('/dashboard-dosen/verifikasi-irs', [DashboardDosenController::class, 'verifikasiIrs']);
    Route::get('/dashboard-dosen/verifikasi-irs/{action}/{irs}', [DashboardDosenController::class, 'verifikasiIrsKeputusan'])
        ->where('action', 'terima|tolak');

    Route::get('/dashboard-dosen/verifikasi-khs', [DashboardDosenController::class, 'verifikasiKhs']);
    Route::get('/dashboard-dosen/verifikasi-khs/{action}/{khs}', [DashboardDosenController::class, 'verifikasiKhsKeputusan'])
        ->where('action', 'terima|tolak');

    Route::get('/dashboard-dosen/verifikasi-pkl', [DashboardDosenController::class, 'verifikasiPkl']);
    Route::get('/dashboard-dosen/verifikasi-pkl/{action}/{pkl}', [DashboardDosenController::class, 'verifikasiPklKeputusan'])
        ->where('action', 'terima|tolak');

    Route::get('/dashboard-dosen/verifikasi-skripsi', [DashboardDosenController::class, 'verifikasiSkripsi']);
    Route::get('/dashboard-dosen/verifikasi-skripsi/{action}/{skripsi}', [DashboardDosenController::class, 'verifikasiSkripsiKeputusan'])
        ->where('action', 'terima|tolak');

    Route::get('/dashboard-dosen/validasi/table', [DashboardDosenController::class, 'getValidationTable']);
    Route::post('/dashboard-dosen/validasi/{id}/{action}/{type}', [DashboardDosenController::class, 'verifyDashboardRequest']);


});

// Mahasiswa
Route::middleware(['auth', 'role:' . UserRole::Mahasiswa->value])->group(function () {
    Route::get('/dashboard-mahasiswa', [DashboardMahasiswaController::class, 'index']);
    Route::resource('/dashboard-mahasiswa/irs', MahasiswaKelolaIrs::class)->only(['index', 'create', 'store', 'update'])->parameters(['irs' => 'irs']);
    Route::resource('/dashboard-mahasiswa/kelola-khs', MahasiswaKelolaKhs::class)->only(['index', 'create', 'store']);
    Route::resource('/dashboard-mahasiswa/kelola-pkl', MahasiswaKelolaPkl::class)->only(['index', 'create', 'store']);
    Route::resource('/dashboard-mahasiswa/kelola-skripsi', MahasiswaKelolaSkripsi::class)->only(['index', 'create', 'store']);

    Route::get('/dashboard-mahasiswa/edit-profile', [DashboardMahasiswaController::class, 'edit']);
    Route::get('/fetch-kabupatens/{id}', [DashboardMahasiswaController::class, 'fetchKabupaten']);
    Route::post('/dashboard-mahasiswa/edit-profile/update/{nim}', [DashboardMahasiswaController::class, 'update']);
    // Route::get('/dashboard-mhs', [DashboardMhsController::class, 'index']);
});

// Admin
Route::middleware(['auth', 'role:' . UserRole::Admin->value])->group(function () {
    Route::get('/dashboard-admin', [DashboardAdminController::class, 'index']);
    Route::get('/dashboard-admin/data-mahasiswa', [DashboardAdminController::class, 'dataMahasiswa']);
    // Route::get('/dashboard-admin/tambah-mahasiswa-baru', [DashboardAdminController::class, 'tambahMahasiswaBaru']);
    // Route::get('/dashboard-admin/tambah-mahasiswa-baru/create', [DashboardAdminController::class, 'createMahasiswa']);
    Route::resource('/dashboard-admin/semester', SemesterController::class);
    // Route::get('/dashboard-admin/semester', [DashboardAdminController::class, 'createSemester']);
    Route::resource('/dashboard-admin/mata-kuliah', MataKuliahController::class);
    Route::resource('/dashboard-admin/mahasiswa', MahasiswaController::class);
});

//API Routes

// Route::prefix('api')->group(function () {
//     Route::resource('/user', UserController::class);
// });
