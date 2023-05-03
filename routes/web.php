<?php

use App\Http\Controllers\DashboardDepartemenController;
use App\Http\Controllers\BerandaGuestController;
use Illuminate\Support\Facades\Route;

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

// Departemen
Route::get('/dashboard-departemen', [DashboardDepartemenController::class, 'index']);

Route::get('/dashboard-departemen/data-mahasiswa', [DashboardDepartemenController::class, 'dataMahasiswa']);

// Guest
Route::resource('/', BerandaGuestController::class);
// Mahasiswa
Route::get('/dashboard-mhs', [DashboardMhsController::class, 'index']);

