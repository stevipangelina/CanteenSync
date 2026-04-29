<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class KantinController extends Controller
{
    public function dashboard()
    {
        $canteens = [
            ['name' => 'Kantin A', 'image' => 'canteen1.png'],
            ['name' => 'Kantin B', 'image' => 'canteen2.png'],
            ['name' => 'Kantin C', 'image' => 'canteen3.png'],
        ];

        return view('dashboard', compact('canteens'));
    }
}