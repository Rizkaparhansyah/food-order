<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Pesanan;

class OrderController extends Controller
{
    public function setCustomerName(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
        ]);

        // Store the customer name in the session
        Session::put('customer_name', $request->input('nama_pelanggan'));

        return response()->json(['message' => 'Nama pemesan telah disimpan'], 200);
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'id_menu' => 'required|integer',
            'jumlah' => 'required|integer',
        ]);

        $nama_pelanggan = Session::get('customer_name');

        if (!$nama_pelanggan) {
            return response()->json(['message' => 'Nama pemesan tidak ditemukan'], 400);
        }

        $validated['nama_pelanggan'] = $nama_pelanggan;
        $validated['status'] = 'pending';

        Pesanan::create($validated);

        return response()->json(['message' => 'Pesanan berhasil dibuat'], 200);
    }

    public function index()
    {
        $pesanan = Pesanan::with('menu')->get();
        return view('admin.orders.index', compact('pesanan'));
    }
}