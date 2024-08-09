<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::all();
        //dd($pesanan);
        return view('admin.pesanan.index', compact('pesanan'));
    }
}
