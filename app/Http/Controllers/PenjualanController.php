<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            if($request->tab){
                $datas = Transaksi::getStatistics();
                return $datas;
            }
            $data = Transaksi::with('menu')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        }
        return view('admin.penjualan.index');
    }

}

