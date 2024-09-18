<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index()
    {
        return view('admin.pesanan.index');
    }

    public function pesanan()
    {
        $data = Pesanan::with('menu') // Mengambil relasi dengan model Menu
            ->selectRaw('nama_pelanggan, kode, COUNT(*) as orders_count')
            ->groupBy('nama_pelanggan', 'kode')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pelanggan' => $item->nama_pelanggan,
                    'kode' => $item->kode,
                    'orders' => Pesanan::where('nama_pelanggan', $item->nama_pelanggan)
                                    ->with('menu') // Relasi ke menu
                                    ->get()
                                    ->map(function ($order) {
                                        return [
                                            'id' => $order->id,  
                                            'nama_menu' => $order->menu->nama,
                                            'harga_menu' => $order->menu->harga,
                                            'jumlah' => $order->jumlah,
                                            'status' => $order->status
                                        ];
                                    })
                ];
            });
    
        return DataTables::of($data)->make(true);
    }    

    public function checkout(Request $request)
{
    $nama_pelanggan = $request->session()->get('user_name', false);
    $kode = $request->session()->get('kode', false);

    if (!$nama_pelanggan || !$kode) {
        return redirect()->route('cart')->with('error', 'Data tidak valid. Silakan coba lagi.');
    }

    $keranjangs = Keranjang::where('nama_pelanggan', $nama_pelanggan)
        ->where('kode', $kode)
        ->get();

    foreach ($keranjangs as $keranjang) {
        // Check apakah pesanan sudah ada
        $existingOrder = Pesanan::where('nama_pelanggan', $nama_pelanggan)
            ->where('id_menu', $keranjang->id_menu)
            ->where('kode', $kode)
            ->first();

        if ($existingOrder) {
            // Tambah jumlah pesanan yang ada
            $existingOrder->jumlah += $keranjang->jumlah;
            $existingOrder->save();
        } else {
            // Buat entri pesanan baru
            Pesanan::create([
                'nama_pelanggan' => $keranjang->nama_pelanggan,
                'id_menu' => $keranjang->id_menu,
                'jumlah' => $keranjang->jumlah,
                'kode' => $kode,
                'status' => 'proses',
            ]);
        }
    }

    // Hapus semua item dari keranjang
    Keranjang::where('nama_pelanggan', $nama_pelanggan)
        ->where('kode', $kode)
        ->delete();

    return redirect()->route('checkout.success')->with('success', 'Checkout berhasil!');
}


    public function checkoutSuccess()
    {
        return view('components.checkout-success');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $pesanan = Pesanan::find($id);
    
            if (!$pesanan) {
                return response()->json(['error' => 'Pesanan not found'], 404);
            }
    
            // Debugging: Catat status dan ID
            Log::info('Updating status for pesanan ID ' . $id . ' to ' . $request->status);
    
            if ($request->status === 'delete') {
                // Hapus pesanan
                $pesanan->delete();
                return response()->json(['success' => 'Pesanan deleted successfully']);
            } else {
                // Update status
                $pesanan->status = $request->status;
                $pesanan->save();
                return response()->json(['success' => 'Pesanan status updated successfully']);
            }
        } catch (\Exception $e) {
            // Catat kesalahan untuk debugging
            Log::error('Error updating status: ' . $e->getMessage());
    
            return response()->json(['error' => 'An error occurred while updating the status'], 500);
        }
    }    

    public function delete($id)
    {
        try {
            $pesanan = Pesanan::find($id);

            if (!$pesanan) {
                return response()->json(['error' => 'Pesanan not found'], 404);
            }

            $pesanan->delete();

            return response()->json(['success' => 'Pesanan deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting pesanan: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while deleting the pesanan'], 500);
        }
    }

}