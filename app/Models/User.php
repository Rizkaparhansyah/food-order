<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $tabel = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'token',
        'kode'
    ];

}
