<?php

namespace App\Http\Controllers;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::all();
        dd($pesanan);
        return view('admin.orders.index', compact('pesanan'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'id_menu' => 'required|integer',
            'jumlah' => 'required|integer',
        ]);

        $validated['status'] = 'pending';

        Pesanan::create($validated);

        return response()->json(['message' => 'Pesanan berhasil dibuat'], 200);
    }
}
