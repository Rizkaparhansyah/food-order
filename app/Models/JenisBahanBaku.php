<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'jenis_bahan_baku';

    protected $fillable = ['nama_jenis'];

    // Relasi ke Subkategori
    public function subkategori()
    {
        return $this->hasMany(SubkategoriBahanBaku::class, 'jenis_bahan_baku_id');
    }
}
