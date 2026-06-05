<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // tampil halaman keranjang
    public function index()
    {
//         dd(
//     Auth::check(),
//     Auth::id(),
//     session()->all()
// );
        $keranjang = session()->get('keranjang', []);
        $id_kantin = session()->get('id_kantin');

        return view('keranjang', compact('keranjang', 'id_kantin'));
    }

    // tambah ke keranjang
    public function tambah(Request $request)
{
    $menu = Menu::findOrFail($request->id);
    $keranjang = session()->get('keranjang', []);
    $id_kantin_lama = session()->get('id_kantin');

    if ($id_kantin_lama && $id_kantin_lama != $menu->id_kantin && !$request->force) {
        return back()->with('warning', [
            'message' => 'Apakah ingin mengganti pesanan pada kantin lain?',
            'menu_id' => $menu->id_menu
        ]);
    }

    if ($id_kantin_lama && $id_kantin_lama != $menu->id_kantin && $request->force) {session()->forget('keranjang');}

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
}