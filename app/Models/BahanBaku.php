<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'jns_bhn', 'subkategori', 'penggunaan_bhn', 'khusus'];
}
