<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananMasukController extends Controller
{
    public function index(Request $request, $id_kantin)
    {
        $status = $request->status;
        $pesanan = Pesanan::with('detail.menu', 'user') // pastikan user di-relasi
            ->where('id_kantin', $id_kantin)
            ->when($status, function($query) use ($status) {
                $validStatus = ['menunggu','diproses','siap_diambil','selesai','dibatalkan'];
                if(in_array($status, $validStatus)) {
                    $query->where('status', $status);
                }
            })
            ->orderBy('waktu_pesan','desc')
            ->get();

        return view('pesanan_masuk', compact(
            'pesanan', 'id_kantin', 'status'
        ));
    }

    public function updateStatus(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        $statusMap = [
            'menunggu'     => 'menunggu',
            'diproses'     => 'diproses',
            'siap_diambil' => 'siap_diambil',
            'selesai'      => 'selesai',
            'dibatalkan'   => 'dibatalkan'
        ];

        $statusInput = $request->status;
        $status = $statusMap[$statusInput] ?? $pesanan->status;
        $pesanan->update(['status' => $status]);

        return back()->with('success', 'Status berhasil diubah');
    }
}