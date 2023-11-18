<?php

use App\Models\Operator;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\DashboardOperatorController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDepartemenController;
use App\Http\Controllers\VerifikasiController;

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
    Route::get('logout', 'logout')->name('logout');
});

Route::get('dashboardMahasiswa', [DashboardMahasiswaController::class,'dashboardMahasiswa'])->middleware(['auth','only_mahasiswa','verified'])->name('dashboardMahasiswa');
Route::get('dashboardDosen', [DashboardDosenController::class,'dashboardDosen'])->middleware(['auth','only_dosen'])->name('dashboardDosen');
Route::get('/searchMahasiswa', [DashboardDosenController::class,'searchMahasiswa'])->middleware(['auth','only_dosen'])->name('searchMhs');
Route::get('dashboardOperator', [DashboardOperatorController::class,'dashboardOperator'])->middleware(['auth','only_operator'])->name('dashboardOperator');
Route::get('dashboardDepartemen', [DashboardDepartemenController::class,'dashboardDepartemen'])->middleware(['auth','only_departemen'])->name('dashboardDepartemen');
Route::get('daftar_akun', [UserController::class,'daftar_akun'])->middleware(['auth','only_operator']);


Route::middleware(['auth', 'only_operator'])->group(function () {
    Route::get('mahasiswa-create', [OperatorController::class,'create'])->name('mahasiswa.create');
    Route::post('mahasiswa-create', [OperatorController::class,'store'])->name('mahasiswa.store');
    Route::get('/profilOperator', [OperatorController::class, 'edit'])->name('operator.edit');
    Route::get('/profilOperator-edit', [OperatorController::class, 'showEdit'])->name('operator.showEdit');
    Route::post('/profilOperator-edit', [OperatorController::class, 'update'])->name('operator.update');
    Route::get('/tambahMahasiswa',[OperatorController::class,'tambah']);
    Route::post('/tambahMahasiswa',[OperatorController::class,'import'])->name('import');
    Route::post('/generateAkun',[OperatorController::class,'generateAkun'])->name('generateAkun');
    Route::post('/dashboardOperator', [OperatorController::class,'export'])->name('export');
});

Route::middleware(['auth', 'only_dosen'])->group(function () {
    Route::get('/detail/{mahasiswa}', [DosenController::class, 'detail'])->name('detail');
    Route::get('/profilDosen', [DosenController::class, 'edit'])->name('dosen.edit');
    Route::get('/profilDosen-edit', [DosenController::class, 'showEdit'])->name('dosen.showEdit');
    Route::post('/profilDosen-edit', [DosenController::class, 'update'])->name('dosen.update');
    Route::get('/listPKL',[DosenController::class,'listPKL'])->name('listPKL');
    Route::get('/listSkripsi',[DosenController::class,'listSkripsi'])->name('listSkripsi');
    Route::get('/RekapPKL',[DosenController::class,'RekapPKL'])->name('RekapPKL');
    Route::get('/RekapSkripsi',[DosenController::class,'RekapSkripsi'])->name('RekapSkripsi');
});

Route::controller(ListController::class)->middleware(['auth', 'only_departemen'])->group(function () {
    Route::get('/listMahasiswa/{angkatan}/{status}', 'index')->name('list.index');
    Route::get('/listMahasiswaSkripsi/{angkatan}/{status}', 'skripsi')->name('list.skripsi');
    Route::get('/listMahasiswa2/{angkatan}/{status}', 'index2')->name('list.index2'); //tidak lulus
    Route::get('/listMahasiswaSkripsi2/{angkatan}/{status}', 'skripsi2')->name('list.skripsi2'); //tidak lulus
    Route::get('/DownloadListPKLDepartemenLulus/{angkatan}/{status}', 'ListPDFPKLLulus')->name('generateListPKLLulus');
    Route::get('/DownloadListPKLDepartLulus/{angkatan}/{status}','PreviewListPKLLulus')->name('PreviewListPKLLulus');
    Route::get('/DownloadListPKLDepartemeBelum/{angkatan}/{status}', 'ListPDFPKLBelum')->name('generateListPKLBelum');
    Route::get('/DownloadListPKLDepartBelum/{angkatan}/{status}','PreviewListPKLBelum')->name('PreviewListPKLBelum');
    Route::get('/DownloadListSkripsiDepartemenLulus/{angkatan}/{status}', 'ListPDFSkripsiLulus')->name('generateListSkripsiLulus');
    Route::get('/DownloadListSkripsiDepartLulus/{angkatan}/{status}','PreviewListSkripsiLulus')->name('PreviewListSkripsiLulus');
    Route::get('/DownloadListSkripsiDepartemeBelum/{angkatan}/{status}', 'ListPDFSkripsiBelum')->name('generateListSkripsiBelum');
    Route::get('/DownloadListSkripsiDepartBelum/{angkatan}/{status}','PreviewListSkripsiBelum')->name('PreviewListSkripsiBelum');
});

