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
}