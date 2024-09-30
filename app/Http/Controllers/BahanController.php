<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanController extends Controller
{
    public function index()
    {
        $bahanBaku = BahanBaku::all();
        return view('admin.bahanbaku.index', compact('bahanBaku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
            'penggunaan' => 'required|string|max:255',
            'khusus' => 'boolean',
        ]);

        BahanBaku::create($validated);

        return redirect()->route('admin.bahanbaku.index')->with('success', 'Bahan Baku added successfully');
    }

    // Show the edit form
    public function edit($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        return view('admin.bahanbaku.edit', compact('bahanBaku'));
    }

    // Update the data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
            'penggunaan' => 'required|string|max:255',
            'khusus' => 'boolean',
        ]);

        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->update($validated);

        return redirect()->route('admin.bahanbaku.index')->with('success', 'Bahan Baku updated successfully');
    }

    // Delete the data
    public function destroy($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->delete();

        return redirect()->route('admin.bahanbaku.index')->with('success', 'Bahan Baku deleted successfully');
    }
}
