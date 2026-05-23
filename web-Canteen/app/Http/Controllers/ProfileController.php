<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required'
        ]);

        $user = Auth::user();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        if ($request->password != null) {$user->password = Hash::make($request->password);} $user->save();
        
        return back()->with('success','Profil berhasil diperbarui');
    }
}