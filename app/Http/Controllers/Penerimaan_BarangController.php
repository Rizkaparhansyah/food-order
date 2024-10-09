<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan_Barang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\File;

class Penerimaan_BarangController extends Controller
{
    public function index()
    {
        return view('admin.penerimaan_barang.index');
    }

    public function Penerimaan_Barang()
    {
        $data = Penerimaan_Barang::all();

        return DataTables::of($data)
            ->addColumn('action', function($row) {
                $editBtn = '<button class="editPenerimaan btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                $deleteBtn = '<button class="deletePenerimaan btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                $pdfBtn = '<a href="/admin/penerimaan_barang/' . $row->id . '/pdf" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i></a>';
                return $editBtn . ' ' . $deleteBtn . ' ' . $pdfBtn;
            })
            ->toJson();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'tanggal_penerimaan' => 'required|date',
            'nama_pemasok' => 'required|string',
            'nomor_faktur' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        // Hitung total harga
        $validatedData['total_harga'] = $validatedData['jumlah'] * $validatedData['harga_satuan'];

        // Simpan data baru
        Penerimaan_Barang::create($validatedData);

        return response()->json(['success' => 'Penerimaan Barang berhasil disimpan']);
    }

    public function edit($id)
    {
        $Penerimaan_Barang = Penerimaan_Barang::find($id);
        if (!$Penerimaan_Barang) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($Penerimaan_Barang);
    }


    public function update(Request $request, $id)
    {
        $Penerimaan_Barang = Penerimaan_Barang::find($id);
        if (!$Penerimaan_Barang) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $validatedData = $request->validate([
            'nama_barang' => 'required|string',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'tanggal_penerimaan' => 'required|date',
            'nama_pemasok' => 'required|string',
            'nomor_faktur' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        // Update data setelah validasi
        $validatedData['total_harga'] = $validatedData['jumlah'] * $validatedData['harga_satuan'];
        $Penerimaan_Barang->update($validatedData);

        return response()->json(['success' => 'Penerimaan Barang berhasil diperbarui']);
    }


    public function destroy($id)
    {
        $Penerimaan_Barang = Penerimaan_Barang::find($id);
        if (!$Penerimaan_Barang) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $Penerimaan_Barang->delete();
        return response()->json(['success' => 'Penerimaan Barang berhasil dihapus']);
    }


    public function generatePdf($id)
    {
        $Penerimaan_Barang = Penerimaan_Barang::find($id);
        if (!$Penerimaan_Barang) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.penerimaan_barang.pdf', compact('Penerimaan_Barang'));

        return $pdf->stream('document.pdf');
    }
}