Route::controller(IRSController::class)->middleware(['auth', 'only_mahasiswa','verified'])->group(function () {
    Route::get('/irs', 'index')->name('irs.index');
    Route::get('/irs-create', 'create')->name('irs.create');
    Route::post('/irs-store', 'store')->name('irs.store');
    Route::post('/irs-updateStatus', 'status')->name('irs.updateStatus');
});

Route::controller(KHSController::class)->middleware(['auth', 'only_mahasiswa','verified'])->group(function () {
    Route::get('/khs', 'index')->name('khs.index');
    Route::get('/khs-create', 'create')->name('khs.create');
    Route::post('/khs-store', 'store')->name('khs.store');
});

Route::controller(PKLController::class)->middleware(['auth', 'only_mahasiswa','verified'])->group(function () {
    Route::get('/pkl', 'index')->name('pkl.index');
    Route::get('/pkl-create', 'create')->name('pkl.create');
    Route::post('/pkl-store', 'store')->name('pkl.store');
});

Route::controller(SkripsiController::class)->middleware(['auth', 'only_mahasiswa','verified'])->group(function () {
    Route::get('/skripsi', 'index')->name('skripsi.index');
    Route::get('/skripsi-create', 'create')->name('skripsi.create');
    Route::post('/skripsi-store', 'store')->name('skripsi.store');
});

Route::controller(MahasiswaController::class)->middleware(['auth', 'only_mahasiswa'])->group(function () {
    Route::get('/profilMahasiswa', 'edit')->name('mahasiswa.edit');
    Route::get('/profilMahasiswa-edit', 'showEdit')->name('mahasiswa.showEdit');
    Route::post('/profilMahasiswa-edit', 'update')->name('mahasiswa.update');
    Route::get('/editprofilMahasiswa', 'editProfil')->name('mahasiswa.editProfil')->middleware('verified');
    Route::get('/editprofilMahasiswa-show', 'showProfil')->name('mahasiswa.showProfil')->middleware('verified');
    Route::post('/editprofilMahasiswa-show', 'updateProfil')->name('mahasiswa.updateProfil')->middleware('verified');
    
});

Route::controller(VerifikasiController::class)->middleware(['auth','only_dosen'])->group(function () {
    Route::get('/showAllVerifikasi','showAll')->name('showAll');
    Route::post('/verifikasi/{nim}/{semester_aktif}','verifikasi')->name('verifikasi');
    Route::post('/rejected/{nim}/{semester_aktif}','rejected')->name('rejected');
    Route::post('/verifikasiKHS/{nim}/{semester_aktif}','verifikasiKHS')->name('verifikasiKHS');
    Route::post('/rejectedKHS/{nim}/{semester_aktif}','rejectedKHS')->name('rejectedKHS');
    Route::post('/verifikasiPKL/{nim}/{semester_aktif}','verifikasiPKL')->name('verifikasiPKL');
    Route::post('/rejectedPKL/{nim}/{semester_aktif}','rejectedPKL')->name('rejectedPKL');
    Route::post('/verifikasiSkripsi/{nim}/{semester_aktif}','verifikasiSkripsi')->name('verifikasiSkripsi');
    Route::post('/rejectedSkripsi/{nim}/{semester_aktif}','rejectedSkripsi')->name('rejectedSkripsi');
});

Route::controller(DepartemenController::class)->middleware(['auth','only_departemen'])->group(function (){
    Route::get('/RekapPKLDepartemen','RekapPKL')->name('rekapPKL');
    Route::get('/RekapSkripsiDepartemen','RekapSkripsi')->name('rekapSkripsi');
    Route::get('/DownloadRekapPKLDepartemen', 'RekapPDFPKL')->name('generateRekapPKL');
    Route::get('/DownloadRekapSkripsiDepartemen', 'RekapPDFSkripsi')->name('generateRekapSkripsi');
    Route::get('/DownloadRekapPKLDepart','PreviewPKL')->name('PreviewPKL');
    Route::get('/DownloadRekapSkripsiDepart','PreviewSkripsi')->name('PreviewSkripsi');
});