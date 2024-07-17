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
    return view('components.hero-component');
})->name('home');
Route::get('cart', function () {
    return view('components.cart-component');
})->name('cart');
Route::get('menu', function () {
    return view('components.menu-component');
})->name('menu');
