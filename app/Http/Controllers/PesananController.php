<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log; // Correct import

class PesananController extends Controller
{
    public function index()
    {
        return view('admin.pesanan.index');
    }

    public function pesanan()
    {
        $data = Pesanan::select('pesanans.nama_pelanggan', 'pesanans.kode', 'meja.nomor_meja as nomor_meja', DB::raw('COUNT(*) as orders_count'))
            ->leftJoin('meja', 'pesanans.kode', '=', 'meja.kode')
            ->groupBy('nama_pelanggan', 'kode', 'nomor_meja')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pelanggan' => $item->nama_pelanggan,
                    'kode' => $item->kode,
                    'nomor_meja' => $item->nomor_meja,
                    'orders' => Pesanan::where('nama_pelanggan', $item->nama_pelanggan)->with('menu')->get()->map(function ($order) {
                        return [
                            'id' => $order->id,  // Include the order ID
                            'nama_menu' => $order->menu->nama,
                            'harga_menu' => $order->menu->harga,
                            'diskon' => $order->menu->diskon,
                            'jumlah' => $order->jumlah,
                            'catatan' => $order->catatan,
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
<<<<<<< HEAD
        $id_meja = $request->session()->get('meja', false);

        if (!$nama_pelanggan || !$kode || !$id_meja) {
            return redirect()->route('cart')->with('error', 'Data tidak valid. Silakan coba lagi.');
        }

        $meja = Meja::findOrFail($id_meja);
        $meja->kode = $kode;
        $meja->nama = $nama_pelanggan;
        $meja->status = 'terisi';
        $meja->save();

        $quantities = $request->input('quantities', []);
        $catatans = $request->input('catatan', []);

=======
    
        if (!$nama_pelanggan || !$kode) {
            return redirect()->route('cart')->with('error', 'Data tidak valid. Silakan coba lagi.');
        }
    
        $quantities = $request->input('quantities', []);
        $catatans = $request->input('catatan', []);
    
>>>>>>> 2d1d8206371943a9b51b9465075d4dd993aa3923
        $keranjangs = Keranjang::where('nama_pelanggan', $nama_pelanggan)
            ->where('kode', $kode)
            ->get();
    
        foreach ($keranjangs as $keranjang) {
            $jumlah = $quantities[$keranjang->id] ?? 1; // Jika tidak ada, default ke 1
            $catatan = $catatans[$keranjang->id] ?? null;
<<<<<<< HEAD

            $menu = Menu::findOrFail($keranjang->id_menu);
            $menu->stok -= $jumlah;
            $menu->save();

=======
    
>>>>>>> 2d1d8206371943a9b51b9465075d4dd993aa3923
            Pesanan::create([
                'nama_pelanggan' => $keranjang->nama_pelanggan,
                'id_menu' => $keranjang->id_menu,
                'jumlah' => $jumlah,
                'kode' => $kode,
                'status' => 'proses',
                'catatan' => $catatan,
            ]);
        }
    
        Keranjang::where('nama_pelanggan', $nama_pelanggan)
            ->where('kode', $kode)
            ->delete();
    
        return redirect()->route('checkout.success')->with('success', 'Checkout berhasil!');
    }
    


    public function checkoutSuccess()
    {
        $mejas = Meja::where('status', 'kosong')->get();
        return view('components.checkout-success', compact('mejas'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $pesanan = Pesanan::find($id);

            if (!$pesanan) {
                return response()->json(['error' => 'Pesanan not found'], 404);
            }

            // Debugging: Log the status and ID
            Log::info('Updating status for pesanan ID ' . $id . ' to ' . $request->status);

            if ($request->status === 'delete') {
                // Delete the order
                $pesanan->delete();
                return response()->json(['success' => 'Pesanan deleted successfully']);
            } else {
                // Update the status
                $pesanan->status = $request->status;
                $pesanan->save();
                return response()->json(['success' => 'Pesanan status updated successfully']);
            }
        } catch (\Exception $e) {
            // Log the error for debugging
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
