<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'penggunaan_bahan_baku';

    protected $fillable = ['nama_penggunaan', 'khusus'];
}
