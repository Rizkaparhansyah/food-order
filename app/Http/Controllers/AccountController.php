<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Admin::get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) {
                // Mengonversi data ke JSON
                $json_data = json_encode($data);
                // Mengganti tanda kutip ganda dengan entitas HTML
                $json_data = htmlspecialchars($json_data, ENT_QUOTES, 'UTF-8');

                return '<button id="edit" class="editMenu btn btn-sm btn-info" data-toggle="modal" data-data="' . $json_data . '" data-id="' . $data['id'] . '" data-nama="' . $data['nama'] . '">Edit</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="konfirmasiHapus('.$data['id'].')">Hapus</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        return view('admin.user.index');
    }
    public function store(Request $request)
    {
        $id = $request->id; // Ambil ID dari request jika ada

        // Validasi
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(), // Kembalikan kesalahan validasi
            ], 422); // Status code 422 untuk unprocessable entity
        }

        Admin::updateOrCreate([
            'id'   => $id,
        ],[
            'name'     => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);


        return response()->json(['success' => 'Data berhasil diproses!']);
    }

    public function delete($id){
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['errors' => 'Data tidak ditemukan!'], 404);
        }
        $admin->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}