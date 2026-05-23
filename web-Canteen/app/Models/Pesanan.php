<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_kantin',
        'status',
        'metode_pembayaran'
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class,'id_pesanan');
    }

    
    public function riwayat()
    {
        return $this->hasOne(Riwayat::class,'id_pesanan');
    }
}