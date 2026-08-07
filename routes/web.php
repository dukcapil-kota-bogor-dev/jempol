<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PemohonController;
use App\Models\Pemohon; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

/**
 * Route Dashboard
 * Mengambil data untuk tabel monitoring dan statistik diagram
 */
Route::get('/dashboard', function () {
    // 1. Ambil semua data pemohon untuk keperluan tabel/list
    $pemohons = Pemohon::latest()->get(); 

    // 2. Hitung jumlah berdasarkan status pemohon untuk diagram
    $chartData = [
        'Lansia'      => Pemohon::where('status_pemohon', 'Lansia')->count(),
        'Sakit'       => Pemohon::where('status_pemohon', 'Sakit')->count(),
        'ODGJ'        => Pemohon::where('status_pemohon', 'ODGJ')->count(),
        'Disabilitas' => Pemohon::where('status_pemohon', 'Disabilitas')->count(),
        'Lainnya'     => Pemohon::where('status_pemohon', 'Lainnya')->count(),
    ];

    // 3. Urutkan dari jumlah terbanyak ke terkecil
    arsort($chartData);

    // 4. Kirim semua variabel ke view dashboard
    return view('dashboard', compact('pemohons', 'chartData'));
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Group Middleware untuk Profile dan Resource Pemohon
 */
Route::middleware(['auth', 'verified'])->group(function () {
    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Tambahan: Download DOCX
    // Diletakkan di atas Resource agar tidak bentrok dengan parameter {pemohon}
    Route::get('/pemohon/download/{id}', [PemohonController::class, 'downloadDocx'])->name('pemohon.download');

    // Route Resource untuk CRUD Pemohon (index, create, store, update, destroy)
    Route::resource('pemohon', PemohonController::class);
});

require __DIR__.'/auth.php';