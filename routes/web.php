<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Models\Menu;
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

    Route::get('/admin/menu', [MenuController::class, 'index'])->name('list-menu');

    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('list-kategori');

    Route::get('/admin/menu/tambah', function(){
        return view('admin.menu.tambah');
    })->name('menuTambah');
    
});

// DATA
Route::get('list-kategoris', [KategoriController::class, 'kategori'])->name('data.kategori');
Route::get('list-menu', [MenuController::class, 'menu'])->name('data.menu');

Route::middleware('auth:kasir')->group(function () {
    
    Route::get('/kasir', function(){
        return view('kasir.index');
    })->name('kasir');

    Route::get('/kasir/menu', function(){
        return view('kasir.menu.index');
    })->name('menumenuKasir');

    Route::get('/kasir/menu/tambah', function(){
        return view('kasir.menu.tambah');
    })->name('menuTambahKasir');

});

Route::post('/user/auth', [AuthController::class,'checkAuth'])->name('check.auth');
Route::post('/user/auth-success', [AuthController::class,'ajaxLoginWithName'])->name('user.login');

Route::get('/', function () {
    return view('components.hero-component');
})->name('home');

Route::post('/logout-user', [AuthController::class, 'logoutUser'])->name('logout.user');


Route::get('menu', function () {
    $data = Menu::with('kategori')->get();
    return view('components.menu-component', compact('data'));
})->name('menu');



Route::get('cart', function () {
    return view('components.cart-component');
})->middleware('name.auth')->name('cart');

    //Menu
    Route::middleware('auth:admin')->group(function () {
        Route::get('/admin/menu', [MenuController::class, 'index'])->name('list-menu');
        Route::get('/admin/menu/{id}/edit', [MenuController::class, 'edit'])->name('edit-menu');
        Route::post('/admin/menu', [MenuController::class, 'store'])->name('store-menu');
        Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('update-menu');
        Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])->name('delete-menu');
    });

    // Kategori
    Route::middleware('auth:admin')->group(function () {
        Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('list-kategori');
        Route::get('list-kategoris', [KategoriController::class, 'kategori'])->name('data.kategori');
        Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/admin/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });
    
    // Checkout
    Route::post('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
    Route::get('/checkout/success', [PesananController::class, 'checkoutSuccess'])->name('checkout.success');

    Route::get('list-pesanans', [PesananController::class, 'pesanan'])->name('data.pesanan');

    // Daftar Pesanan
    Route::get('/admin/pesanan', [PesananController::class, 'index'])->name('list-pesanan');

    Route::post('/admin/pesanan/{id}/update-status', [PesananController::class, 'updateStatus']);

    Route::delete('/admin/pesanan/{id}/delete', [PesananController::class, 'delete']);
    
    // Keranjang
    Route::get('cart', [KeranjangController::class, 'index'])
        ->middleware('name.auth')
        ->name('cart');
    Route::post('/cart', [KeranjangController::class, 'addToCart'])->name('add.cart');
    Route::post('/cart/increase/{id}', [KeranjangController::class, 'increaseQuantity']);
    Route::post('/cart/decrease/{id}', [KeranjangController::class, 'decreaseQuantity']);
    Route::delete('/cart/delete/{id}', [KeranjangController::class, 'removeFromCart']);


    Route::post('/cart/{id}/delete', [KeranjangController::class, 'delete'])->name('cart.delete');
    Route::post('/cart/{id}/plus', [KeranjangController::class, 'plus'])->name('cart.plus');
    Route::post('/cart/{id}/min', [KeranjangController::class, 'min'])->name('cart.min');
    
    // Management User
    Route::get('/admin/management-user', [UserController::class, 'index'])->name('data.user');
    Route::post('/admin/management-user', [AccountController::class, 'store'])->name('store.user');

    // Order
    Route::middleware('auth:admin')->group(function () {
        Route::get('/admin/order', [OrderController::class, 'index'])->name('order');
        Route::get('/admin/order/search', [OrderController::class, 'search'])->name('order.search');
        Route::post('/admin/order/add-to-cart/{id}', [OrderController::class, 'addToCart'])->name('order.addToCart');
        Route::post('/admin/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    });

    // Bahan Baku
    //Route::get('/bahan-baku', [BahanController::class,'index'])->name('bahan-baku');

    /*use App\Http\Controllers\BahanBakuController;

    Route::get('/bahan-baku', [BahanBakuController::class, 'index'])->name('bahan.baku.index');
    Route::post('/bahan-baku/jenis', [BahanBakuController::class, 'storeJenis'])->name('bahan.baku.store.jenis');
    Route::post('/bahan-baku/subkategori', [BahanBakuController::class, 'storeSubkategori'])->name('bahan.baku.store.subkategori');
    Route::post('/bahan-baku/penggunaan', [BahanBakuController::class, 'storePenggunaan'])->name('bahan.baku.store.penggunaan');*/


    use App\Http\Controllers\BahanController;

    Route::get('/bahanbaku', [BahanController::class, 'index'])->name('bahanbaku.index');
    Route::post('/bahanbaku', [BahanController::class, 'store'])->name('bahanbaku.store');


    use App\Http\Controllers\BahanKasirController;

    Route::get('/kasir/bahanbaku', [BahanKasirController::class, 'index'])->name('kasir.bahanbaku.index');
    //Route::post('/bahanbaku', [BahanKasirController::class, 'store'])->name('bahanbaku.store');