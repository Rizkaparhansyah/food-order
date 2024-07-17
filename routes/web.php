<?php

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
Route::get('cart', function () {
    return view('components.cart-component');
});


// Admin
Route::get('/admin', function(){
    return view('admin.index');
})->name('admin');

Route::get('/admin/makanan', function(){
    return view('admin.makanan.index');
})->name('menuMakanan');

Route::get('/admin/makanan/tambah', function(){
    return view('admin.makanan.tambah');
})->name('makananTambah');