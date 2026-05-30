<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\Kantin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
be/riwayat_profil
    // LOGIN VIEW

main
    public function showLogin()
    {
        return view('login');
    }

be/riwayat_profil
    // LOGIN PROCESS 
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
            $kantin = Kantin::where('id_user', $user->id)->first();

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login berhasil');

    
    public function login(Request $request)
    {
        $request->validate(['username' => 'required', 'password' => 'required']);
        $user = Akun::where('nama', $request->username)->first();
        
        if (!$user) {
            return back()->with('error','Username tidak ditemukan');
main
        }
        
        # login khusus kantin
        if ($user->role == 'kantin') {

            if ($request->password == $user->password) {
                Auth::login($user);
                $kantin = Kantin::where('id_user', $user->id)->first();

be/riwayat_profil
    // REGISTER VIEW 
    public function showRegister()
    {
        return view('register');
    }

    //  REGISTER PROCESS 
        public function register(Request $request)

                return redirect('/menu/' . $kantin->id_kantin) ->with('success', 'Login kantin berhasil');
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
main
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
be/riwayat_profil

        // LOGOUT 
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

main
}
