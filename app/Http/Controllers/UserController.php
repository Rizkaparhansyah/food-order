<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
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
}