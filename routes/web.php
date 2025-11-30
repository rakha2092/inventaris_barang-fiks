<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PimpinanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group dengan auth middleware saja
Route::middleware(['auth'])->group(function () {

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        
        // Kategori - CRUD Lengkap
        Route::get('/kategori', [AdminController::class, 'kategoriIndex'])->name('admin.kategori.index');
        Route::post('/kategori', [AdminController::class, 'kategoriStore'])->name('admin.kategori.store');
        Route::get('/kategori/{id}/edit', [AdminController::class, 'kategoriEdit'])->name('admin.kategori.edit');
        Route::put('/kategori/{id}', [AdminController::class, 'kategoriUpdate'])->name('admin.kategori.update');
        Route::delete('/kategori/{id}', [AdminController::class, 'kategoriDestroy'])->name('admin.kategori.destroy');
        
        // Lokasi - CRUD Lengkap
        Route::get('/lokasi', [AdminController::class, 'lokasiIndex'])->name('admin.lokasi.index');
        Route::get('/lokasi/create', [AdminController::class, 'lokasiCreate'])->name('admin.lokasi.create');
        Route::post('/lokasi', [AdminController::class, 'lokasiStore'])->name('admin.lokasi.store');
        Route::get('/lokasi/{id}/edit', [AdminController::class, 'lokasiEdit'])->name('admin.lokasi.edit');
        Route::put('/lokasi/{id}', [AdminController::class, 'lokasiUpdate'])->name('admin.lokasi.update');
        Route::delete('/lokasi/{id}', [AdminController::class, 'lokasiDestroy'])->name('admin.lokasi.destroy');
        
        // Barang - RESTful Routes
        Route::get('/barang', [AdminController::class, 'barangIndex'])->name('admin.barang.index');
        Route::get('/barang/create', [AdminController::class, 'barangCreate'])->name('admin.barang.create');
        Route::post('/barang', [AdminController::class, 'barangStore'])->name('admin.barang.store');
        Route::get('/barang/{id}/edit', [AdminController::class, 'edit'])->name('admin.barang.edit');
        Route::put('/barang/{id}', [AdminController::class, 'update'])->name('admin.barang.update');
        Route::delete('/barang/{id}', [AdminController::class, 'destroy'])->name('admin.barang.destroy');
        
        // Barang Hampir Habis
        Route::get('/barang/{id}/restock', [AdminController::class, 'showRestockForm'])->name('admin.barang.restock');
        Route::post('/barang/{id}/restock', [AdminController::class, 'processRestock'])->name('admin.barang.process-restock');
        Route::get('/barang/{id}/detail', [AdminController::class, 'showBarangDetail'])->name('admin.barang.detail');
        
        // Laporan
        Route::get('/laporan/stok', [AdminController::class, 'laporanStok']);
        Route::get('/laporan/hampir-habis', [AdminController::class, 'barangHampirHabis']);
    });

    // Petugas routes
    Route::prefix('petugas')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard']);
        Route::get('/barang-masuk', [PetugasController::class, 'barangMasuk']);
        Route::post('/barang-masuk', [PetugasController::class, 'simpanBarangMasuk']);
        Route::get('/barang-keluar', [PetugasController::class, 'barangKeluar']);
        Route::post('/barang-keluar', [PetugasController::class, 'simpanBarangKeluar']);
        Route::get('/daftar-barang', [PetugasController::class, 'daftarBarang']);
        Route::get('/detail-barang/{id}', [PetugasController::class, 'detailBarang']);
        Route::get('/riwayat/masuk', [PetugasController::class, 'riwayatBarangMasuk'])->name('petugas.riwayat.masuk');
        Route::get('/riwayat/keluar', [PetugasController::class, 'riwayatBarangKeluar'])->name('petugas.riwayat.keluar');
        Route::get('/riwayat/masuk/{id}/detail', [PetugasController::class, 'detailRiwayatMasuk'])->name('petugas.riwayat.detail-masuk');
        Route::get('/riwayat/keluar/{id}/detail', [PetugasController::class, 'detailRiwayatKeluar'])->name('petugas.riwayat.detail-keluar');
    });

    // Pimpinan routes
    Route::prefix('pimpinan')->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('pimpinan.dashboard');
        Route::get('/laporan-stok', [PimpinanController::class, 'laporanStok'])->name('pimpinan.laporan-stok');
        Route::get('/laporan-transaksi', [PimpinanController::class, 'laporanTransaksi'])->name('pimpinan.laporan-transaksi');
        Route::get('/barang-hampir-habis', [PimpinanController::class, 'barangHampirHabis'])->name('pimpinan.barang-hampir-habis');
    });
});