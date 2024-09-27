<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::all();
        return view('admin.meja.index', compact('mejas'));
    }

    public function updateMeja($id)
    {
        $meja = Meja::findOrFail($id);
        $meja->status = 'kosong';
        $meja->kode = null;
        $meja->nama = null; 
        $meja->save();

        return redirect()->route('meja.index')->with('success', 'Meja berhasil dikosongkan');
    }
}
