<?php

use App\Http\Controllers\FacilityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KamarkosController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PenyewaController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('layouts.master');
})->middleware('auth');

Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    // Route::get('/penyewa', [PenyewaController::class, 'index'])->name('penyewa');
    Route::resource('penyewa', PenyewaController::class);
    Route::resource('kosan', KamarkosController::class);
    Route::get('/facility/checkSlug', [FacilityController::class, 'checkSlug']);
    Route::resource('facility', FacilityController::class);
    Route::resource('penyewaan', PenyewaanController::class);
});
