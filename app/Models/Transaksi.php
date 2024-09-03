<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $tabel = 'transaksis';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public static function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
    public static function getStatistics()
    {
        // Mengambil data transaksi dan menghitung statistik berdasarkan status
        return self::selectRaw('status, SUM(jumlah) as qty, SUM(harga * jumlah) as pendapatan')
                    ->groupBy('status')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [$item->status => [
                            'status' => $item->status,
                            'qty' => $item->qty,
                            'pendapatan' => $item->pendapatan
                        ]];
                    })
                    ->values();
    }
}
