<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BerandaGuestController;
use App\Http\Controllers\DashboardMhsController;
use App\Http\Controllers\DashboardDosenController;
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

// Departemen
Route::get('/dashboard-departemen', [DashboardDepartemenController::class, 'index']);

Route::get('/dashboard-departemen/data-mahasiswa', [DashboardDepartemenController::class, 'dataMahasiswa']);

Route::get('/dashboard-departemen/data-mahasiswa-pkl', [DashboardDepartemenController::class, 'dataMahasiswaPkl']);

Route::get('/dashboard-departemen/data-mahasiswa-skripsi', [DashboardDepartemenController::class, 'dataMahasiswaSkripsi']);


// Dosen
Route::get('/dashboard-dosen/{dosen:nip}', [DashboardDosenController::class, 'index']);

// Guest
Route::resource('/', BerandaGuestController::class);
// Mahasiswa
Route::get('/dashboard-mhs', [DashboardMhsController::class, 'index']);

// Route::post()

