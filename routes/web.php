<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CookiesController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/', [CookiesController::class, 'setCookie']);
Route::get('/', [AppController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/set-cookie', [CookiesController::class, 'setCookie']);
Route::get('/get-cookie', [CookiesController::class, 'getCookie']);
Route::get('/del-cookie', [CookiesController::class, 'deleteCookie']);

require __DIR__ . '/auth.php';
