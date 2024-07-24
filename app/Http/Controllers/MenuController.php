<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index(){
        return view('admin.menu.index');
    }
    public function menu(){
        $data = Menu::with('kategori:id,nama') // Mengambil hanya id dan nama dari kategori
        ->get()
        ->map(function($menu) {
            return [
                'nama' => $menu->nama,
                'kategori' => $menu->kategori->nama, // Ambil nama kategori
                'deskripsi' => $menu->deskripsi,
                'foto' => $menu->foto,
                'stok' => $menu->stok,
                'harga' => $menu->harga,
                'diskon' => $menu->diskon,
            ];
        });

    return DataTables::of($data)->make(true);
    }
}
