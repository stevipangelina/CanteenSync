<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    protected $table = 'riwayat';
    protected $primaryKey = 'id_riwayat';
    protected $fillable = [
        'id_pesanan',
        'status'
    ];

    public function detailRiwayat()
    {
        return $this->hasMany(DetailRiwayat::class,'id_riwayat');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class,'id_pesanan');
    }
}