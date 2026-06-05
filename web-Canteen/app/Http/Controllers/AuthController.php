<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\Kantin;
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

        $user = Akun::where(
            'nama',
            $request->username
        )->first();

        if (!$user)
        {
            return back()->with(
                'error',
                'Username tidak ditemukan'
            );
        }
        if ($user->role == 'kantin')
        {
            if (
                Hash::check(
                    $request->password,
                    $user->password
                )
            )
            {
                Auth::login($user);

                $kantin = Kantin::where(
                    'id_user',
                    $user->id
                )->first();

                if (!$kantin)
                {
                    return back()->with(
                        'error',
                        'Data kantin tidak ditemukan'
                    );
                }

                return redirect(
                    '/menu/' . $kantin->id_kantin
                )->with(
                    'success',
                    'Login kantin berhasil'
                );
            }

            return back()->with(
                'error',
                'Password salah'
            );
        }

        if (
            Hash::check(
                $request->password,
                $user->password
            )
        )
        {
            Auth::login($user);
            return redirect('/dashboard')
                ->with(
                    'success',
                    'Login berhasil'
                );
        }

        return back()->with(
            'error',
            'Password salah'
        );
    }
    public function showRegister()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        $request->validate([ 
            'username' => 'required|unique:akun,nama',
            'email' => ['required', 'email', 'unique:akun,email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/' ],
            'password' => 'required|min:3', 'phone' => [ 'required', 'regex:/^08[0-9]{8,13}$/' ] ],
            [ 'email.regex' => 'Email harus menggunakan @gmail.com', 
            'phone.regex' => 'Nomor harus diawali 08 dan hanya angka' 
        ]);

        Akun::create([
            'nama' => $request->username,
            'email' => $request->email,
            'password' => Hash::make( $request->password ),
            'no_telepon' => $request->phone,
            'role' => 'mahasiswa'
        ]);

        return redirect('/login')->with(
            'success',
            'Berhasil daftar'
        );
    }
    public function logout()
    {
        Auth::logout();

        return redirect('/login')
            ->with(
                'success',
                'Berhasil logout'
            );
    }
}