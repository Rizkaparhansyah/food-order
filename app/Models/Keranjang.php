<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs'; // Pastikan 'table' bukan 'tabel'
    protected $primaryKey = 'id';
    protected $guarded = [];

    // Nama metode relasi sebaiknya tunggal, yaitu 'menu'
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}
