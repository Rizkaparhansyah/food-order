<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class DaftarPesanan extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
            $data = Pesanan::with('menu')->get();

            $result = $data->groupBy('kode_pelanggan')->map(function ($group) {
                $firstItem = $group->first();
                $menuItems = $group->flatMap(function ($item) {
                    return $item->menu->map(function ($menu) use ($item) {
                        return [
                            'id' => $menu->id,
                            'nama' => $menu->nama,
                            'harga' => $menu->harga,
                            'qty' => $item->jumlah,
                            'status' => $item->status,
                            'diskon' => $menu->diskon,
                            'catatan' => $item->catatan,
                        ];
                    });
                })
                ->groupBy(function ($item) {
                    return $item['id'] . '_' . $item['status'] . '_' . $item['catatan']; // Tambahkan catatan dalam pengelompokan
                })
                ->map(function ($items) {
                    $first = $items->first();
                    $totalQty = $items->sum('qty');
                    $totalHarga = $first['harga'] * $totalQty; // Menghitung harga total berdasarkan jumlah
                    return [
                        'id' => $first['id'],
                        'nama' => $first['nama'],
                        'harga' => $totalHarga, // Menggunakan harga total
                        'qty' => $totalQty,
                        'status' => $first['status'],
                        'diskon' => $first['diskon'],
                        'catatan' => $first['catatan'], // Catatan yang digunakan
                    ];
                })
                ->values();
            
                return [
                    'id_pesanan' => $firstItem->id,
                    'nama_pelanggan' => $firstItem->nama_pelanggan,
                    'kode_pelanggan' => $firstItem->kode_pelanggan,
                    'menuItems' => $menuItems,
                ];
            })->values();
            
            
            return DataTables::of($result)
                ->addColumn('details', function($row) {
                    return json_encode($row['menuItems']);
                })
                ->addColumn('aksi', function($row) {
                    $kode_pelanggan = htmlspecialchars($row['kode_pelanggan'], ENT_QUOTES, 'UTF-8');
                    $pending = 'pending';
                    $proses = 'proses';
                    $selesai = 'selesai';
                    $hapus = 'hapus';
                    $batal = 'batal';
                    return '
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-success rounded-circle justify-content-center align-items-center d-flex" style="width:40px; height:40px;" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu dropdown-menu-eleh show" style="width: 240px; background: rgb(255, 255, 255); border: 1px; position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(-10px, 0px);" data-popper-placement="left-start">
                                    <div class="d-flex justify-content-around w-100">
                                        <div>
                                            <button style="width:40px; height:40px;" onclick="aksiPesanan(' . $kode_pelanggan . ', \'' . $pending . '\')" class="btn btn-rounded rounded-circle btn-info btn-md"  data-bs-toggle="tooltip" data-bs-placement="top" title="Pending semua pesanan"><i class="fa fa-hourglass-half"></i></button>
                                        </div>
                                        <div>
                                            <button style="width:40px; height:40px;"  onclick="aksiPesanan(' . $kode_pelanggan . ', \'' . $proses . '\')" class="btn btn-rounded rounded-circle btn-warning btn-md"  data-bs-toggle="tooltip" data-bs-placement="top" title="Proses semua pesanan"><i class="fa fa-circle-notch"></i></button>
                                        </div>
                                        <div>
                                            <button style="width:40px; height:40px;" onclick="aksiPesanan(' . $kode_pelanggan . ', \'' . $selesai . '\')" class="btn btn-rounded rounded-circle btn-success btn-md" data-bs-toggle="modal" data-bs-target="#exampleModal"  data-bs-placement="top" title="Selesaikan semua pesanan"><i class="fa fa-check"></i></button>
                                        </div>
                                        <div>
                                            <button style="width:40px; height:40px;" onclick="aksiPesanan(' . $kode_pelanggan . ', \'' . $batal . '\')" class="btn btn-rounded rounded-circle btn-md btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Batal semua pesanan" > <i class="fa fa-times"></i></button>
                                        </div>
                                        <div>
                                            <button style="width:40px; height:40px;" onclick="aksiPesanan(' . $kode_pelanggan . ', \'' . $hapus . '\')" class="btn btn-rounded rounded-circle btn-md btn-danger delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus semua pesanan" > <i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                })
                ->rawColumns(['details','aksi'])
                ->make(true);
        }

        return view('admin.pesanan.index');
    }
    public function checkout(Request $request){
        $data = $request->data ?? $request->input('data'); // Data akan berbentuk array dengan id_menu sebagai key dan qty sebagai value
        $namaPelanggan =  session('user_name'); // Mendapatkan nama pelanggan dari session
        $kodePelanggan =  session('kode'); // Mendapatkan nama pelanggan dari session
        $data = is_array($data) ? $data : json_decode($data, true);
        foreach ($data as $idMenu => $qty) {
            // Membuat entri baru di model Pesanan
            Pesanan::create([
                'id_menu' => isset($qty['nama_pelanggan']) ? $qty['id'] : $idMenu,   
                'jumlah' => $qty['qty'],
                'catatan' => $qty['catatan'],
                'nama_pelanggan'=> isset($qty['nama_pelanggan']) ? $qty['nama_pelanggan'] : $namaPelanggan,
                'kode_pelanggan' => isset($qty['nama_pelanggan']) ? $qty['kode_pelanggan']  : $kodePelanggan,
                'status' => 'pending',
            ]);
            
            $menu = Menu::find(isset($qty['nama_pelanggan']) ? $qty['id'] : $idMenu);
            if ($menu) {
                // Hitung harga setelah diskon (misalnya, harga - diskon)
                $hargaAsli = $menu->harga;
                $diskonPersen = $menu->diskon;
                $hargaSetelahDiskon = $hargaAsli * ((100 - $diskonPersen) / 100);

                // Hitung total harga berdasarkan jumlah
                $totalHarga = $hargaSetelahDiskon * $qty['qty'];

                // Buat transaksi dengan harga yang telah dihitung
                $menu = Menu::find(isset($qty['nama_pelanggan']) ? $qty['id'] : $idMenu);

                if ($menu) {
                    // Update stok menu
                    $menu->stok -= $qty['qty'];
                    $menu->save();
                    // Hitung harga setelah diskon
                    $hargaAsli = $menu->harga;
                    $diskonPersen = $menu->diskon;
                    $hargaSetelahDiskon = $hargaAsli * ((100 - $diskonPersen) / 100);
            
                    // Hitung total harga berdasarkan jumlah
                    $totalHarga = $hargaSetelahDiskon * $qty['qty'];
            
                    // Periksa apakah ada transaksi yang sama
                    $transaksi = Transaksi::where('kode_pelanggan',  isset($qty['nama_pelanggan']) ? $qty['kode_pelanggan'] : $kodePelanggan)
                                          ->where('id_menu',  isset($qty['nama_pelanggan']) ? $qty['id'] : $idMenu)
                                          ->where('status', 'pending')
                                          ->first();
            
                    if ($transaksi) {
                        // Jika ada, tambahkan jumlah dan harga
                        $transaksi->jumlah += $qty['qty'];
                        $transaksi->harga += $totalHarga;
                        $transaksi->save();
                    } else {
                        // Jika tidak, buat entri baru
                        Transaksi::create([
                            'id_menu' =>  isset($qty['nama_pelanggan']) ? $qty['id']  : $idMenu,
                            'jumlah' => $qty['qty'],
                            'harga' =>  $totalHarga,
                            'kode_pelanggan' => isset($qty['nama_pelanggan']) ? $qty['kode_pelanggan']  : $kodePelanggan,
                            'status' => 'pending',
                        ]);
                    }
            
                }
            }
        }

        //jika sudah sukses checkout hapus data di keranjang
        $cacheKey = 'keranjang_' . $namaPelanggan . '_' . $kodePelanggan;
        Cache::forget($cacheKey);

    
        return response()->json(['message' => 'Pesanan berhasil dibuat', 'data' => json_encode(Pesanan::get())]);

    }
    public function aksi(Request $request){
        $status = $request->get('status');
        $kode = $request->get('kode');
        if($status == 'hapus') {
            Pesanan::where('kode_pelanggan', $kode)->delete();
            return response()->json(['message' => 'Status pesanan berhasil dihapus', 'status' => true]);
        }else{
            Pesanan::where('kode_pelanggan', $kode)->update(['status' => $status]);
            Transaksi::where('kode_pelanggan', $kode)->update(['status' => $status]);
            return response()->json(['message' => 'Status pesanan berhasil diubah', 'status' => true]);
        }
        return response()->json(['message' => 'Status pesanan berhasil diubah', 'status' => true]);
    }
    public function perData(Request $request){
        $id = $request->get('id');
        $statusAwal = $request->get('statusAwal');
        $status = $request->get('status');
        $kode = $request->get('kode');
        if($status == 'hapus') {
            $datas = Pesanan::where('kode_pelanggan', $kode)->where('status', $statusAwal)->where('id_menu', $id)->delete();
            return response()->json(['message' => 'Status pesanan berhasil dihapus', 'status' => $datas]);
        }else{
            Pesanan::where('kode_pelanggan', $kode)->where('status', $statusAwal)->where('id_menu', $id)->update(['status' => $status]);
            
            Transaksi::where('kode_pelanggan', $kode)->where('status', $statusAwal)->where('id_menu', $id)->update(['status' => $status]);
            return response()->json(['message' => 'Status pesanan berhasil diubah', 'status' => true]);
        }
        return response()->json(['message' => 'Status pesanan berhasil diubah', 'status' => true]);
    }
    public function status(Request $request){
        if($request->ajax()) {
            $data = Pesanan::with('menu')->where('kode_pelanggan', session('kode'))->get();
            return $data;
        }
        return view('components.status-component');
    }
}
