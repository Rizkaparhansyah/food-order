<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;


// Admin
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/admin/auth', [AuthController::class, 'verify'])->name('auth.verify');
Route::get('admin/login', [AuthController::class, 'index'])->name('admin.login.index');




Route::get('/', function () {
    return view('components.hero-component');
})->name('home');

Route::get('cart', function () {
    return view('components.cart-component');
})->name('cart');

Route::get('menu', function () {
    return view('components.menu-component');
})->name('menu');

Route::get('/admin', function () {
    return view('admin.index');
})->name('admin')->middleware('auth:admin');

Route::get('/kasir', function () {
    return view('kasir.index');
})->name('kasir')->middleware('auth:kasir');

Route::get('/search', [MenuController::class, 'search'])->name('search');
// Route::post('/proses-form', [FormController::class, 'prosesForm'])->name('proses_form');