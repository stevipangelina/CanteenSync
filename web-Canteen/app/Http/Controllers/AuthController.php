<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ================= LOGIN VIEW =================
    public function showLogin()
    {
        return view('login');
    }

    // ================= LOGIN PROCESS =================
    public function login(Request $request)
    {
        // validasi
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // karena view pakai "username", kita mapping ke "nama"
        $credentials = [
            'nama' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login berhasil');
        }

        return back()->with('error', 'Username atau password salah');
    }

    // ================= REGISTER VIEW =================
        public function showRegister()
        {
            return view('register');
        }

        // ================= REGISTER PROCESS =================

        public function register(Request $request)
    {
        Akun::create([
            'nama' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->phone,
            'role' => 'mahasiswa'
            // 'nama' => $request->nama,
            // 'email' => $request->email,
            // 'password' => Hash::make($request->password),
            // 'no_telepon' => $request->phone,
            // 'role' => 'mahasiswa'
        ]);

        return redirect('/login')->with('success','Berhasil daftar');
    }

//         public function register(Request $request)
// {
//     // validasi
//     $request->validate([
//         'username' => 'required',
//         'email' => 'required|email|unique:akun,email',
//         'password' => 'required|min:6',
//         'phone' => 'required'
//     ]);

//     try {
//         $user = Akun::create([
//             'nama' => $request->username,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'no_telepon' => $request->phone,
//             'role' => 'mahasiswa'
//         ]);

//         // cek apakah berhasil
//         if (!$user) {
//             return back()->with('error', 'Gagal menyimpan data');
//         }

//         // auto login
//         Auth::login($user);

//         return redirect('/dashboard')->with('success', 'Berhasil daftar & login');

//     } catch (\Exception $e) {
//         // tampilkan error biar kelihatan
//         return back()->with('error', $e->getMessage());
//     }
// }

    //      public function register(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'email' => 'required|email|unique:akun,email',
    //         'password' => 'required|min:6',
    //         'phone' => 'required'
    //     ]);

    //     $user = Akun::create([
    //         'nama' => $request->username,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'no_telepon' => $request->phone,
    //         'role' => 'mahasiswa'
    //     ]);

    //     // auto login setelah register
    //     Auth::login($user);

    //     return redirect('/dashboard')->with('success', 'Berhasil daftar & login');
    // }

    //     public function register(Request $request)
    // {
    //     try {
    //         $user = Akun::create([
    //             'nama' => $request->username,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //             'no_telepon' => $request->phone,
    //             'role' => 'mahasiswa'
    //         ]);

    //         dd($user);

    //     } catch (\Exception $e) {
    //         dd($e->getMessage());
    //     }
    // }
    //     public function register(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //         'phone' => 'required'
    //     ]);

    //     $user = Akun::create([
    //         'nama' => $request->username,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'no_telepon' => $request->phone,
    //         'role' => 'mahasiswa'
    //     ]);

    //     Auth::login($user);

    //     return redirect('/dashboard')->with('success', 'Berhasil daftar & login');
    }
//     public function register(Request $request)
// {
//     // validasi
//     $request->validate([
//         'username' => 'required',
//         'email' => 'required|email',
//         'password' => 'required|min:6',
//         'phone' => 'required'
//     ]);

//     // simpan ke database
//     dd($request->all());
//     $user = Akun::create([
//         'nama' => $request->username,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//         'no_telepon' => $request->phone,
//         'role' => 'mahasiswa'
//     ]);

//     // 🔥 AUTO LOGIN SETELAH REGISTER
//     Auth::login($user);

//     // redirect ke dashboard
//     return redirect('/dashboard')->with('success', 'Berhasil daftar & login');
//}
    
    // public function register(Request $request)
    // {
    //     // validasi
    //     $request->validate([
    //         'username' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //         'phone' => 'required'
    //     ]);

    //     // mapping username → nama
    //     User::create([
    //         'nama' => $request->username,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role' => 'mahasiswa',

    //         // kalau kolom phone ADA di database
    //         'phone' => $request->phone
    //     ]);

    //     return redirect('/login')->with('success', 'Berhasil daftar');
    // }

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
