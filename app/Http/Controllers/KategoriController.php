<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index(){
        return view('admin.kategori.index');
    }

    public function kategori(){
        $data = Kategori::all();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $editBtn = '<button class="editKategori btn btn-success btn-sm" data-id="'.$row->id.'">Edit</button>';
                $deleteBtn = '<button class="deleteKategori btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->make(true);
    }

    public function store(Request $request){
        $kategori = Kategori::create($request->all());
        return response()->json($kategori);
    }
    
    public function edit($id){
        $kategori = Kategori::find($id);
        return response()->json($kategori);
    }
    
    public function update(Request $request, $id){
        $kategori = Kategori::find($id);
        $kategori->update($request->all());
        return response()->json($kategori);
    }
    
    public function destroy($id){
        Kategori::destroy($id);
        return response()->json(['success' => 'Kategori deleted successfully']);
    }
}
    