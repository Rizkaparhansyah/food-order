<?php

namespace App\Http\Controllers;

use App\Models\JenisBahanBaku;
use App\Models\SubkategoriBahanBaku;
use App\Models\PenggunaanBahanBaku;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    // Tampilkan semua jenis bahan baku beserta subkategori dan penggunaannya
    public function index()
    {
        $jenisBahanBaku = JenisBahanBaku::with('subkategori')->get();
        $penggunaanBahanBaku = PenggunaanBahanBaku::all();

        return view('admin.bahan-baku.index', compact('jenisBahanBaku', 'penggunaanBahanBaku'));
    }

    // Menyimpan jenis bahan baku baru
    // Menyimpan jenis bahan baku baru
public function storeJenis(Request $request)
{
    $request->validate(['nama_jenis' => 'required|string|max:255']);

    JenisBahanBaku::create($request->all());

    return redirect()->route('bahan.baku.index')->with('success', 'Jenis bahan baku berhasil ditambahkan.');
}

// Menyimpan subkategori baru untuk jenis tertentu
public function storeSubkategori(Request $request)
{
    $request->validate([
        'nama_subkategori' => 'required|string|max:255',
        'jenis_bahan_baku_id' => 'required|exists:jenis_bahan_baku,id',
    ]);

    SubkategoriBahanBaku::create($request->all());

    return redirect()->route('bahan.baku.index')->with('success', 'Subkategori berhasil ditambahkan.');
}

// Menyimpan penggunaan bahan baku baru
public function storePenggunaan(Request $request)
{
    $request->validate([
        'nama_penggunaan' => 'required|string|max:255',
        'khusus' => 'boolean',
    ]);

    PenggunaanBahanBaku::create($request->all());

    return redirect()->route('bahan.baku.index')->with('success', 'Penggunaan bahan baku berhasil ditambahkan.');
}
}
