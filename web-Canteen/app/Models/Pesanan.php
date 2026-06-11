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
        'waktu_pesan',
        'jam_pengambilan',
        'total_harga',
        'status'
    ];

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }
    
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class,'id_pesanan');
    }
    public function user()
    {
        return $this->belongsTo(Akun::class, 'id_user'); 
    }
}