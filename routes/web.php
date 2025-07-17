<?php

use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProvinsiController;
use App\Models\Kabupaten;
use App\Models\Penduduk;
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
    $totalProvinsi = Provinsi::count();
    $totalKabupaten = Kabupaten::count();
    $totalPenduduk = Penduduk::count();
    $rataRataUmur = Penduduk::avg('umur') ?? 0;

    $pendudukTerbaru = Penduduk::with(['kabupaten'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    $topKabupaten = Kabupaten::with(['provinsi'])
        ->withCount('penduduk')
        ->orderBy('penduduk_count', 'desc')
        ->take(5)
        ->get();

    return view('dashboard.index', compact(
        'totalProvinsi',
        'totalKabupaten',
        'totalPenduduk',
        'rataRataUmur',
        'pendudukTerbaru',
        'topKabupaten'
    ));
})->name('dashboard');

Route::resource('provinsi', ProvinsiController::class);
Route::get('/laporan-provinsi', [ProvinsiController::class, 'laporan'])->name('provinsi.laporan');
Route::resource('kabupaten', KabupatenController::class);
Route::get('/laporan-kabupaten', [KabupatenController::class, 'laporan'])->name('kabupaten.laporan');
Route::resource('penduduk', PendudukController::class);
Route::get('/penduduk/kabupaten/{provinsi}', [PendudukController::class, 'getKabupatenByProvinsi']);
