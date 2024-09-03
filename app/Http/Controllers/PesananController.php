<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    public function index()
    {
        return view('admin.pesanan.index');
    }

    public function pesanan()
    {
        $data = Pesanan::with('menu')
            ->selectRaw('nama_pelanggan, kode, COUNT(*) as orders_count')
            ->groupBy('nama_pelanggan', 'kode')
            ->get()
            ->map(function ($item) {
                return [
                    'id_pesanan' => $item->id,
                    'nama_pelanggan' => $item->nama_pelanggan,
                    'kode' => $item->kode,
                    'orders' => Pesanan::where('nama_pelanggan', $item->nama_pelanggan)->with('menu')->get()->map(function ($order) {
                        return [
                            'id' => $order->id,
                            'nama' => $order->menu->nama,
                            'qty' => $order->qty,
                            'harga' => $order->menu->harga,
                            'jumlah' => $order->jumlah,
                            'diskon' => $order->menu->diskon,
                            'catatan' => $order->catatan,
                            'status' => $order->status
                        ];
                    })
                ];
            });
   
        return DataTables::of($data)
        // ->addColumn('details', function($row) {
        //     return json_encode($row['menuItems']);
        // })
        ->addColumn('aksi', function($row) {
            $kode_pelanggan = htmlspecialchars($row['kode'], ENT_QUOTES, 'UTF-8');
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
        ->rawColumns(['aksi'])
        // ->make(true);
        ->make(true);
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
            Pesanan::create([
                'nama_pelanggan' => $keranjang->nama_pelanggan,
                'id_menu' => $keranjang->id_menu,
                'qty' => 1,
                'kode' => $kode,
                'status' => 'proses',
            ]);
        }

        Keranjang::where('nama_pelanggan', $nama_pelanggan)
            ->where('kode', $kode)
            ->delete();

        return redirect()->route('checkout.success')->with('success', 'Checkout berhasil!');
    }
    public function aksi(Request $request){
        $status = $request->get('status');
        $kode = $request->get('kode');
        if($status == 'hapus') {
            Pesanan::where('kode', $kode)->delete();
            return response()->json(['message' => 'Status pesanan berhasil dihapus', 'status' => true]);
        }else{
            Pesanan::where('kode', $kode)->update(['status' => $status]);
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
            $datas = Pesanan::where('kode', $kode)->where('status', $statusAwal)->where('id_menu', $id)->delete();
            return response()->json(['message' => 'Status pesanan berhasil dihapus', 'status' => $datas]);
        }else{
            Pesanan::where('kode', $kode)->where('status', $statusAwal)->where('id_menu', $id)->update(['status' => $status]);
            
            // Transaksi::where('kode_pelanggan', $kode)->where('status', $statusAwal)->where('id_menu', $id)->update(['status' => $status]);
            return response()->json(['message' => 'Status pesanan berhasil diubah', 'status' => true]);
        }
        return response()->json(['message' => 'Status pesanan berhasil diubah', 'status' => true]);
    }


    public function dataPenjualan(Request $request)
    {
      return view('admin.penjualan.index');
    }



    public function checkoutSuccess()
    {
        return view('components.checkout-success');
    }
}
