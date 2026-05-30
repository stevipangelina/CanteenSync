<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;

class RekapanPenjualanController extends Controller
{
    public function index($id_kantin)
    {
        $penjualan = Pesanan::with('detail.menu')
            ->where('id_kantin', $id_kantin)
            ->where('status', 'selesai')
            ->orderBy('id_pesanan','desc')
            ->get();

        $totalPendapatan = $penjualan->sum('total_harga');

        $totalDineIn = $penjualan
            ->where('metode_pembayaran','dinein')
            ->sum('total_harga');

        $totalEwallet = $penjualan
            ->where('metode_pembayaran','ewallet')
            ->sum('total_harga');

        return view('rekap_penjualan', compact(
                'penjualan', 'totalPendapatan', 'totalDineIn', 'totalEwallet','id_kantin'));
    }
}