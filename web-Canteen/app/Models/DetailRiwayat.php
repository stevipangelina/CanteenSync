<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailRiwayat extends Model
{
    protected $table = 'detail_riwayat';
    protected $primaryKey = 'id_detail_riwayat';
    public $timestamps = false;
    protected $fillable = [
        'id_detail',
        'id_menu',
        'jumlah',
        'harga',
        'subtotal',
        'status'
    ];
}