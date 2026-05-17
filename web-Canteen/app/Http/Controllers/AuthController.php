<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // LOGIN VIEW
    public function showLogin()
    {
        return view('login');
    }

    // LOGIN PROCESS 
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'nama' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login berhasil');
        }

        return back()->with('error', 'Username atau password salah');
    }

    // REGISTER VIEW 
    public function showRegister()
    {
        return view('register');
    }

    //  REGISTER PROCESS 
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

        // LOGOUT 
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
