<?php

namespace App\Http\Controllers;
use App\Models\Pesanan;
class RiwayatController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with([
            'detailPesanan.menu',
            'detailPesanan.riwayat'
        ])->where('id_user', auth()->id())->orderBy('id_pesanan', 'desc')->get();

        return view('riwayat',compact('pesanan'));
    }


    public function batalkan($id)
    {
        $pesanan = \App\Models\DetailPesanan::where('id_pesanan',$id)->get();

        foreach($pesanan as $detail)
        {
            if($detail->riwayat){return back()->with('error','Pesanan sedang diproses dan tidak bisa dibatalkan');}
        }

        foreach($pesanan as $detail)
        {
            \App\Models\DetailRiwayat::create([
                'id_detail' => $detail->id_detail,
                'id_menu' => $detail->id_menu,
                'jumlah' => $detail->jumlah,
                'harga' => $detail->harga,
                'subtotal' => $detail->subtotal,
                'status' => 'dibatalkan'
            ]);
        }

        return back()->with('success','Pesanan berhasil dibatalkan');
    }
}