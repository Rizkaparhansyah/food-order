<?php

namespace App\Http\Controllers;

use App\Models\PembelianBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PembelianBarangController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return DataTables::of(PembelianBarang::all())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm edit" 
                        data-info="' . htmlspecialchars(json_encode([
                            'id' => $row->id,
                            'nama_pemasok' => $row->nama_pemasok,
                            'tgl_pesanan' => $row->tgl_pesanan,
                            'nama_brg' => $row->nama_brg,
                            'jumlah' => $row->jumlah,
                            'harga_satuan' => $row->harga_satuan,
                            'total_harga' => $row->total_harga,
                            'status' => $row->status
                        ])) . '">
   
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#hapusModal'.$row->id.'" class="btn btn-danger btn-sm hapus" id="'.$row->id.'" title="Hapus" data-info="' . htmlspecialchars(json_encode([
                            'id' => $row->id,
                            'nama_pemasok' => $row->nama_pemasok,
                            'nama_brg' => $row->nama_brg,
                        ])) . '">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-success btn-sm print"  title="Print" data-info="' . htmlspecialchars(json_encode([
                            'id' => $row->id,
                            'nama_pemasok' => $row->nama_pemasok,
                            'tgl_pesanan' => $row->tgl_pesanan,
                            'nama_brg' => $row->nama_brg,
                            'jumlah' => $row->jumlah,
                            'harga_satuan' => $row->harga_satuan,
                            'total_harga' => $row->total_harga,
                            'status' => $row->status
                        ])) . '">
                            <i class="fas fa-print"></i>
                        </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            
            ->make(true);
        }
        return view('admin.pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // dd($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pesananId' => 'nullable|integer', // Pastikan pesananId bisa bernilai null
            'nama_pemasok' => 'required|string|max:255',
            'tanggal_pesanan' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga_satuan' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'status' => 'required|in:pending,diproses,selesai,dibatalkan',
        ]);
    
        // Gunakan updateOrCreate untuk memperbarui atau membuat data
        $pembelianBarang = PembelianBarang::updateOrCreate(
            ['id' => $validatedData['pesananId']], // Kriteria pencarian
            [
                'nama_pemasok' => $validatedData['nama_pemasok'],
                'tgl_pesanan' => $validatedData['tanggal_pesanan'],
                'nama_brg' => $validatedData['nama_barang'],
                'jumlah' => $validatedData['jumlah'],
                'harga_satuan' => $validatedData['harga_satuan'],
                'total_harga' => $validatedData['total_harga'],
                'status' => $validatedData['status'],
            ]
        );
    
        // Kembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil disimpan',
            'data' => $pembelianBarang
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(PembelianBarang $pembelianBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembelianBarang $pembelianBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembelianBarang $pembelianBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pembelianBarang = PembelianBarang::find($id);
        
        if ($pembelianBarang) {
            $pembelianBarang->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan.'
        ], 404);
    }

}
