<?php

use App\Http\Controllers\API\KosanController;
use App\Http\Controllers\API\PenyewaanController;
use App\Http\Controllers\API\PenyewaController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('kosan/create', [KosanController::class, 'create']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::get('penyewa', [PenyewaController::class, 'fetch']);
    Route::post('penyewa/create', [PenyewaController::class, 'create']);

    Route::get('penyewaan', [PenyewaanController::class, 'all']);
    Route::post('penyewaan/checkout', [PenyewaanController::class, 'checkout']);
    Route::post('penyewaan/cancel', [PenyewaanController::class, 'cancelPenyewaan']);
    Route::post('penyewaan/{id}', [PenyewaanController::class, 'update']);
    Route::get('penyewaan/cektagihan/{id}', [PenyewaanController::class, 'cekTagihan']);
});


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('kosan', [KosanController::class, 'all']);
