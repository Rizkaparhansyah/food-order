<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahanbaku';  // Correct table name without underscore

    protected $fillable = ['jenis', 'subkategori', 'penggunaan', 'khusus'];
}