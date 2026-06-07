<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Menu;

class PemesananController extends Controller
{
    // public function index()
    // {
    //     $keranjang = session()->get('keranjang', []);
    //     $id_kantin = session()->get('id_kantin');

    //     $total = 0;
    //     foreach ($keranjang as $item) {
    //         $total += $item['harga'] * $item['qty'];
    //     }

    //     return view('pemesanan', compact('keranjang', 'total', 'id_kantin'));
    // }
    public function index()
    {
    //     dd(
    //     Auth::check(),
    //     Auth::id(),
    //     Auth::user()
    // );
        // dd(Auth::check(), Auth::id());
        $keranjang = session()->get('keranjang', []);
        $id_kantin = session()->get('id_kantin');
        $total = 0;
        foreach ($keranjang as $item) { $total += $item['harga'] * $item['qty'];}
        return view('pemesanan', compact('keranjang', 'total', 'id_kantin'));
    }


    public function simpan(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        $id_kantin = session()->get('id_kantin');

        if (empty($keranjang)) { return back()->with('error', 'Keranjang kosong');}
        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($keranjang as $id => $item) {
                $menu = Menu::find($id);
                if (!$menu) {throw new \Exception("Menu tidak ditemukan");}
                if ($menu->stok < $item['qty']) {throw new \Exception("Stok tidak cukup untuk " . $menu->nama_menu);}

                $total += $item['harga'] * $item['qty'];
            }

            $nomorKantin = DB::table('pesanan')
    ->where('id_kantin', $id_kantin)
    ->count() + 1;

             $id_pesanan = DB::table('pesanan')->insertGetId([
                'id_user' => Auth::id(),
                'id_kantin' => $id_kantin,
                'nomor_kantin' => $nomorKantin,
                'jam_pengambilan' => $request->jam_pengambilan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_harga' => $total,
                'status' => 'menunggu'
                
            ]);

            /*
|--------------------------------------------------------------------------
| TAMBAH BARU
| SIMPAN KE RIWAYAT PESANAN
|--------------------------------------------------------------------------
*/

$id_riwayat = DB::table('riwayat_pesanan')
    ->insertGetId([

        'id_user' => Auth::id(),

        'id_kantin' => $id_kantin,

        'waktu_pesan' => Carbon::now(),

        'total_harga' => $total,

        'status' => 'diproses'

    ]);


            foreach ($keranjang as $id => $item) {
                $menu = Menu::find($id);
                $subtotal = $item['harga'] * $item['qty'];
                /*
|--------------------------------------------------------------------------
| GANTI KODE LAMA
|--------------------------------------------------------------------------
*/

$id_detail = DB::table('detail_pesanan')
    ->insertGetId([

        'id_pesanan' => $id_pesanan,

        'id_menu' => $id,

        'jumlah' => $item['qty'],

        'harga' => $item['harga'],

        'subtotal' => $subtotal

    ]);

    /*
|--------------------------------------------------------------------------
| TAMBAH BARU
|--------------------------------------------------------------------------
*/

// DB::table('detail_riwayat')->insert([

//     'id_detail' => $id_detail,

//     'id_riwayat' => $id_riwayat,

//     'id_menu' => $id,

//     'jumlah' => $item['qty'],

//     'harga' => $item['harga'],

//     'subtotal' => $subtotal,

//     'status' => 'diproses'

// ]);
                // DB::table('detail_pesanan')->insert([
                //     'nomor_kantin' => $nomorKantin,
                //     'id_pesanan' => $id_pesanan,
                //     'id_menu' => $id,
                //     'jumlah' => $item['qty'],
                //     'harga' => $item['harga'],
                //     'subtotal' => $subtotal
                // ]);

                $menu->stok -= $item['qty']; 
                $menu->save();
            }

            DB::commit();
            
            session()->put('last_order', [
                'nomor_kantin' => $nomorKantin,
                'id_pesanan' => $id_pesanan,
                'keranjang' => $keranjang,
                'total' => $total,
                'jam' => $request->jam_pengambilan,
                'metode' => $request->metode
            ]);

            session()->forget('keranjang');
            return redirect('/pesanan/sukses');} catch (\Exception $e) { dd($e->getMessage()); 
            return back()->with('error', $e->getMessage());}
    }


    public function sukses()
    {
        // dd(session()->get('last_order'));
        $data = session()->get('last_order');
        if (!$data) {return redirect('/dashboard');}
        return view('sukses', compact('data'));
    }
}
