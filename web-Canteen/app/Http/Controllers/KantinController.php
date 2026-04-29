<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KantinController extends Controller
{
    public function dashboard()
    {
        $canteens = [
            [
                'id' => 1,
                'name' => 'Kantin A',
                'image' => 'canteen1.png'
            ],
            [
                'id' => 2,
                'name' => 'Kantin B',
                'image' => 'canteen2.png'
            ],
            [
                'id' => 3,
                'name' => 'Kantin C',
                'image' => 'canteen3.png'
            ],
        ];

        return view('dashboard', compact('canteens'));
    }
}