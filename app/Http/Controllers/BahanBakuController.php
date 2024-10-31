<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bahanBakus = BahanBaku::all();
        // dd($request->ajax());
        if($request->ajax()){
            // dd($bahanBakus);
            return datatables()->of($bahanBakus)
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm edit"
                        data-info="' . htmlspecialchars(json_encode([
                            'id' => $row->id,
                            'jns_bhn' => $row->jns_bhn,
                            'penggunaan_bhn' => $row->penggunaan_bhn,
                            'subkategori' => $row->subkategori,
                            'khusus' => $row->khusus,
                        ])) . '">Edit</a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" 
                        data-info="' . htmlspecialchars(json_encode([
                            'id' => $row->id,
                        ])) . '">Delete</a>';
                    return $btn;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.bahan.index');
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
        $validatedData = $request->validate([
            'idBB' => 'nullable|string',
            'jns_bhn' => 'required|string|max:255',
            'subkategori' => 'required|string',
            'penggunaan_bhn' => 'required|string|max:255',
            'khusus' => 'nullable|string',
        ]);
        $validatedData['khusus'] = $validatedData['khusus'] ?? 'off';
        $validatedData['idBB'] = $validatedData['idBB'] ?? null;

        // dd($validatedData);
        BahanBaku::updateOrCreate(
            ['id' =>  $validatedData['idBB']], // Kriteria pencarian
            $validatedData
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanBaku $bahanBaku)
    {
        $bahanBaku->delete();

        return response()->json([
           'success' => true,
           'message' => 'Data deleted successfully',
        ]);
    }
}
