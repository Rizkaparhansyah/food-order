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
        $data = Pesanan::with('menu:id,nama,harga')->get();
        return DataTables::of($data)
            ->addColumn('nama_menu', function ($row) {
                return $row->menu->nama;
            })
            ->addColumn('harga_menu', function ($row) {
                return $row->menu->harga;
            })
            ->addColumn('action', function ($row) {
                $expandBtn = '<button class="editKategori btn btn-success btn-sm" data-id="' . $row->id . '">...</button>';
                return $expandBtn;
            })
            ->make(true);
    }

    public function checkout(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
        ]);

        $nama_pelanggan = $request->input('nama_pelanggan');

        // Ambil data dari tabel keranjangs berdasarkan nama_pelanggan
        $keranjangs = Keranjang::where('nama_pelanggan', $nama_pelanggan)->get();

        // Pindahkan data dari keranjangs ke pesanans
        foreach ($keranjangs as $keranjang) {
            Pesanan::create([
                'nama_pelanggan' => $keranjang->nama_pelanggan,
                'id_menu' => $keranjang->id_menu,
                'jumlah' => $keranjang->kode, // Asumsikan 'kode' adalah jumlah
                'status' => 'proses',
            ]);
        }

        // Hapus data dari keranjangs setelah dipindahkan
        // Keranjang::where('nama_pelanggan', $nama_pelanggan)->delete();

        return redirect()->route('checkout.success');
    }


    public function checkoutSuccess()
    {
        return view('components.checkout-success');
    }
}
