<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index(){
        return view('admin.kategori.index');
    }

    public function kategori(){
        $data = Kategori::get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($data){
            return '<button id="edit" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalTambah" data-id="'.$data->id.'" data-nama="'.$data->nama.'" data-deskripsi="'.$data->deskripsi.'">Edit</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('.$data->id.')">Hapus</button>';
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }
    public function tambah(Request $request)
    {
        // dd($request);
        $id = $request->id; // Ambil ID dari request jika ada

        // Validasi
        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                Rule::unique('kategoris')->ignore($id), // Validasi unik, kecuali untuk ID yang diabaikan
            ],
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(), // Kembalikan kesalahan validasi
            ], 422); // Status code 422 untuk unprocessable entity
        }

        Kategori::updateOrCreate([
            'id'   => $id,
        ],[
            'nama'     => $request->get('nama'),
            'deskripsi' => $request->get('deskripsi'),
        ]);
           

        return response()->json(['success' => 'Data berhasil diproses!']);
    }
    
    public function hapus($id){
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['errors' => 'Data tidak ditemukan!'], 404);
        }
        $kategori->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
