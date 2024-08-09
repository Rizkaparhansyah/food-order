<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::all();
        return view('admin.pesanans.index', compact('pesanans'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($request->items as $item) {
            Pesanan::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'id_menu' => $item['id'],
                'jumlah' => $item['quantity'],
                'status' => 'pending',
            ]);
        }

        return response()->json(['success' => true]);
    }
}
