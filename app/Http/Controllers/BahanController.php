<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanController extends Controller
{
    // Display the list of Bahan Baku
    public function index()
    {
        $bahanBaku = BahanBaku::all();
        return view('admin.bahanbaku.index', compact('bahanBaku'));
    }

    // Store a new Bahan Baku
    public function store(Request $request)
    {
        // Validate the request including the stok field
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
            'penggunaan' => 'required|string|max:255',
            'khusus' => 'boolean',
            'stok' => 'required|integer|min:0',  // Validate stok field
        ]);

        // Create the new Bahan Baku with validated data
        BahanBaku::create($validated);

        // Redirect back with a success message
        return redirect()->route('admin.bahanbaku.index')->with('success', 'Bahan Baku added successfully');
    }

    // Show the edit form for a Bahan Baku
    public function edit($id)
    {
        // Find the Bahan Baku by ID or fail
        $bahanBaku = BahanBaku::findOrFail($id);
        return view('admin.bahanbaku.edit', compact('bahanBaku'));
    }

    // Update an existing Bahan Baku
    public function update(Request $request, $id)
    {
        // Validate the request including the stok field
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'subkategori' => 'nullable|string|max:255',
            'penggunaan' => 'required|string|max:255',
            'khusus' => 'boolean',
            'stok' => 'required|integer|min:0',  // Validate stok field
        ]);

        // Find the Bahan Baku by ID and update with validated data
        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->update($validated);

        // Redirect back with a success message
        return redirect()->route('admin.bahanbaku.index')->with('success', 'Bahan Baku updated successfully');
    }

    // Delete a Bahan Baku
    public function destroy($id)
    {
        // Find the Bahan Baku by ID and delete it
        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->delete();

        // Redirect back with a success message
        return redirect()->route('admin.bahanbaku.index')->with('success', 'Bahan Baku deleted successfully');
    }
}
