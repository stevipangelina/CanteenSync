<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function lihatMenuMahasiswa(Request $request, $id)
    {
        $kantin = Akun::findOrFail($id);
        $kategori = $request->kategori ?? null;

        $menu = Menu::where('id_kantin', $id)
                    ->when($kategori, function($query) use ($kategori){
                        $query->where('kategori', $kategori);
                    })
                    ->get();

        return view('menu_kantin', compact('menu','id','kategori','kantin'));
    }

    # view menu
    public function index(Request $request, $id)
    {
        $kategori = $request->kategori;
        $kantin = Akun::findOrFail($id);
        $menu = Menu::where('id_kantin', $id)
                    ->when($kategori, function ($query) use ($kategori) {
                        $query->where('kategori', $kategori);
                    })->get();

        // LOGIN SEBAGAI KANTIN
        if (Auth::check() && Auth::user()->role == 'kantin') {
            return view('kelola_menu_kantin', compact(
                'menu', 'id', 'kategori', 'kantin'));
        }

        // LOGIN SEBAGAI MAHASISWA
        return view('menu_kantin', compact(
            'menu', 'id', 'kategori', 'kantin'));
    }

    # view form tambah menu
    public function create($id)
    {
        $menu = null; 
        return view('form_edit_add_menu', compact('menu','id'));
    }

    # view kelola menu (mengambil semua menu)
    public function kelolaMenu($id, Request $request)
    {
        $kategori = $request->kategori ?? null;
        $kantin = Akun::findOrFail($id);
        $menu = Menu::where('id_kantin', $id)
                    ->when($kategori, function ($query) use ($kategori) {
                        $query->where('kategori', $kategori);
                    })->get();

        return view('kelola_menu_kantin', compact(
            'menu', 'id', 'kategori', 'kantin'
        ));
    }

    # menyimpan menu
    public function store(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori'  => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $namaFile = null;

        # upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('gambar_menu'),$namaFile);
        }

        # simpan ke db
        Menu::create([
            'id_kantin' => $id,
            'nama_menu' => $request->nama_menu,
            'kategori'  => $request->kategori,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'gambar'    => $namaFile
        ]);

        return redirect('/menu/' . $id)
            ->with('success', 'Menu berhasil ditambahkan');
    }

    # edit menu
    public function edit($id, $id_menu)
    {
        $menu = Menu::findOrFail($id_menu);
        return view('form_edit_add_menu', compact('menu', 'id'));
    }

    # update menu
    public function update(Request $request, $id, $id_menu)
    {
        $menu = Menu::findOrFail($id_menu);
        $namaFile = $menu->gambar;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('gambar_menu'), $namaFile);
        }

        # simpan ke db
        $menu->update([
            'nama_menu' => $request->nama_menu,
            'kategori'  => $request->kategori,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'gambar'    => $namaFile
        ]);

        return redirect('/menu/' . $id)
            ->with('success', 'Menu berhasil diupdate');
    }

    # hapus menu
    public function destroy($id, $id_menu)
    {
        $menu = Menu::findOrFail($id_menu);
        $menu->delete();

        return redirect('/menu/' . $id)
            ->with('success', 'Menu berhasil dihapus');
    }
}