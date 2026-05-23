<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            // 🔥 HITUNG TOTAL + VALIDASI STOK
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

            // 🔥 INSERT PESANAN
            $id_pesanan = DB::table('pesanan')->insertGetId([
                'id_user' => 1,
                'id_kantin' => $id_kantin,
                'jam_pengambilan' => $request->jam_pengambilan,
                'total_harga' => $total,
                'status' => 'diproses'
            ]);

            // 🔥 INSERT DETAIL + KURANGI STOK
            foreach ($keranjang as $id => $item) {

                $menu = Menu::find($id);

                $subtotal = $item['harga'] * $item['qty'];

                // simpan detail
                DB::table('detail_pesanan')->insert([
                    'id_pesanan' => $id_pesanan,
                    'id_menu' => $id,
                    'jumlah' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $subtotal
                ]);

                // kurangi stok
                $menu->stok -= $item['qty'];
                $menu->save();
            }

            DB::commit();

            // 🔥 SIMPAN DATA UNTUK HALAMAN SUKSES
            session()->put('last_order', [
                'id_pesanan' => $id_pesanan,
                'keranjang' => $keranjang,
                'total' => $total,
                'jam' => $request->jam_pengambilan,
                'metode' => $request->metode
            ]);

            // kosongkan keranjang
            session()->forget('keranjang');

            return redirect('/pesanan/sukses');

        } catch (\Exception $e) {

            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    // 🔥 HALAMAN SUKSES
    public function sukses()
    {
        $data = session()->get('last_order');

        if (!$data) {
            return redirect('/dashboard');
        }

        return view('hal_sukses', compact('data'));
    }
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use App\Models\Menu;

// class PemesananController extends Controller
// {
//     // 🔹 Tampilkan halaman checkout
//     public function index()
//     {
//         $keranjang = session()->get('keranjang', []);
//         $id_kantin = session()->get('id_kantin');

//         $total = 0;
//         foreach ($keranjang as $item) {
//             $total += $item['harga'] * $item['qty'];
//         }

//         return view('pemesanan', compact('keranjang', 'total', 'id_kantin'));
//     }

//     // 🔹 Proses simpan pesanan
//     public function simpan(Request $request)
//     {
//         $keranjang = session()->get('keranjang', []);
//         $id_kantin = session()->get('id_kantin');

//         // 🚨 validasi keranjang kosong
//         if (empty($keranjang)) {
//             return back()->with('error', 'Keranjang kosong');
//         }

//         DB::beginTransaction();

//         try {

//             $total = 0;

//             foreach ($keranjang as $id => $item) {

//                 $menu = Menu::find($id);

//                 // 🚨 validasi menu tidak ditemukan
//                 if (!$menu) {
//                     throw new \Exception("Menu tidak ditemukan");
//                 }

//                 // 🚨 VALIDASI STOK
//                 if ($menu->stok < $item['qty']) {
//                     throw new \Exception("Stok tidak cukup untuk " . $menu->nama_menu);
//                 }

//                 // hitung total
//                 $total += $item['harga'] * $item['qty'];

//                 // 🔥 KURANGI STOK
//                 $menu->stok -= $item['qty'];
//                 $menu->save();
//             }

//             // 🔥 SIMPAN KE DATABASE
//             DB::table('pesanan')->insert([
//                 'id_user' => 1, // nanti bisa pakai Auth::id()
//                 'id_kantin' => $id_kantin,
//                 'jam_pengambilan' => $request->jam_pengambilan,
//                 'total_harga' => $total,
//                 'status' => 'diproses'
//             ]);

//             DB::commit();

//             // kosongkan keranjang
//             session()->forget('keranjang');

//             return redirect('/dashboard')->with('success', 'Pesanan berhasil dibuat');

//         } catch (\Exception $e) {

//             DB::rollback();

//             return back()->with('error', $e->getMessage());
//         }
//     }
// }

// // namespace App\Http\Controllers;

// // use Illuminate\Http\Request;
// // use Illuminate\Support\Facades\DB;

// // class PemesananController extends Controller
// // {
// //     public function index()
// //     {
// //         $keranjang = session()->get('keranjang', []);
// //         $id_kantin = session()->get('id_kantin');

// //         $total = 0;
// //         foreach ($keranjang as $item) {
// //             $total += $item['harga'] * $item['qty'];
// //         }

// //         return view('pemesanan', compact('keranjang', 'total', 'id_kantin'));
// //     }

// //     public function simpan(Request $request)
// //     {
// //         $keranjang = session()->get('keranjang', []);
// //         $id_kantin = session()->get('id_kantin');

// //         $total = 0;
// //         foreach ($keranjang as $item) {
// //             $total += $item['harga'] * $item['qty'];
// //         }

// //         DB::table('pesanan')->insert([
// //             'id_user' => 1, // sementara (bisa pakai auth nanti)
// //             'id_kantin' => $id_kantin,
// //             'jam_pengambilan' => $request->jam_pengambilan,
// //             'total_harga' => $total,
// //             'status' => 'diproses'
// //         ]);

// //         // kosongkan keranjang setelah checkout
// //         session()->forget('keranjang');

// //         return redirect('/dashboard')->with('success', 'Pesanan berhasil dibuat');
// //     }
// // }