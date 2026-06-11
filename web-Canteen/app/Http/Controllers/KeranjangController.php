<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        $id_kantin = session()->get('id_kantin');

        return view('keranjang', compact('keranjang', 'id_kantin'));
    }

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

        if ($id_kantin_lama && $id_kantin_lama != $menu->id_kantin && $request->force) {
            session()->forget('keranjang');
        }

        session()->put('id_kantin', $menu->id_kantin);
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$menu->id_menu])) {
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

    public function update(Request $request)
    {
        $id = $request->input('id');
        $qty = $request->input('qty');

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            if ($qty <= 0) {
                unset($keranjang[$id]);
            } else {
                $keranjang[$id]['qty'] = $qty;
            }
            session()->put('keranjang', $keranjang);

            // hapus id_kantin jika kosong
            if (empty($keranjang)) {
                session()->forget('id_kantin');
            }

            return back()->with('success', 'Keranjang berhasil diupdate');
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    public function hapus($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);

            if (empty($keranjang)) {
                session()->forget('id_kantin');
            }

            return back()->with('success', 'Item berhasil dihapus dari keranjang');
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang');
    }
}