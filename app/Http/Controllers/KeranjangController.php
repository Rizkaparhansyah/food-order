<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil nilai dari session
        $nama_pelanggan = session('user_name');
        $kode = session('kode');
    
        // Membuat cache key berdasarkan user session
        $cacheKey = 'keranjang_' . $nama_pelanggan . '_' . $kode;
    
        // Mengambil data keranjang dari cache
        $keranjang = Cache::get($cacheKey, []);
    
        // Ambil ID menu dari data keranjang
        $menuIds = array_column($keranjang, 'id_menu');
    
        // Mengambil data menu berdasarkan ID dari database
        $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');
    
        // Gabungkan data keranjang dengan data menu
        foreach ($keranjang as &$item) {
            $item['menu'] = $menus->get($item['id_menu']);
        }
        if($request->ajax()) return response()->json($keranjang);
        return view('components.cart-component', ['data' => $keranjang]);
    }
    
    
    public function addCart(Request $request)
    {
        // Mengambil nilai dari session
        $nama_pelanggan = session('user_name');
        $kode = session('kode');

        // Membuat cache key berdasarkan user session
        $cacheKey = 'keranjang_' . $nama_pelanggan . '_' . $kode;

        // Mengambil data keranjang dari cache
        $keranjang = Cache::get($cacheKey, []);

        // Cek apakah data sudah ada di cache
        $found = false;
        foreach ($keranjang as &$item) {
            if ($item['id_menu'] == $request->id) {
                // Jika entri sudah ada, tambahkan qty yang ada
                $item['qty'] += $request->qty;
                $found = true;
                break;
            }
        }

        if (!$found) {
            // Jika entri belum ada, buat entri baru
            $keranjang[] = [
                'id_menu' => $request->id,
                'nama_pelanggan' => $nama_pelanggan,
                'kode' => $kode,
                'qty' => $request->qty,
            ];
        }

        // Simpan kembali data ke cache
        Cache::put($cacheKey, $keranjang, now()->addMinutes(60));

        // Menghitung jumlah item di keranjang
        $count = count($keranjang);     

        return response()->json(['status' => 200, 'message' => 'sukses', 'count' => $keranjang]);
    }

    public function updateCart(Request $request)
    {
        // Mengambil nilai dari session
        $nama_pelanggan = session('user_name');
        $kode = session('kode');
        
        // Membuat cache key berdasarkan user session
        $cacheKey = 'keranjang_' . $nama_pelanggan . '_' . $kode;
        
        // Mengambil data keranjang dari cache
        $keranjang = Cache::get($cacheKey, []);
        
        // Cek apakah item ada di keranjang
        foreach ($keranjang as &$item) {
            if ($item['id_menu'] == $request->id_menu) {
                
                // dd($request->qty);
                // Perbarui kuantitas item di keranjang
                $item['qty'] =  $request->qty;
                break;
            }
        }

        // Simpan kembali data ke cache
        Cache::put($cacheKey, $keranjang, now()->addMinutes(60));

        return response()->json(['success' =>  $request->id_menu, 'message' => 'Keranjang berhasil diperbarui']);
    }




    public function clearCart(Request $request)
    {
        // Mengambil nilai dari session
        $nama_pelanggan = session('user_name');
        $kode = session('kode');

        // Membuat cache key berdasarkan user session
        $cacheKey = 'keranjang_' . $nama_pelanggan . '_' . $kode;

        // Ambil data keranjang dari cache
        $keranjang = Cache::get($cacheKey, []);

        // ID yang akan dihapus dari keranjang
        $idToRemove = $request->id;

        // Filter data keranjang untuk menghapus entri dengan ID yang sesuai
        $keranjang = array_filter($keranjang, function ($item) use ($idToRemove) {
            return $item['id_menu'] != $idToRemove;
        });

        // Simpan data yang diperbarui ke cache
        Cache::put($cacheKey, $keranjang, now()->addMinutes(30));

        return response()->json(['message' => 'Item removed from cart', 'data' => $keranjang]);
    }

}
