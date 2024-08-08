<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\izinabsenController;
use App\Http\Controllers\IzinsakitController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\IzincutiController;
use App\Http\Controllers\DinasController;

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
    return view('login'); // Pastikan ada rute ini
}); 

Route::middleware('guest:karyawan')->group(function () {
Route::get('/', function () {
        return view('auth.login');
    })->name('login');
Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
 
});

Route::middleware('guest:users')->group(function () {
    Route::get('/panel', function () {
            return view('auth.loginadmin');
        })->name('loginadmin');
Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
     
});

Route::middleware('auth:karyawan')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    //presensi 
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    //editprofile
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{id}/updateprofile', [PresensiController::class, 'updateprofile']);
    //Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateprofile']);

    //histori
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);

    //izin
    Route::get('/presensi/izin',[PresensiController::class,'izin']);
    Route::get('/presensi/buatizin',[PresensiController::class,'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
    //cek izin
    Route::post('/presensi/pengecekanizin', [PresensiController::class, 'pengecekanizin']);

    //lokasi
    Route::get('/calender/lokasi', [PresensiController::class, 'lokasi']);

     //izinabsen
     Route::get('/izinabsen',[izinabsenController::class,'create']);
     Route::post('/izinabsen/store',[izinabsenController::class,'store']);
     Route::get('/izinabsen/{kode_izin}/edit',[izinabsenController::class,'edit']);
     Route::post('izinabsen/{kode_izin}/update',[izinabsenController::class,'update']);

     //izinsakit
     Route::get('/izinsakit',[IzinsakitController::class,'create']);
     Route::post('/izinsakit/store',[IzinsakitController::class,'store']);
     Route::get('/izinsakit/{kode_izin}/edit',[izinsakitController::class,'edit']);
     Route::post('/izinsakit/{kode_izin}/update', [IzinsakitController::class, 'update'])->name('izinsakit.update');

     //izincuti
    Route::get('/izincuti', [IzincutiController::class, 'create']);
    Route::post('/izincuti/store',[IzincutiController::class,'store']);
    Route::get('izincuti/{kode_izin}/edit', [IzincutiController::class,'edit']);
    Route::post('izincuti/{kode_izin}/update', [IzincutiController::class, 'update']);

    //showact
    Route::get('/izin/{kode_izin}/showact', [PresensiController::class, 'showact']);
    Route::get('/izin/{kode_izin}/delete', [PresensiController::class, 'deleteizin']);

    //dinas
    Route::get('/izindinas', [DinasController::class, 'create']);
    Route::post('/izindinas/store',[DinasController::class,'store']);
    Route::get('izindinas/{kode_izin}/edit', [DinasController::class,'edit']);
    Route::post('izindinas/{kode_izin}/update', [DinasController::class, 'update']);
});

Route::middleware('auth:users')->group(function () {
    Route::get('/proseslogoutadmin',[AuthController::class,'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    
    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::delete('/karyawan/{nik}/delete', [KaryawanController::class, 'delete'])->name('karyawan.delete'); 
    //dpeartment
    Route::get('/department', [DepartmentController::class, 'index']);
    Route::post('/department/store', [DepartmentController::class, 'store']);
    Route::delete('/department/{kode_dept}/delete', [DepartmentController::class, 'delete']);
    Route::post('/department/edit', [DepartmentController::class, 'edit']);
    Route::post('/department/{kode_dept}/update', [DepartmentController::class, 'update']);

    //cuti
    Route::get('/cuti',[CutiController::class,'index']);
    Route::post('/cuti/store',[CutiController::class,'store']);
    Route::post('/cuti/edit',[CutiController::class,'edit']);
    Route::post('/cuti/{kode_cuti}/update', [CutiController::class, 'update']);
    Route::delete('/cuti/{kode_cuti}/delete', [CutiController::class, 'delete']);

    //monitoring presensi
    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/tampilkanpeta', [PresensiController::class, 'tampilkanpeta']);

    //izin sakit
    Route::get('presensi/izinsakit', [PresensiController::class, 'izinsakit']);
    Route::post('presensi/approveizinsakit', [PresensiController::class, 'approveizinsakit']);
    Route::get('/presensi/{kode_izin}/batalkanzizinsakit', [PresensiController::class, 'batalkanizinsakit']);
  
    //laporan
    Route::get('/presensi/laporan', [PresensiController::class, 'laporan']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class,'cetaklaporan']);  
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('/presensi/cetakrekap', [PresensiController::class,'cetakrekap']);

    //lokasi
    Route::get('/konfigurasi/lokasikantor',[KonfigurasiController::class,'lokasikantor']);
    Route::post('/konfigurasi/updatelokasi',[KonfigurasiController::class,'updatelokasi']);

});