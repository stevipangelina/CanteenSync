<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;
    protected $fillable = [
        'id_pesanan',
        'id_menu',
        'jumlah',
        'harga',
        'subtotal'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }

    
        public function riwayat()
    {
        return $this->hasOne(DetailRiwayat::class,'id_detail');
    }
}