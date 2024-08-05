<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index(){
        $categories = Kategori::all();
        return view('admin.menu.index', compact('categories'));
    }

    public function menu(){
        $data = Menu::with('kategori:id,nama') // Mengambil hanya id dan nama dari kategori
            ->get()
            ->map(function($menu) {
                return [
                    'id' => $menu->id,
                    'nama' => $menu->nama,
                    'kategori' => $menu->kategori->nama, // Ambil nama kategori
                    'deskripsi' => $menu->deskripsi,
                    'foto' => $menu->foto,
                    'stok' => $menu->stok,
                    'harga' => $menu->harga,
                    'diskon' => $menu->diskon,
                ];
            });

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $editButton = '<button class="btn btn-sm btn-primary edit-menu" data-id="'.$row['id'].'">Edit</button>';
                $deleteButton = '<button class="btn btn-sm btn-danger delete-menu" data-id="'.$row['id'].'">Delete</button>';
                return $editButton . ' ' . $deleteButton;
            })
            ->make(true);
    }

    public function create(){
        return view('admin.menu.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image',
            'stok' => 'required|integer',
            'harga' => 'required|integer',
            'diskon' => 'nullable|integer'
        ]);

        $menu = new Menu($request->all());

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $menu->foto = '/images/' . $filename;
        }

        $menu->save();

        return redirect()->route('list-menu')->with('success', 'Menu added successfully.');
    }

    /*public function edit($id){
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }*/

    public function edit($id){
        $menu = Menu::findOrFail($id);
        $categories = Kategori::all();
        return response()->json(['menu' => $menu, 'categories' => $categories]);
    }
    
    

    public function update(Request $request, $id){
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image',
            'stok' => 'required|integer',
            'harga' => 'required|integer',
            'diskon' => 'nullable|integer'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->fill($request->all());

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $menu->foto = '/images/' . $filename;
        }

        $menu->save();

        return redirect()->route('list-menu')->with('success', 'Menu updated successfully.');
    }

    public function destroy($id){
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return response()->json(['success' => 'Menu deleted successfully.']);
    }
}