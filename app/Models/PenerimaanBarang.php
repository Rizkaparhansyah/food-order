<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{ 
    use HasFactory;
    protected $tabel = 'penerimaan_barangs';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
