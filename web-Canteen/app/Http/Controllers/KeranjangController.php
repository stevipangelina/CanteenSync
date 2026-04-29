<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class KeranjangController extends Controller
{
    // tampil halaman keranjang
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        $id_kantin = session()->get('id_kantin');

        return view('hal_keranjang', compact('keranjang', 'id_kantin'));
    }
    // public function index()
    // {
    //     $keranjang = session()->get('keranjang', []);
    //     return view('hal_keranjang', compact('keranjang'));
    // }

    // tambah ke keranjang
    public function tambah(Request $request)
{
    $menu = Menu::findOrFail($request->id);

    $keranjang = session()->get('keranjang', []);
    $id_kantin_lama = session()->get('id_kantin');

    // 🚨 jika beda kantin & belum konfirmasi
    if ($id_kantin_lama && $id_kantin_lama != $menu->id_kantin && !$request->force) {
        return back()->with('warning', [
            'message' => 'Apakah ingin mengganti pesanan pada kantin lain?',
            'menu_id' => $menu->id_menu
        ]);
    }

    // 🔥 jika user setuju → hapus keranjang lama
    if ($id_kantin_lama && $id_kantin_lama != $menu->id_kantin && $request->force) {
        session()->forget('keranjang');
    }

    // simpan id kantin baru
    session()->put('id_kantin', $menu->id_kantin);

    $keranjang = session()->get('keranjang', []);

    if(isset($keranjang[$menu->id_menu])) {
        $keranjang[$menu->id_menu]['qty']++;
    } else {
        $keranjang[$menu->id_menu] = [
            'nama' => $menu->nama_menu,
            'harga' => $menu->harga,
            'gambar' => $menu->gambar,
            'qty' => 1
        ];
    }

    session()->put('keranjang', $keranjang);

    return back()->with('success', 'Pesanan dimasukkan ke keranjang');
}
    // public function tambah(Request $request)
    // {
    //     $menu = Menu::findOrFail($request->id);

    //     $keranjang = session()->get('keranjang', []);

    //     // simpan id kantin
    //     session()->put('id_kantin', $menu->id_kantin);

    //     if(isset($keranjang[$menu->id_menu])) {
    //         $keranjang[$menu->id_menu]['qty']++;
    //     } else {
    //         $keranjang[$menu->id_menu] = [
    //             'nama' => $menu->nama_menu,
    //             'harga' => $menu->harga,
    //             'gambar' => $menu->gambar,
    //             'qty' => 1
    //         ];
    //     }

    //     session()->put('keranjang', $keranjang);

    //     return back();
    // }
    // public function tambah(Request $request)
    // {
    //     $menu = Menu::findOrFail($request->id);

    //     $keranjang = session()->get('keranjang', []);

    //     if(isset($keranjang[$menu->id_menu])) {
    //         $keranjang[$menu->id_menu]['qty']++;
    //     } else {
    //         $keranjang[$menu->id_menu] = [
    //             'nama' => $menu->nama_menu,
    //             'harga' => $menu->harga,
    //             'gambar' => $menu->gambar,
    //             'qty' => 1
    //         ];
    //     }

    //     session()->put('keranjang', $keranjang);

    //     return back()->with('success', 'Ditambahkan ke keranjang');
    // }

    // update qty (+ / -)
    public function update(Request $request)
    {
        $keranjang = session()->get('keranjang', []);

        if(isset($keranjang[$request->id])) {
            $keranjang[$request->id]['qty'] = $request->qty;

            if($request->qty <= 0){
                unset($keranjang[$request->id]);
            }
        }

        session()->put('keranjang', $keranjang);

        return back();
    }



    // hapus item
    public function hapus($id)
    {
        $keranjang = session()->get('keranjang', []);

        if(isset($keranjang[$id])) {
            unset($keranjang[$id]);
        }

        session()->put('keranjang', $keranjang);

        return back();
    }
}