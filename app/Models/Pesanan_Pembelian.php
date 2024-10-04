<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan_Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pesanan_pembelian';

    protected $fillable = [
        'nomor_pesanan',
        'nama_supplier',
        'tanggal_pesanan',
        'status',
        'total_harga',
        'catatan'
    ];

    public function penerimaanBarang(): HasMany
    {
        return $this->hasMany(Penerimaan_Barang::class, 'nomor_pesanan', 'nomor_pesanan');
    }
}
