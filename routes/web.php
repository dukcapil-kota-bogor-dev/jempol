<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\GoesToSchoolController;
use App\Http\Controllers\lsmController;

use App\Models\Pemohon;
use App\Models\GoesToSchool;
use App\Models\lsm;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Route Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('login');
});


/*
|--------------------------------------------------------------------------
| Route Dashboard
|--------------------------------------------------------------------------
| Dashboard mengambil data dari:
| 1. JEMPOL / Pemohon
| 2. Go To School
| 3. LSM
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    // =========================
    // DATA JEMPOL / PEMOHON
    // =========================
    $pemohons = Pemohon::latest()->get();

    // Statistik JEMPOL
    $chartData = [
        'Lansia'      => Pemohon::where('status_pemohon', 'Lansia')->count(),
        'Sakit'       => Pemohon::where('status_pemohon', 'Sakit')->count(),
        'ODGJ'        => Pemohon::where('status_pemohon', 'ODGJ')->count(),
        'Disabilitas' => Pemohon::where('status_pemohon', 'Disabilitas')->count(),
        'Lainnya'     => Pemohon::where('status_pemohon', 'Lainnya')->count(),
    ];


    // =========================
    // DATA GOES TO SCHOOL
    // =========================
    $goestoschool = GoesToSchool::latest()->get();

// Statistik GOES TO SCHOOL
   $chartDataGoesToSchool = [
        'Terekam'                => $goestoschool->sum('terekam'),
        'Gagal Terekam'          => $goestoschool->sum('terekam_gagal'),
        'Kurang Dari 16 Tahun'   => $goestoschool->sum('kurang_dari_16_tahun'),
        'Sudah Punya KTP'        => $goestoschool->sum('sudah_punya'),
        'Tidak Hadir'            => $goestoschool->sum('tidak_hadir'),
        'Aktivasi IKD'           => $goestoschool->sum('aktivasi ikd'),
    ];

    // =========================
    // DATA LSM
    // =========================
    $lsm = lsm::latest()->get();

 // Statistik LSM
    $chartDataLSM = [
        'Terekam'         => $lsm->sum('terekam'),
        'Gagal Rekam'   => $lsm->sum('Rekam_gagal'),
        'Sudah Punya KTP' => $lsm->sum('sudah_punya'),
        'Tidak Hadir'     => $lsm->sum('tidak_hadir'),
    ];    

    // =========================
    // KIRIM SEMUA DATA
    // KE dashboard.blade.php
    // =========================
    return view('dashboard', compact(
        'pemohons',
        'chartData',
        'goestoschool',
        'chartDataGoesToSchool',
        'lsm',
        'chartDataLSM'
    ));

})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Route Profile dan CRUD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // =========================
    // PROFILE
    // =========================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // =========================
    // JEMPOL / PEMOHON
    // =========================

    // Download DOCX Pemohon
    Route::get('/pemohon/download/{id}', [PemohonController::class, 'downloadDocx'])
        ->name('pemohon.download');

    // CRUD Pemohon
    Route::resource('pemohon', PemohonController::class);


    // =========================
    // GO TO SCHOOL
    // =========================

    // Download DOCX Go To School
    Route::get('/goes_to_school/download/{id}', [GoesToSchoolController::class, 'downloadDocx'])
        ->name('goes_to_school.download');

    // CRUD Go To School
    Route::resource('goes_to_school', GoesToSchoolController::class);


    // =========================
    // LSM
    // =========================

    // Download DOCX LSM
    Route::get('/lsm/download/{id}', [lsmController::class, 'downloadDocx'])
        ->name('lsm.download');

    // CRUD LSM
    Route::resource('lsm', lsmController::class)->except(['show']);

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';