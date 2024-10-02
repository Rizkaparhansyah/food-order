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
                return $editBtn . ' ' . $deleteBtn;
            })
            ->toJson();
    }



    public function store(Request $request){
        $Penerimaan_Barang = Penerimaan_Barang::create($request->all());
        return response()->json($Penerimaan_Barang);
    }
    
    public function edit($id){
        $Penerimaan_Barang =Penerimaan_Barang::find($id);
        return response()->json($Penerimaan_Barang);
    }
    
    public function update(Request $request, $id){
        $Penerimaan_Barang =Penerimaan_Barang::find($id);
        $Penerimaan_Barang->update($request->all());
        return response()->json($Penerimaan_Barang);
    }
    
    public function destroy($id){
        Penerimaan_Barang::destroy($id);
        return response()->json(['success' => 'Penerimaan Barang berhasil dihapus']);
    }

    // public function generatePdf()
    // {
    //     $data = [
    //         'title' => 'Contoh PDF',
    //         'content' => 'Ini adalah contoh isi PDF',
    //     ];

    //     $pdf = app('dompdf.wrapper');
    //     $pdf->loadView('admin.penerimaan_barang.pdf', $data);

    //     return $pdf->stream('document.pdf'); // Ini akan menampilkan PDF di browser
    // }

    public function generatePdf($id)
    {
        // Retrieve the Penerimaan_Barang record by ID
        $Penerimaan_Barang = Penerimaan_Barang::find($id);

        // Check if the record exists
        if (!$Penerimaan_Barang) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        // Pass the data to the view
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.penerimaan_barang.pdf', compact('Penerimaan_Barang'));

        return $pdf->stream('document.pdf'); // Display PDF in the browser
    }


}
    