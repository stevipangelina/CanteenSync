<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananMasukController extends Controller
{
   # tampilan pesan
    public function index(Request $request, $id_kantin)
    {
        $status = $request->status;
        $pesanan = Pesanan::with('detail.menu') ->where('id_kantin', $id_kantin) ->when($status, function($query) use ($status){
                $query->where('status',$status);
            }) ->orderBy('waktu_pesan','desc') ->get();

        return view('pesanan_masuk',compact(
                'pesanan', 'id_kantin', 'status')
        );
    }


    # update status
    public function updateStatus(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);
        $pesanan->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diubah');
    }
}