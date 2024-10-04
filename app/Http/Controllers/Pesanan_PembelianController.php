<?php

namespace App\Http\Controllers;

use App\Models\Pesanan_Pembelian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Pesanan_PembelianController extends Controller
{
    public function index()
    {
        return view('admin.pesanan_pembelian.index');
    }

    public function Pesanan_Pembelian()
    {
        $data = Pesanan_Pembelian::all();

        return DataTables::of($data)
            ->addColumn('action', function($row) {
                $editBtn = '<button class="editPesanan btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                $deleteBtn = '<button class="deletePesanan btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                return $editBtn.' '.$deleteBtn;
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        Pesanan_Pembelian::create($request->all());
        return response()->json(['message' => 'Pesanan Pembelian berhasil disimpan.']);
    }

    public function edit($id)
    {
        $pesanan = Pesanan_Pembelian::findOrFail($id);
        return response()->json($pesanan);
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan_Pembelian::findOrFail($id);
        $pesanan->update($request->all());
        return response()->json(['message' => 'Pesanan Pembelian berhasil diupdate.']);
    }

    public function destroy($id)
    {
        Pesanan_Pembelian::findOrFail($id)->delete();
        return response()->json(['message' => 'Pesanan Pembelian berhasil dihapus.']);
    }
}
