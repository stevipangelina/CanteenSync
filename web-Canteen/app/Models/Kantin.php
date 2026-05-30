<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    protected $table = 'kantin';
    protected $primaryKey = 'id_kantin';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'nama_kantin'
    ];
}