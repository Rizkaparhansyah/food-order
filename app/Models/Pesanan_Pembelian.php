<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan_Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pesanan_pembelian';

    protected $fillable = [
        'nama_pemasok',
        'tanggal_pesanan',
        'nama_barang',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'status_pesanan'
    ];

}
