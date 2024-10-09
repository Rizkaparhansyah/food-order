<?php

namespace App\Http\Controllers;

use App\Models\Pesanan_Pembelian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class Pesanan_PembelianController extends Controller
{
    // public function index()
    // {
    //     return view('admin.pesanan_pembelian.index');
    // }

    public function index()
    {
        $penerimaan_barang = Pesanan_Pembelian::all(); // Fetch all purchase orders
        return view('admin.pesanan_pembelian.index', compact('penerimaan_barang'));
    }


    public function Pesanan_Pembelian()
    {
        $data = Pesanan_Pembelian::all();

        return DataTables::of($data)
            ->addColumn('action', function($row) {
                $editBtn = '<button class="editPesanan btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                $deleteBtn = '<button class="deletePesanan btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            // ->addColumn('document', function($row) {
            //     return '<a href="'.route('admin.pesanan_pembelian.pdf', $row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i> PDF</a>';
            // })
            ->toJson();
    }

    public function store(Request $request)
    {
        // Consider adding validation rules here
        $validatedData = $request->validate([
            'nama_pemasok' => 'required|string|max:255',
            'tanggal_pesanan' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'status_pesanan' => 'required|string',
        ]);

        $Pesanan_Pembelian = Pesanan_Pembelian::create($validatedData);
        return response()->json($Pesanan_Pembelian);
    }
    
    public function edit($id){
        $Pesanan_Pembelian =Pesanan_Pembelian::find($id);
        return response()->json($Pesanan_Pembelian);
    }
    
    public function update(Request $request, $id)
    {
        // Consider adding validation rules here
        $validatedData = $request->validate([
            'nama_pemasok' => 'required|string|max:255',
            'tanggal_pesanan' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'status_pesanan' => 'required|string',
        ]);

        $Pesanan_Pembelian = Pesanan_Pembelian::find($id);
        $Pesanan_Pembelian->update($validatedData);
        return response()->json($Pesanan_Pembelian);
    }
    
    public function destroy($id){
        Pesanan_Pembelian::destroy($id);
        return response()->json(['success' => 'Penerimaan Barang berhasil dihapus']);
    }

    public function generatePdf($id)
    {
        $pesanan = Pesanan_Pembelian::find($id);

        if (!$pesanan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $pdf = Pdf::loadView('admin.pesanan_pembelian.pdf', compact('pesanan'));
        return $pdf->stream('pesanan_pembelian_'.$pesanan->id.'.pdf');
    }
}
