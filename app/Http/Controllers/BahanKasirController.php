<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanKasirController extends Controller
{
    public function index()
    {
        $bahanBaku = BahanBaku::all();
        return view('kasir.bahanbaku.index', compact('bahanBaku'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
            'penggunaan' => 'required|string|max:255',
            'khusus' => 'boolean',
        ]);

        BahanBaku::create($validated);

        return redirect()->route('bahanbaku.index')->with('success', 'Bahan Baku added successfully');
    }
}
