<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\DashboardOperatorController;
use App\Http\Controllers\DashboardDepartemenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;

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
Route::post('login', [AuthController::class, 'authenticating']);

Route::middleware('auth')->group(function(){
    Route::get('logout', [AuthController::class,'logout']);
    Route::get('dashboardMahasiswa', [DashboardMahasiswaController::class,'dashboardMahasiswa'])->middleware('only_mahasiswa');
    Route::get('dashboardDosen', [DashboardDosenController::class,'dashboardDosen'])->middleware('only_dosen');

    Route::get('dashboardOperator', [DashboardOperatorController::class,'dashboardOperator'])->middleware('only_operator');
    Route::get('mahasiswa-create', [OperatorController::class,'create'])->name('mahasiswa.create')->middleware('only_operator');
    Route::post('mahasiswa-create', [OperatorController::class,'store'])->name('mahasiswa.store')->middleware('only_operator');
    Route::get('dashboardOperator/profilOperator/{nip}', [OperatorController::class, 'edit'])->name('operator.edit')->middleware('only_operator');
    Route::post('dashboardOperator/profilOperator/{nip}/{username}', [OperatorController::class, 'update'])->name('operator.update')->middleware('only_operator');

    Route::get('dashboardDepartemen', [DashboardDepartemenController::class,'dashboardDepartemen'])->middleware('only_departemen');
    Route::get('daftar_akun', [UserController::class,'daftar_akun'])->middleware('only_operator');
});