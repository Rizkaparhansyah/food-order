<?php

namespace App\Http\Controllers;

use App\Models\PembelianBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index() {
        return view('admin.order.index');
    }
}
