<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $tabel = 'pesanans';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function menu()
{
    return $this->hasMany(Menu::class, 'id', 'id_menu'); // Pastikan kunci relasi sesuai
}
}
