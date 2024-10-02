<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    // Menampilkan halaman index barang
    public function index()
    {
        return view('admin.barang.index');
    }

    // Mendapatkan data barang untuk DataTables
    public function dataBarang()
    {
        $barang = Barang::select(['id', 'nama_barang', 'jumlah', 'harga_satuan', 'total_harga', 'tanggal_penerimaan', 'nama_pemasok', 'nomor_faktur', 'lokasi']);
        return DataTables::of($barang)
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-success editBarang" data-id="' . $row->id . '">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBarang" data-id="' . $row->id . '">Hapus</button>
                ';
            })
            ->make(true);
    }

    // Menyimpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'tanggal_penerimaan' => 'required|date',
            'nama_pemasok' => 'required',
            'nomor_faktur' => 'required',
            'lokasi' => 'required',
        ]);

        Barang::create($request->all());
        
        return response()->json(['success' => 'Barang berhasil ditambahkan']);
    }

    // Mendapatkan data barang untuk edit
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return response()->json($barang);
    }

    // Mengupdate barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'tanggal_penerimaan' => 'required|date',
            'nama_pemasok' => 'required',
            'nomor_faktur' => 'required',
            'lokasi' => 'required',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return response()->json(['success' => 'Barang berhasil diperbarui']);
    }

    // Menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return response()->json(['success' => 'Barang berhasil dihapus']);
    }
}
