<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\DashboardOperatorController;
use App\Http\Controllers\DashboardDepartemenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\SkripsiController;
use App\Models\Operator;

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
    return view('welcome');
})->middleware('auth');

Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticate']);

Route::controller(AuthController::class)->middleware('auth')->group(function(){
    Route::get('logout', 'logout');
});

Route::get('dashboardMahasiswa', [DashboardMahasiswaController::class,'dashboardMahasiswa'])->middleware(['auth','only_mahasiswa']);
Route::get('dashboardDosen', [DashboardDosenController::class,'dashboardDosen'])->middleware(['auth','only_dosen']);
Route::get('dashboardOperator', [DashboardOperatorController::class,'dashboardOperator'])->middleware(['auth','only_operator']);
Route::get('dashboardDepartemen', [DashboardDepartemenController::class,'dashboardDepartemen'])->middleware(['auth','only_departemen']);
Route::get('daftar_akun', [UserController::class,'daftar_akun'])->middleware(['auth','only_operator']);


Route::middleware(['auth', 'only_operator'])->group(function () {
    Route::get('mahasiswa-create', [OperatorController::class,'create'])->name('mahasiswa.create');
    Route::post('mahasiswa-create', [OperatorController::class,'store'])->name('mahasiswa.store');
    Route::get('/profilOperator', [OperatorController::class, 'edit'])->name('operator.edit');
    Route::get('/profilOperator-edit', [OperatorController::class, 'showEdit'])->name('operator.showEdit');
    Route::post('/profilOperator-edit', [OperatorController::class, 'update'])->name('operator.update');
});

Route::controller(IRSController::class)->middleware(['auth', 'only_mahasiswa'])->group(function () {
    Route::get('/irs', 'index')->name('irs.index');
    Route::get('/irs-create', 'create')->name('irs.create');
    Route::post('/irs-store', 'store')->name('irs.store');
});

Route::controller(KHSController::class)->middleware(['auth', 'only_mahasiswa'])->group(function () {
    Route::get('/khs', 'index')->name('khs.index');
    Route::get('/khs-create', 'create')->name('khs.create');
    Route::post('/khs-store', 'store')->name('khs.store');
});

Route::controller(PKLController::class)->middleware(['auth', 'only_mahasiswa'])->group(function () {
    Route::get('/pkl', 'index')->name('pkl.index');
    Route::get('/pkl-create', 'create')->name('pkl.create');
    Route::post('/pkl-store', 'store')->name('pkl.store');
});

Route::controller(SkripsiController::class)->middleware(['auth', 'only_mahasiswa'])->group(function () {
    Route::get('/skripsi', 'index')->name('skripsi.index');
    Route::get('/skripsi-create', 'create')->name('skripsi.create');
    Route::post('/skripsi-store', 'store')->name('skripsi.store');
});

