<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'akun'; 

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password'
    ];
}