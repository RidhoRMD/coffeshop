<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = User::find(Auth::id());

            // Cek apakah akun aktif
        if ($user->status == 'nonaktif') {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi Administrator.',
            ]);
        }
              // Simpan waktu login terakhir
            $user->last_login = now();
            $user->save();

            return match (Auth::user()->role) {
                'admin'   => redirect()->route('admin.dashboard'),
                'kasir'   => redirect()->route('kasir.dashboard'),
                'barista' => redirect()->route('barista.dashboard'),
                default   => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}