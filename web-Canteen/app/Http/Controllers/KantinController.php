<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Models\DetailRiwayat;

class KantinController extends Controller
{
    public function dashboard()
    {
        $canteens = [
            ['id' => 1, 'name' => 'Kantin A', 'image' => 'canteen1.png'],
            ['id' => 2, 'name' => 'Kantin B','image' => 'canteen2.png'],
            ['id' => 3, 'name' => 'Kantin C', 'image' => 'canteen3.png']
        ];

        return view('dashboard', compact('canteens'));
    }

    
    public function proses($id)
    {
        $detail = DetailPesanan::findOrFail($id);

        DetailRiwayat::create([

            'id_detail' => $detail->id_detail,
            'id_menu' => $detail->id_menu,
            'jumlah' => $detail->jumlah,
            'harga' => $detail->harga,
            'subtotal' => $detail->subtotal,
            'status' => 'diproses'
        ]);

        return back();
    }

    public function selesai($id)
    {
        $riwayat = DetailRiwayat::where('id_detail',$id)->first();
        $riwayat->update(['status' => 'selesai']);

        return back();
    }

    public function dibatalkan($id)
    {
        $riwayat = DetailRiwayat::where('id_detail',$id)->first();
        $riwayat->update(['status' => 'dibatalkan']);

        return back();
    }

    public function batalkan($id)
    {
        $pesanan = DetailPesanan::where('id_pesanan',$id)->get();
        foreach($pesanan as $detail)
        {
            if($detail->riwayat)
            {return back()->with('error','Pesanan sedang diproses');}}

        foreach($pesanan as $detail)
        {
            DetailRiwayat::create([
                'id_detail' => $detail->id_detail,
                'id_menu' => $detail->id_menu,
                'jumlah' => $detail->jumlah,
                'harga' => $detail->harga,
                'subtotal' => $detail->subtotal,
                'status' => 'dibatalkan'
            ]);
        }

        return back()->with('success','Pesanan dibatalkan');
    }
}