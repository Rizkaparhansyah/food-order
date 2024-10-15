<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\BahanKasirController;
use App\Http\Controllers\Penerimaan_BarangController;
use App\Http\Controllers\Pesanan_PembelianController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\penerimaannnnn_barangController;
use App\Http\Controllers\Pesanannnnn_PembelianController;
use App\Models\Menu;
use App\Models\Meja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
    $mejas = Meja::where('status', 'kosong')->get();
    return view('components.hero-component', ['mejas' => $mejas]);
})->name('home');

Route::post('/logout-user', [AuthController::class, 'logoutUser'])->name('logout.user');


Route::get('menu', function () {
    $data = Menu::with('kategori')->get();
    $mejas = Meja::where('status', 'kosong')->get();
    return view('components.menu-component', compact('data','mejas'));
})->name('menu');

// Search menu items
Route::get('/search', function (Request $request) {
    $query = $request->input('query');
    $data = Menu::with('kategori')
        ->where('nama', 'like', "%{$query}%")
        ->get();

    return response()->json([
        'status' => 'success',
        'products' => $data
    ]);
})->name('search.menu');

Route::get('/category/{category}', function ($category) {
    $data = Menu::with('kategori')
        ->whereHas('kategori', function($query) use ($category) {
            $query->where('nama', $category);
        })
        ->get();

    return response()->json([
        'status' => 'success',
        'products' => $data
    ]);
})->name('category.menu');


