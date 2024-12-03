<?php

namespace App\Http\Controllers;

use App\Models\PembelianBarang;
use App\Models\PenerimaanBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return DataTables::of(PenerimaanBarang::all())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm edit" 
                        data-info="' . htmlspecialchars(json_encode([
                            'id' => $row->id,
                            'nama_pemasok' => $row->nama_pemasok,
                            'tgl_penerimaan' => $row->tgl_penerimaan,
                            'nama_brg' => $row->nama_brg,
                            'jumlah' => $row->jumlah,
                            'harga_satuan' => $row->harga_satuan,
                            'total_harga' => $row->total_harga,
                            'status' => $row->status,
                            'no_faktur' => $row->no_faktur,
                            'lok_penyimpanan' => $row->lok_penyimpanan,
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
                            'tgl_penerimaan' => $row->tgl_penerimaan,
                            'nama_brg' => $row->nama_brg,
                            'jumlah' => $row->jumlah,
                            'harga_satuan' => $row->harga_satuan,
                            'total_harga' => $row->total_harga,
                            'status' => $row->status,
                            'no_faktur' => $row->no_faktur,
                            'lok_penyimpanan' => $row->lok_penyimpanan,
                        ])) . '">
                            <i class="fas fa-print"></i>
                        </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            
            ->make(true);
        }
        $pesananPembelian = PembelianBarang::where('status', 'diproses')->get();
        return view('admin.penerimaan.index', compact('pesananPembelian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->pesanan_pembelian_id);
        $validatedData = $request->validate([
            'penerimaanId' => 'nullable|integer',
            'nama_barang' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer',
            'harga_satuan' => 'nullable|numeric',
            'total_harga' => 'nullable|numeric',
            'tgl_penerimaan' => 'nullable|date',
            'nama_pemasok' => 'nullable|string|max:255',
            'nomor_faktur' => 'nullable|integer',
            'lokasi' => 'nullable|string|max:255',
        ]);
 // Gunakan updateOrCreate untuk memperbarui atau membuat data
        $penerimaanBarang = PenerimaanBarang::updateOrCreate(
            ['id' => $validatedData['penerimaanId']], // Kriteria pencarian
            [
                'nama_brg' => $validatedData['nama_barang'],
                'jumlah' => $validatedData['jumlah'],
                'harga_satuan' => $validatedData['harga_satuan'],
                'total_harga' => $validatedData['total_harga'],
                'tgl_penerimaan' => $validatedData['tgl_penerimaan'],
                'nama_pemasok' => $validatedData['nama_pemasok'],
                'no_faktur' => $validatedData['nomor_faktur'],
                'lok_penyimpanan' => $validatedData['lokasi'],
            ]
        );

        $dataUpdate = PembelianBarang::find($request->pesanan_pembelian_id);
        $dataUpdate->status = 'selesai';
        $dataUpdate->save();


        // Kembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil disimpan',
            'data' => $penerimaanBarang
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PenerimaanBarang $penerimaanBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenerimaanBarang $penerimaanBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenerimaanBarang $penerimaanBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenerimaanBarang $penerimaanBarang)
    {
        $penerimaanBarang->delete();

        return response()->json([
           'success' => true,
           'message' => 'Data berhasil dihapus'
        ]);
    }
}
