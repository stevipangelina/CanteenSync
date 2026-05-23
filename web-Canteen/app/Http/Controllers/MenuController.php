<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request, $id)
    {
        $kategori = $request->kategori;

        $menu = Menu::where('id_kantin', $id)
            ->when($kategori, function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->get();

        return view('menu_kantin', compact('menu', 'id', 'kategori'));
    }
}