<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('components.hero-component');
})->name('home');

Route::get('cart', function () {
    return view('components.cart-component');
})->name('cart');

Route::get('menu', function () {
    return view('components.menu-component');
})->name('menu');

Route::get('/search', [MenuController::class, 'search'])->name('search');

