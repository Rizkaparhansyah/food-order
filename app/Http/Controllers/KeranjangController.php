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
        // Ambil id_menu dari request
        $id_menu = $request->input('id_menu');

        // Ambil nama pelanggan dan kode dari session
        $nama_pelanggan = $request->session()->get('user_name', false);
        $kode = $request->session()->get('kode', false);

        // Validasi jika nama pelanggan atau kode tidak ada di session
        if (!$nama_pelanggan || !$kode) {
            return response()->json(['error' => 'User not logged in or session invalid'], 400);
        }

        // Tambahkan item ke keranjang
        Keranjang::create([
            'id_menu' => $id_menu,
            'jumlah' => 1,
            'nama_pelanggan' => $nama_pelanggan,
            'kode' => $kode,
        ]);

        return response()->json(['success' => 'Item added to cart'], 200);
    }

    public function delete($id)
    {
        $nama_pelanggan = session()->get('user_name', false);
        $kode = session()->get('kode', false);

        if (!$nama_pelanggan || !$kode) {
            return redirect()->route('cart')->with('error', 'Data tidak valid. Silakan coba lagi.');
        }

        // Cari item keranjang berdasarkan ID dan pastikan cocok dengan pelanggan dan kode
        $keranjang = Keranjang::where('id', $id)
            ->where('nama_pelanggan', $nama_pelanggan)
            ->where('kode', $kode)
            ->first();

        if (!$keranjang) {
            return redirect()->route('cart')->with('error', 'Item keranjang tidak ditemukan.');
        }

        // Hapus item keranjang
        $keranjang->delete();

        return redirect()->route('cart')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
