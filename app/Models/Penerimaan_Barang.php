<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan_Barang extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_barang';

    protected $fillable = [
        'nama_barang', 
        'jumlah', 
        'harga_satuan', 
        'total_harga', 
        'tanggal_penerimaan', 
        'nama_pemasok', 
        'nomor_faktur',
        'lokasi',
        'nomor_pesanan'
    ];

    public function pesananPembelian()
    {
        return $this->belongsTo(Pesanan_Pembelian::class, 'nomor_pesanan', 'nomor_pesanan');
    }
}
