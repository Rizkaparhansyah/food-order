<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubkategoriBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'subkategori_bahan_baku';

    protected $fillable = ['nama_subkategori', 'jenis_bahan_baku_id'];

    // Relasi ke Jenis
    public function jenis()
    {
        return $this->belongsTo(JenisBahanBaku::class, 'jenis_bahan_baku_id');
    }
}

