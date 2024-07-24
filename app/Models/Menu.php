<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $tabel = 'menus';
    protected $primaryKey = 'id';
    protected $guarded = [];
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id'); // Menunjukkan kolom foreign key
    }
}
