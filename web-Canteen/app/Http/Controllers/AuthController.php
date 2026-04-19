<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $credentials = [
            'nama' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa'
        ]);

        return redirect('/login')->with('success','Berhasil daftar');
    }

    // // ================= DASHBOARD =================
    // public function dashboard()
    // {
    //     return view('dashboard');
    // }

    // // ================= LOGOUT =================
    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect('/login');
    // }
}

