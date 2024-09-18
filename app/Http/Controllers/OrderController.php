<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // public function index() {
    //     return view('admin.order.index');
    // }

    public function index()
    {
        // Ambil data menu
        $data = Menu::with('kategori')->get();

        // Kembalikan tampilan dengan data menu
        return view('admin.Order.index', compact('data'));
    }

    public function search(Request $request)
    {
        // Dapatkan permintaan pencarian dari permintaan tersebut
        $query = $request->input('query');

        // Ambil data menu berdasarkan permintaan pencarian
        $data = Menu::with('kategori')
                    ->where('nama', 'like', '%' . $query . '%')
                    ->get();

        // Kembalikan tampilan dengan data menu yang difilter
        return view('admin.Order.index', compact('data'));
    }

    public function addToCart(Request $request, $id)
    {
        $menuItem = Menu::find($id);

        if (!$menuItem) {
            return redirect()->back()->with('error', 'Menu item not found');
        }

        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'name' => $menuItem->nama,
                'price' => $menuItem->harga,
                'quantity' => 1,
                'foto' => $menuItem->foto,
                'stok' => $menuItem->stok,
            ];
        }
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart');
    }

    public function checkout(Request $request)
{
    $cart = Session::get('cart', []);
    if (empty($cart)) {
        return redirect()->back()->with('error', 'Cart is empty');
    }

    // Validate the input for name and code
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'order_code' => 'required|integer',
    ]);

    // Simpan detail pesanan ke database
    foreach ($cart as $id => $item) {
        // Simpan pesanan satu per satu
        Pesanan::create([
            'nama_pelanggan' => $request->input('customer_name'),
            'kode' => $request->input('order_code'),
            'id_menu' => $id, // ID menu dari item cart
            'jumlah' => $item['quantity'],
            'status' => 'proses', // Status awal pesanan
        ]);
    }

    // Kosongkan keranjang
    Session::forget('cart');

    return redirect()->route('order')->with('success', 'Order placed successfully');
}   
}