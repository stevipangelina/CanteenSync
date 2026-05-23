<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Akun extends Authenticatable
{
    protected $table = 'akun'; 

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telepon',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    // biar login pakai "nama"
    public function getAuthIdentifierName()
    {
        return 'nama';
    }
}