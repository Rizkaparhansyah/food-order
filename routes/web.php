<?php

use App\Http\Controllers\AcountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\DaftarPesanan;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PembelianBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PenjualanController;
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

    //DaftarPesananController
    Route::get('/admin/daftar-pesanan', [DaftarPesanan::class, 'index'])->name('pesanan.list');
    Route::post('/admin/daftar-pesanan/aksi', [DaftarPesanan::class, 'aksi'])->name('pesanan.aksi');
    Route::post('/admin/daftar-pesanan/aksi-perdata', [DaftarPesanan::class, 'perData'])->name('pesanan.aksi-perdata');

    //MenuController

        Route::get('/admin/menu', [MenuController::class, 'index'])->name('list.menu');
        Route::post('/admin/menu/tambah', [MenuController::class, 'tambah'])->name('menu.tambah');
        Route::delete('/admin/menu-hapus/{id}', [MenuController::class, 'hapus'])->name('hapus.menu');

    //KategoriesController

    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('list.kategori');
    Route::post('/admin/kategori-tambah', [KategoriController::class, 'tambah'])->name('tambah.kategori');
    Route::delete('/admin/kategori-hapus/{id}', [KategoriController::class, 'hapus'])->name('hapus.kategori');

    Route::get('/admin/data-penjualan',[PenjualanController::class,'index'])->name('data.penjualan');
//OrderController
    Route::get('/admin/order',[OrderController::class,'index'])->name('order.index');

//AcountController
    Route::get('/admin/management-user',[AcountController::class,'index'])->name('data.user');
    Route::post('/admin/tambah-user',[AcountController::class,'tambah'])->name('tambah.user');
    Route::delete('/admin/user-hapus/{id}',[AcountController::class,'delete'])->name('delete.user');


// PembelianBarang
Route::resource('pembelian-barang', PembelianBarangController::class, [
    'names' => [
        'index' => 'admin.pembelian.index',
        'create' => 'admin.pembelian.create',
        'store' => 'admin.pembelian.store',
        'show' => 'admin.pembelian.show',
        'edit' => 'admin.pembelian.edit',
        'update' => 'admin.pembelian.update',
        'destroy' => 'admin.pembelian.destroy',
    ]
]);

// PenerimaanBarang
Route::resource('penerimaan-barang', PenerimaanBarangController::class, [
    'names' => [
        'index' => 'admin.penerimaan.index',
        'create' => 'admin.penerimaan.create',
        'store' => 'admin.penerimaan.store',
        'show' => 'admin.penerimaan.show',
        'edit' => 'admin.penerimaan.edit',
        'update' => 'admin.penerimaan.update',
        'destroy' => 'admin.penerimaan.destroy',
    ]
]);

// BahanBaku
Route::resource('bahan-baku', BahanBakuController::class, [
    'names' => [
        'index' => 'admin.bahan.index',
        'create' => 'admin.bahan.create',
        'store' => 'admin.bahan.store',
        'show' => 'admin.bahan.show',
        'edit' => 'admin.bahan.edit',
        'update' => 'admin.bahan.update',
        'destroy' => 'admin.bahan.destroy',
    ]
]);

});

// DATA USER
Route::get('list-kategoris', [KategoriController::class, 'kategori'])->name('data.kategori');
Route::get('list-menu', [MenuController::class, 'menu'])->name('data.menu');

Route::middleware('auth:kasir')->group(function () {
    
    Route::get('/kasir', function(){
        return view('admin.index');
    })->name('kasir');

    //DaftarPesananController
    Route::get('/kasir/daftar-pesanan', [DaftarPesanan::class, 'index'])->name('kasir.pesanan.list');
    Route::post('/kasir/daftar-pesanan/aksi', [DaftarPesanan::class, 'aksi'])->name('kasir.pesanan.aksi');
    Route::post('/kasir/daftar-pesanan/aksi-perdata', [DaftarPesanan::class, 'perData'])->name('kasir.pesanan.aksi-perdata');

    //MenuController

        Route::get('/kasir/menu', [MenuController::class, 'index'])->name('kasir.list.menu');
        Route::post('/kasir/menu/tambah', [MenuController::class, 'tambah'])->name('kasir.menu.tambah');
        Route::delete('/kasir/menu-hapus/{id}', [MenuController::class, 'hapus'])->name('kasir.hapus.menu');

    //KategoriesController

    Route::get('/kasir/kategori', [KategoriController::class, 'index'])->name('kasir.list.kategori');
    Route::post('/kasir/kategori-tambah', [KategoriController::class, 'tambah'])->name('kasir.tambah.kategori');
    Route::delete('/kasir/kategori-hapus/{id}', [KategoriController::class, 'hapus'])->name('kasir.hapus.kategori');

    Route::get('/kasir/data-penjualan',[PenjualanController::class,'index'])->name('kasir.data.penjualan');
//OrderController
    Route::get('/kasir/order',[OrderController::class,'index'])->name('kasir.order.index');

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



//KeranjangController
Route::get('cart', [KeranjangController::class, 'index'])->middleware('name.auth')->name('cart');
Route::get('cart/get', [KeranjangController::class, 'index'])->name('cart.get');
Route::post('cart/add', [KeranjangController::class, 'addCart'])->name('cart.add');
Route::post('cart/del', [KeranjangController::class, 'clearCart'])->name('cart.del');
Route::post('/cart/update', [KeranjangController::class, 'updateCart'])->name('cart.update');

//DaftarPesananController
Route::post('checkout', [DaftarPesanan::class, 'checkout'])->name('checkout');
Route::get('/status-pesanan',[DaftarPesanan::class,'status'])->name('status.user');