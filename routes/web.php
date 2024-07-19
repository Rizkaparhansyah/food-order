<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
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


// Admin
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/admin/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/admin/auth', [AuthController::class, 'verify'])->name('auth.verify');

Route::middleware('auth:admin')->group(function () {
    
    Route::get('/admin', function(){
        return view('admin.index');
    })->name('admin');

    Route::get('/admin/makanan', function(){
        return view('admin.makanan.index');
    })->name('menuMakanan');

    Route::get('/admin/makanan/tambah', function(){
        return view('admin.makanan.tambah');
    })->name('makananTambah');
    
});

Route::middleware('auth:kasir')->group(function () {
    
    Route::get('/kasir', function(){
        return view('kasir.index');
    })->name('kasir');

    Route::get('/kasir/makanan', function(){
        return view('kasir.makanan.index');
    })->name('menuMakananKasir');

    Route::get('/kasir/makanan/tambah', function(){
        return view('kasir.makanan.tambah');
    })->name('makananTambahKasir');

});

Route::post('/user/auth', [AuthController::class,'checkAuth'])->name('check.auth');
Route::post('/user/auth-success', [AuthController::class,'ajaxLoginWithName'])->name('user.login');

Route::get('/', function () {
    return view('components.hero-component');
})->name('home');

Route::post('/logout-user', [AuthController::class, 'logoutUser'])->name('logout.user');


Route::get('menu', function () {
    return view('components.menu-component');
})->name('menu');


Route::get('cart', function () {
    return view('components.cart-component');
})->middleware('name.auth')->name('cart');



