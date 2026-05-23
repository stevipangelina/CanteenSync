<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    
    public function login(Request $request)
    {
        $request->validate(['username' => 'required', 'password' => 'required']);
        $user = Akun::where('nama', $request->username)->first();
        
        if (!$user) {
            return back()->with('error','Username tidak ditemukan');
        }
        
        # login khusus kantin
        if ($user->role == 'kantin') {
            if ($request->password == $user->password) {
                Auth::login($user);
                return redirect('/dashboard')->with('success', 'Login kantin berhasil');
            }
            return back()->with('error','Password salah');
        }

        // login khusus mahasiswa
        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('/dashboard')->with('success', 'Login berhasil');
        }
        return back()->with('error','Password salah');
    }
    
    # Registrasi
    public function showRegister()
    {
        return view('register');
    }
        
    public function register(Request $request)
    {
        Akun::create([
            'nama' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->phone,
            'role' => 'mahasiswa'
        ]);
        return redirect('/login')->with('success','Berhasil daftar');
    }
}