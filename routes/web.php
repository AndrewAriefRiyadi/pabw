<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CookiesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\UserController;
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
Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['middleware' => ['role:user|admin']], function () {
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/edit/{id}', [UserController::class, 'update'])->name('user.update');
    });


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
    Route::put('/pesanan/{username}', [PesananController::class, 'diterima'])->name('pesanan.diterima');
    Route::get('/pesanan/{username}/toko', [PesananController::class, 'show_toko'])->name('pesanan.show_toko');

    Route::put('/kurir/barang', [KurirController::class, 'update_status'])->name('kurir.update_status');

    Route::group(['middleware' => ['role:kurir']], function () {
        Route::get('/kurir/barang', [KurirController::class, 'show_barang'])->name('kurir.show_barang');
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/edit/{id}', [AdminController::class, 'edit_user'])->name('admin.edit_user');
        Route::put('/admin/users/edit/{id}', [AdminController::class, 'update_user'])->name('admin.update_user');
        Route::post('/admin/users/edit/{id}/restore', [AdminController::class, 'restore_user'])->name('admin.edit_user');
        Route::get('/admin/users/create', [AdminController::class, 'create_user'])->name('admin.create_user');
        Route::post('/admin/users/create', [AdminController::class, 'insert_user'])->name('admin.insert_user');
        Route::put('/admin/updateSaldo', [AdminController::class, 'updateSaldo'])->name('admin.updateSaldo');
        Route::delete('/admin/users/edit/{id}', [AdminController::class, 'suspend_user'])->name('admin.suspend_user');

        Route::get('/admin/produks', [AdminController::class, 'produks'])->name('admin.produks');
        Route::get('/admin/produks/create', [AdminController::class, 'create_produk'])->name('admin.create_produk');
        Route::post('/admin/produks/create', [AdminController::class, 'store_produk'])->name('admin.store_produk');
        Route::get('/admin/produks/edit/{id}', [AdminController::class, 'edit_produk'])->name('admin.edit_produk');
        Route::put('/admin/produks/edit/{id}', [AdminController::class, 'update_produk'])->name('admin.update_produk');
    });
});

Route::get('/tes', function () {
    return view('index');
});

// Route::get('/set-cookie', [CookiesController::class, 'setCookie']);
Route::get('/get-cookie', [CookiesController::class, 'getCookie']);
Route::get('/del-cookie', [CookiesController::class, 'deleteCookie']);

require __DIR__ . '/auth.php';

Auth::routes();
