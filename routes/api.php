<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Api\Mahasiswa\KhsController as MahasiswaKhs;


use App\Http\Controllers\Api\IrsController;
use App\Http\Controllers\Api\Mahasiswa\KhsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/profile', function (Request $request) {
    //     return $request->user();
    // });
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/irs', IrsController::class);

    Route::get('/me',[DashboardController::class,'getMyProfile']);
    Route::get('/mahasiswa/dashboard',[MahasiswaDashboard::class,'getMyProfile']);
    Route::get('/mahasiswa/khs', [MahasiswaKhs::class,'getMyKhs']);

    Route::get('/my-irs',[DashboardController::class,'getMyIrs']);
});