Route::get('cart', function () {
    $mejas = Meja::where('status', 'kosong')->get();
    return view('components.cart-component', compact('mejas'));
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

     // Penerimaan Barang
    Route::middleware('auth:admin')->group(function () {
        Route::get('admin/penerimaan_barang', [Penerimaan_BarangController::class, 'index'])->name('admin.penerimaan_barang');
        Route::get('admin/penerimaan_barang/data', [Penerimaan_BarangController::class, 'Penerimaan_Barang'])->name('admin.penerimaan_barang.data');
        Route::post('admin/penerimaan_barang', [Penerimaan_BarangController::class, 'store'])->name('admin.penerimaan_barang.store');
        Route::get('admin/penerimaan_barang/{id}/edit', [Penerimaan_BarangController::class, 'edit'])->name('admin.penerimaan_barang.edit');
        Route::put('admin/penerimaan_barang/{id}', [Penerimaan_BarangController::class, 'update'])->name('admin.penerimaan_barang.update');
        Route::delete('admin/penerimaan_barang/{id}', [Penerimaan_BarangController::class, 'destroy'])->name('admin.penerimaan_barang.destroy');
        // Route::get('admin/penerimaan_barang/{id}/pdf', [Penerimaan_BarangController::class, 'generatePDF'])->name('admin.penerimaan_barang.pdf');
        Route::get('/admin/penerimaan_barang/{id}/pdf', [Penerimaan_BarangController::class, 'generatePdf'])->name('admin.penerimaan_barang.pdf');
        // Route::post('/admin/penerimaan_barang/verifikasi/{id}', [Penerimaan_BarangController::class, 'verifikasi'])->name('admin.penerimaan_barang.verifikasi');

    });

     // Klasifikasi Admin
    Route::get('/admin/bahanbaku', [BahanController::class, 'index'])->name('admin.bahanbaku.index');
    Route::post('/admin/bahanbaku', [BahanController::class, 'store'])->name('admin.bahanbaku.store');
    Route::get('/admin/bahanbaku/{id}/edit', [BahanController::class, 'edit'])->name('admin.bahanbaku.edit');
    Route::put('/admin/bahanbaku/{id}', [BahanController::class, 'update'])->name('admin.bahanbaku.update');
    Route::delete('/admin/bahanbaku/{id}', [BahanController::class, 'destroy'])->name('admin.bahanbaku.destroy');

    // Bahan Baku KASIR
    Route::get('/kasir/bahanbaku', [BahanKasirController::class, 'index'])->name('kasir.bahanbaku.index');
    //Route::post('/bahanbaku', [BahanKasirController::class, 'store'])->name('bahanbaku.store');

     // Meja
    Route::get('/admin/meja', [MejaController::class, 'index'])->name('meja.index');
    Route::put('/mejas/{id}', [MejaController::class, 'updateMeja'])->name('meja.update');

    

Route::prefix('admin')->group(function () {
    Route::get('Barang', [BarangController::class, 'index'])->name('Barang.index');
    Route::get('Barang/data', [BarangController::class, 'dataBarang'])->name('data.Barang');
    Route::post('Barang', [BarangController::class, 'store'])->name('Barang.store');
    Route::get('Barang/{id}/edit', [BarangController::class, 'edit'])->name('Barang.edit');
    Route::put('Barang/{id}', [BarangController::class, 'update'])->name('Barang.update');
    Route::delete('Barang/{id}', [BarangController::class, 'destroy'])->name('Barang.destroy');
});



 // Pesanan Pembelian/
Route::middleware('auth:admin')->group(function () {
    Route::get('admin/pesanan_pembelian', [Pesanan_PembelianController::class, 'index'])->name('admin.pesanan_pembelian');
    Route::get('admin/pesanan_pembelian/data', [Pesanan_PembelianController::class, 'pesanan_pembelian'])->name('admin.pesanan_pembelian.data');
    Route::post('admin/pesanan_pembelian', [Pesanan_PembelianController::class, 'store'])->name('admin.pesanan_pembelian.store');
    Route::get('admin/pesanan_pembelian/{id}/edit', [Pesanan_PembelianController::class, 'edit'])->name('admin.pesanan_pembelian.edit');
    Route::put('admin/pesanan_pembelian/{id}', [Pesanan_PembelianController::class, 'update'])->name('admin.pesanan_pembelian.update');
    Route::delete('admin/pesanan_pembelian/{id}', [Pesanan_PembelianController::class, 'destroy'])->name('admin.pesanan_pembelian.destroy');
    Route::get('/admin/pesanan_pembelian/{id}/pdf', [Pesanan_PembelianController::class, 'generatePdf'])->name('admin.pesanan_pembelian.pdf');
});

// Route::prefix('admin')->group(function () {
//     // Routes for Pesanannnnn_PembelianController
//     Route::get('penerimaannnn_barang', [Penerimaannnnn_BarangController::class, 'index'])->name('admin.penerimaannnn_barang.index');
//     Route::get('penerimaannnn_barang/create', [Penerimaannnnn_BarangController::class, 'create'])->name('admin.penerimaannnn_barang.create');
//     Route::post('penerimaannnn_barang', [Penerimaannnnn_BarangController::class, 'store'])->name('admin.penerimaannnn_barang.store');
// });

Route::prefix('admin')->group(function () {
    Route::get('penerimaannnn_barang', [Penerimaannnnn_BarangController::class, 'index'])->name('admin.penerimaannnn_barang.index');
    Route::get('penerimaannnn_barang/data', [Penerimaannnnn_BarangController::class, 'penerimaannnn_barang'])->name('admin.penerimaannnn_barang.data');
    Route::get('penerimaannnn_barang/create', [Penerimaannnnn_BarangController::class, 'create'])->name('admin.penerimaannnn_barang.create');
    Route::post('penerimaannnn_barang', [Penerimaannnnn_BarangController::class, 'store'])->name('admin.penerimaannnn_barang.store');
    Route::get('penerimaannnn_barang/{id}', [Penerimaannnnn_BarangController::class, 'show'])->name('admin.penerimaannnn_barang.show');
    Route::get('penerimaannnn_barang/{id}/edit', [Penerimaannnnn_BarangController::class, 'edit'])->name('admin.penerimaannnn_barang.edit');
    Route::put('penerimaannnn_barang/{id}', [Penerimaannnnn_BarangController::class, 'update'])->name('admin.penerimaannnn_barang.update');
    Route::delete('penerimaannnn_barang/{id}', [Penerimaannnnn_BarangController::class, 'destroy'])->name('admin.penerimaannnn_barang.destroy');
    Route::get('penerimaannnn_barang/{id}/pdf', [Penerimaannnnn_BarangController::class, 'generatePdf'])->name('admin.penerimaannnn_barang.pdf');
});

Route::prefix('admin')->group(function () {
    Route::get('pesanannnnn_pembelian', [Pesanannnnn_PembelianController::class, 'index'])->name('admin.pesanannnnn_pembelian.index');
    Route::get('pesanannnnn_pembelian/data', [Pesanannnnn_PembelianController::class, 'Pesanannnnn_Pembelian'])->name('admin.pesanannnnn_pembelian.data');
    Route::get('pesanannnnn_pembelian/create', [Pesanannnnn_PembelianController::class, 'create'])->name('admin.pesanannnnn_pembelian.create');
    Route::post('pesanannnnn_pembelian', [Pesanannnnn_PembelianController::class, 'store'])->name('admin.pesanannnnn_pembelian.store');
    Route::get('pesanannnnn_pembelian/{id}', [Pesanannnnn_PembelianController::class, 'show'])->name('admin.pesanannnnn_pembelian.show');
    Route::get('pesanannnnn_pembelian/{id}/edit', [Pesanannnnn_PembelianController::class, 'edit'])->name('admin.pesanannnnn_pembelian.edit');
    Route::put('pesanannnnn_pembelian/{id}', [Pesanannnnn_PembelianController::class, 'update'])->name('admin.pesanannnnn_pembelian.update');
    Route::delete('pesanannnnn_pembelian/{id}', [Pesanannnnn_PembelianController::class, 'destroy'])->name('admin.pesanannnnn_pembelian.destroy');
    Route::get('pesanannnnn_pembelian/{id}/pdf', [Pesanannnnn_PembelianController::class, 'generatePdf'])->name('admin.pesanannnnn_pembelian.pdf');
});
