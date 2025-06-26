<?php

use App\Http\Controllers\DetailPenjualanProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'role:Admin')->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori_tambah', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk_tambah', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/penjualan_tambah', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/{penjualan}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::get('/penjualan/{penjualan}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::put('/penjualan/{penjualan}', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::delete('/penjualan/{penjualan}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    Route::get('/detail_penjualan_produk_tambah', [DetailPenjualanProdukController::class, 'create'])->name('detail_penjualan_produk.create');
    Route::post('/detail_penjualan_produk', [DetailPenjualanProdukController::class, 'store'])->name('detail_penjualan_produk.store');
    Route::get('/detail_penjualan_produk/{detailPenjualanProduk}', [DetailPenjualanProdukController::class, 'show'])->name('detail_penjualan_produk.show');
    Route::get('/detail_penjualan_produk/{detailPenjualanProduk}/edit', [DetailPenjualanProdukController::class, 'edit'])->name('detail_penjualan_produk.edit');
    Route::put('/detail_penjualan_produk/{detailPenjualanProduk}', [DetailPenjualanProdukController::class, 'update'])->name('detail_penjualan_produk.update');
    Route::delete('/detail_penjualan_produk/{detailPenjualanProduk}', [DetailPenjualanProdukController::class, 'destroy'])->name('detail_penjualan_produk.destroy');

    Route::get('/laporan/profit', [LaporanController::class, 'showProfitReport'])->name('laporan.profit');

   
});
Route::middleware('auth')->group(function () {
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/detail_penjualan_produk', [DetailPenjualanProdukController::class, 'index'])->name('detail_penjualan_produk.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
