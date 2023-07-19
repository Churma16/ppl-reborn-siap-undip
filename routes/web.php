<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaKelolaIrs;
use App\Http\Controllers\MahasiswaKelolaKhs;
use App\Http\Controllers\MahasiswaKelolaPkl;
use App\Http\Controllers\BerandaGuestController;
use App\Http\Controllers\DashboardMhsController;
use App\Http\Controllers\MahasiswaKelolaSkripsi;

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDepartemenController;


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
Route::get('/dashboard-departemen', [DashboardDepartemenController::class, 'index']);

Route::get('/dashboard-departemen/data-mahasiswa', [DashboardDepartemenController::class, 'dataMahasiswa']);
Route::get('/dashboard-departemen/data-mahasiswa-pkl', [DashboardDepartemenController::class, 'dataMahasiswaPkl']);
Route::get('/dashboard-departemen/data-mahasiswa-skripsi', [DashboardDepartemenController::class, 'dataMahasiswaSkripsi']);


// Dosen
Route::get('/dashboard-dosen', [DashboardDosenController::class, 'index']);

Route::get('/dashboard-dosen/verifikasi-irs', [DashboardDosenController::class, 'verifikasiIrs']);
Route::get('/dashboard-dosen/verifikasi-irs/{action}/{irs}', [DashboardDosenController::class, 'verifikasiIrsKeputusan'])
    ->where('action', 'terima|tolak');

Route::get('/dashboard-dosen/verifikasi-khs', [DashboardDosenController::class, 'verifikasiKhs']);

// Mahasiswa
Route::get('/dashboard-mahasiswa', [DashboardMahasiswaController::class, 'index']);
Route::resource('/dashboard-mahasiswa/kelola-irs', MahasiswaKelolaIrs::class)->only(['index', 'create', 'store']);
Route::resource('/dashboard-mahasiswa/kelola-khs', MahasiswaKelolaKhs::class)->only(['index', 'create', 'store']);
Route::resource('/dashboard-mahasiswa/kelola-pkl', MahasiswaKelolaPkl::class)->only(['index', 'create', 'store']);
Route::resource('/dashboard-mahasiswa/kelola-skripsi', MahasiswaKelolaSkripsi::class)->only(['index', 'create', 'store']);

Route::get('/dashboard-mahasiswa/edit-profile', [DashboardMahasiswaController::class, 'edit']);
Route::get('/fetch-kabupatens/{id}', [DashboardMahasiswaController::class, 'fetchKabupaten']);
Route::post('/dashboard-mahasiswa/edit-profile/update/{nim}', [DashboardMahasiswaController::class, 'update']);
// Route::get('/dashboard-mhs', [DashboardMhsController::class, 'index']);

// Admin
Route::get('/dashboard-admin', [DashboardAdminController::class, 'index']);
Route::get('/dashboard-admin/tambah-mahasiswa-baru', [DashboardAdminController::class, 'tambahMahasiswaBaru']);
Route::get('/dashboard-admin/tambah-mahasiswa-baru/create', [DashboardAdminController::class, 'createMahasiswa']);

