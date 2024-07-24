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
        $data = Kategori::get();

    return DataTables::of($data)->make(true);
    }
}
