<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['nama_pelanggan', 'kode', 'id_menu', 'jumlah', 'status'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}
