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
        $pesanan = \App\Models\Pesanan::findOrFail($id);
        if($pesanan->status != 'menunggu')  // hanya boleh dibatalkan saat masih menunggu
        {
            return back()->with('error', 'Pesanan sudah diproses dan tidak dapat dibatalkan');
        }

        \App\Models\DetailPesanan::where('id_pesanan',$id)->delete();  // hapus detail pesanan
        $pesanan->delete(); // hapus pesanan utama

        return back()->with('success','Pesanan berhasil dibatalkan');
    }
}