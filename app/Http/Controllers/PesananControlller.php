<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    public function index()
    {
        return view('admin.pesanan.index');
    }

    public function pesanan()
    {
        $data = Pesanan::with('menu')
            ->selectRaw('nama_pelanggan, kode, COUNT(*) as orders_count')
            ->groupBy('nama_pelanggan', 'kode')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pelanggan' => $item->nama_pelanggan,
                    'kode' => $item->kode,
                    'orders' => Pesanan::where('nama_pelanggan', $item->nama_pelanggan)->with('menu')->get()->map(function ($order) {
                        return [
                            'nama_menu' => $order->menu->nama,
                            'harga_menu' => $order->menu->harga,
                            'jumlah' => $order->jumlah,
                            'status' => $order->status
                        ];
                    })
                ];
            });

        return DataTables::of($data)->make(true);
    }

    public function checkout(Request $request)
    {
        // Ambil nama pelanggan dan kode dari session
        $nama_pelanggan = $request->session()->get('user_name', false);
        $kode = $request->session()->get('kode', false);

        // Validasi untuk memastikan data ada
        if (!$nama_pelanggan || !$kode) {
            return redirect()->route('cart')->with('error', 'Data tidak valid. Silakan coba lagi.');
        }

        // Ambil data dari tabel keranjangs berdasarkan nama_pelanggan dan kode
        $keranjangs = Keranjang::where('nama_pelanggan', $nama_pelanggan)
            ->where('kode', $kode)
            ->get();

        // Pindahkan data dari keranjangs ke pesanans
        foreach ($keranjangs as $keranjang) {
            Pesanan::create([
                'nama_pelanggan' => $keranjang->nama_pelanggan,
                'id_menu' => $keranjang->id_menu,
                'jumlah' => 1,
                'kode' => $kode,
                'status' => 'proses',
            ]);
        }

        // Hapus data dari keranjangs setelah dipindahkan
        Keranjang::where('nama_pelanggan', $nama_pelanggan)
            ->where('kode', $kode)
            ->delete();

        // Redirect ke halaman sukses checkout
        return redirect()->route('checkout.success')->with('success', 'Checkout berhasil!');
    }



    public function checkoutSuccess()
    {
        return view('components.checkout-success');
    }
}
