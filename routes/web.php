<?php

use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProvinsiController;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::resource('provinsi', ProvinsiController::class);
Route::get('/laporan-provinsi', [ProvinsiController::class, 'laporan'])->name('provinsi.laporan');
Route::resource('kabupaten', KabupatenController::class);
Route::get('/laporan-kabupaten', [KabupatenController::class, 'laporan'])->name('kabupaten.laporan');
Route::resource('penduduk', PendudukController::class);
Route::get('/penduduk/kabupaten/{provinsi}', [PendudukController::class, 'getKabupatenByProvinsi']);
