<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $tabel = 'kategoris';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_id'); // Menunjukkan kolom foreign key
    }
}
