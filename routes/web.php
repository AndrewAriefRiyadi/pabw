<?php

use App\Http\Controllers\CookiesController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KurirController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [CookiesController::class, 'setCookie']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/produk/{username}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{username}/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::Post('/produk/{username}/create', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{username}/{id}', [ProdukController::class, 'show_produk'])->name('produk.show_produk');
    Route::get('/produk/{username}/{id}/edit', [ProdukController::class, 'edit_produk'])->name('produk.edit_produk');
    Route::put('/produk/{username}/{id}/edit', [ProdukController::class, 'update_produk'])->name('produk.update_produk');
    Route::delete('/produk/{username}/{id}/edit', [ProdukController::class, 'delete_produk'])->name('produk.delete_produk');

    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::get('/keranjang/{username}', [KeranjangController::class, 'show'])->name('keranjang.show');
    Route::delete('/keranjang/{username}', [KeranjangController::class, 'delete_produk'])->name('keranjang.delete_produk');
    Route::put('/keranjang/{username}/kurang', [KeranjangController::class, 'kurang_produk'])->name('keranjang.kurang_produk');
    Route::put('/keranjang/{username}/tambah', [KeranjangController::class, 'tambah_produk'])->name('keranjang.tambah_produk');

    Route::post('/pesanan/{username}', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{username}', [PesananController::class, 'show'])->name('pesanan.show');

    Route::get('/kurir/barang', [KurirController::class, 'show_barang'])->name('kurir.show_barang');
    Route::put('/kurir/barang', [KurirController::class, 'update_status'])->name('kurir.update_status');
});

// Route::get('/set-cookie', [CookiesController::class, 'setCookie']);
Route::get('/get-cookie', [CookiesController::class, 'getCookie']);
Route::get('/del-cookie', [CookiesController::class, 'deleteCookie']);

require __DIR__ . '/auth.php';
