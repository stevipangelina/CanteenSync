<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\DetailRiwayat;

class RiwayatController extends Controller
{

    public function index(Request $request)
    {
        $query = Pesanan::with([
            'detailPesanan.menu'
        ])
        ->where(
            'id_user', auth()->id()

        );

        if($request->kantin)
        {
            $query->where('id_kantin', $request->kantin
            );
        }

        if($request->status)
        {
            $query->where( 'status',
                $request->status
            );
        }

        $pesanan = $query
            ->orderBy( 'id_pesanan', 'desc')
            ->get();

        return view('riwayat', compact('pesanan')
        );

    }

    public function batalkan($id)
    {

        $detailPesanan = DetailPesanan::where(
            'id_pesanan',
            $id
        )->get();

        $pesanan = Pesanan::find($id);
        if(!$pesanan)
        {
            return back()->with( 'error', 'Pesanan tidak ditemukan');
            }
        if(
            $pesanan->status == 'diproses' ||
            $pesanan->status == 'selesai'
        )
        {
            return back()->with( 'error', 'Pesanan sedang diproses dan tidak bisa dibatalkan');
        }

        $pesanan->update([
            'status' => 'dibatalkan'
        ]);

        foreach($detailPesanan as $detail)
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

        return back()->with(
            'success',
            'Pesanan berhasil dibatalkan'
        );
    }
}