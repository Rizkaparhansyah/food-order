<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index(Request $request){
        $data = Kategori::get();
        if($request->ajax()){
            $data = Menu::with('kategori:id,nama') // Mengambil hanya id dan nama dari kategori
            ->get()
            ->map(function($menu) {
                return [
                    'id' => $menu->id,
                    'nama' => $menu->nama,
                    'kategori' => $menu->kategori->nama, // Ambil nama kategori
                    'kategori_id' => $menu->kategori->id, // Ambil nama kategori
                    'deskripsi' => $menu->deskripsi,
                    'foto' => $menu->foto,
                    'stok' => $menu->stok,
                    'harga' => $menu->harga,
                    'diskon' => $menu->diskon,
                ];
            });

            return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                // Mengonversi data ke JSON
                $json_data = json_encode($data);
                // Mengganti tanda kutip ganda dengan entitas HTML
                $json_data = htmlspecialchars($json_data, ENT_QUOTES, 'UTF-8');
            
                return '<button id="edit" class="editMenu btn btn-sm btn-info" data-toggle="modal" data-data="' . $json_data . '" data-id="' . $data['id'] . '" data-nama="' . $data['nama'] . '">Edit</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('.$data['id'].')">Hapus</button>';
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.menu.index', compact('data'));
        
    }
    public function menu(Request $request){
       

    if($request->ajax()){
        $data = Menu::with('kategori')
        ->whereAny([
            'nama',
        ], 'LIKE', '%'. $request->keyword .'%')
        ->get();
        return $data;
    }

    }

    public function tambah(Request $request){
         // Validasi data
        //  dd( $request->id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'kategori' => 'required|integer',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'diskon' => 'nullable|numeric',
            'foto' => $request->id != '' ? 'nullable|file|mimes:jpg,png,pdf|max:2048' : 'required|file|mimes:jpg,png,pdf|max:2048', 
        ]);

        // Proses file yang diunggah
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(), // Kembalikan kesalahan validasi
            ], 422); // Status code 422 untuk unprocessable entity
        }
        $data = [
            'nama' => $request->get('nama'),
            'kategori_id' => $request->get('kategori'),
            'deskripsi' => $request->get('deskripsi'),
            'harga' => $request->get('harga'),
            'stok' => $request->get('stok'),
            'diskon' => $request->get('diskon'),
        ];
    
        // Jika ada file foto yang diunggah, tambahkan ke array data
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filePath = $file->store('uploads', 'public'); // Simpan file dan dapatkan pathnya
            $data['foto'] = $filePath;
        }
    
        // Periksa apakah ID ada untuk menentukan apakah ini operasi update atau create
        if ($request->id) {
            // Update data yang ada
            Menu::where('id', $request->id)->update($data);
        } else {
            // Simpan data baru
            Menu::create($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            // 'data' => $menu
        ]);
    }


    public function hapus($id){
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['errors' => 'Data tidak ditemukan!'], 404);
        }
        $menu->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
