<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Menu;

class PemesananController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        $id_kantin = session()->get('id_kantin');
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['qty'];
        }
        return view('pemesanan', compact('keranjang', 'total', 'id_kantin'));
    }

    public function simpan(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        $id_kantin = session()->get('id_kantin');

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($keranjang as $id => $item) {
                $menu = Menu::find($id);
                if (!$menu) {
                    throw new \Exception("Menu tidak ditemukan");
                }
                if ($menu->stok < $item['qty']) {
                    throw new \Exception("Stok tidak cukup untuk " . $menu->nama_menu);
                }
                $total += $item['harga'] * $item['qty'];
            }

            // Hitung nomor kantin
            $nomorKantin = DB::table('pesanan')
                ->where('id_kantin', $id_kantin)
                ->count() + 1;

            // Standarisasi metode pembayaran
            $metode = $request->metode_pembayaran ?? $request->metode;
            if (strtolower($metode) == 'ewallet') {
                $metode = 'E-Wallet';
            } else {
                $metode = 'Kasir/Tunai';
            }

            // Simpan ke tabel pesanan
            $id_pesanan = DB::table('pesanan')->insertGetId([
                'id_user' => Auth::id(),
                'id_kantin' => $id_kantin,
                'nomor_kantin' => $nomorKantin,
                'jam_pengambilan' => $request->jam_pengambilan,
                'metode_pembayaran' => $metode,
                'total_harga' => $total,
                'status' => 'menunggu'
            ]);

            // Simpan ke riwayat pesanan
            $id_riwayat = DB::table('riwayat_pesanan')->insertGetId([
                'id_user' => Auth::id(),
                'id_kantin' => $id_kantin,
                'waktu_pesan' => Carbon::now(),
                'total_harga' => $total,
                'status' => 'diproses'
            ]);

            foreach ($keranjang as $id => $item) {
                $menu = Menu::find($id);
                $subtotal = $item['harga'] * $item['qty'];

                // Simpan detail pesanan
                $id_detail = DB::table('detail_pesanan')->insertGetId([
                    'id_pesanan' => $id_pesanan,
                    'id_menu' => $id,
                    'jumlah' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $subtotal
                ]);

                // Kurangi stok menu
                $menu->stok -= $item['qty'];
                $menu->save();
            }

            // Simpan data terakhir ke session
            session()->put('last_order', [
                'nomor_kantin' => $nomorKantin,
                'id_pesanan' => $id_pesanan,
                'keranjang' => $keranjang,
                'total' => $total,
                'jam' => $request->jam_pengambilan,
                'metode' => $metode
            ]);

            session()->forget('keranjang');
            DB::commit();
            return redirect('/pesanan/sukses');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function sukses()
    {
        $data = session()->get('last_order');
        if (!$data) {
            return redirect('/dashboard');
        }
        return view('sukses', compact('data'));
    }
}