<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAngsuranController;
use App\Http\Controllers\DataPinjamanController;
use App\Http\Controllers\DataSimpananController;
use App\Http\Controllers\DetailAngsuranController;
use App\Http\Controllers\DetailPinjamanController;
use App\Http\Controllers\DetailSimpananController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RegisterController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::get('/forgot_password', [ForgotPasswordController::class, 'index'])->name('forgot_password');

Route::get('/main', [MainController::class, 'index'])->name('main');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/data_simpanan', [DataSimpananController::class, 'index'])->name('data_simpanan');
Route::get('/detail_simpanan', [DetailSimpananController::class, 'index'])->name('detail_simpanan');

Route::get('/data_pinjaman', [DataPinjamanController::class, 'index'])->name('data_pinjaman');
Route::get('/detail_pinjaman', [DetailPinjamanController::class, 'index'])->name('detail_pinjaman');

Route::get('/data_angsuran', [DataAngsuranController::class, 'index'])->name('data_angsuran');
Route::get('/detail_angsuran', [DetailAngsuranController::class, 'index'])->name('detail_angsuran');
