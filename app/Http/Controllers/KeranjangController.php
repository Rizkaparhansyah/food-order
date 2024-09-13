<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $nama_pelanggan = $request->session()->get('user_name', false);
        $kode = $request->session()->get('kode', false);

        if (!$nama_pelanggan || !$kode) {
            return redirect()->route('/')->with('error', 'Silakan login terlebih dahulu');
        }

        $keranjangs = Keranjang::where('nama_pelanggan', $nama_pelanggan)
            ->where('kode', $kode)
            ->with('menu')
            ->get();

        return view('components.cart-component', compact('keranjangs'));
    }

    public function addToCart(Request $request)
    {
        $id_menu = $request->input('id_menu');
        $nama_pelanggan = $request->session()->get('user_name', false);
        $kode = $request->session()->get('kode', false);

        if (!$nama_pelanggan || !$kode) {
            return response()->json(['error' => 'User not logged in or session invalid'], 400);
        }

        // Periksa apakah barang sudah ada di keranjang
        $keranjang = Keranjang::where('id_menu', $id_menu)
            ->where('nama_pelanggan', $nama_pelanggan)
            ->where('kode', $kode)
            ->first();

        if ($keranjang) {
            // Update quantity jika item sudah ada
            $keranjang->jumlah += 1;
            $keranjang->save();
        } else {
            // Add item baru ke keranjang
            Keranjang::create([
                'id_menu' => $id_menu,
                'nama_pelanggan' => $nama_pelanggan,
                'kode' => $kode,
                'jumlah' => 1,
            ]);
        }

        return response()->json(['success' => 'Item added to cart'], 200);
    }

    public function increaseQuantity($id)
{
    $keranjang = Keranjang::findOrFail($id);

    // Tingkatkan quantity sebanyak 1
    $keranjang->jumlah += 1;
    $keranjang->save();

    return response()->json(['success' => 'Quantity increased'], 200);
}

public function decreaseQuantity($id)
{
    $keranjang = Keranjang::findOrFail($id);

    // Pastikan jumlahnya tidak kurang dari 1
    if ($keranjang->jumlah > 1) {
        $keranjang->jumlah -= 1;
        $keranjang->save();
    }

    return response()->json(['success' => 'Quantity decreased'], 200);
}

public function removeFromCart($id)
{
    $keranjang = Keranjang::findOrFail($id);
    $keranjang->delete();

    return response()->json(['success' => 'Item removed from cart'], 200);
}

}