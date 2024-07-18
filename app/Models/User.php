<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    protected $tabel = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'token'
    ];

}
