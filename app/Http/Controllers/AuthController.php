<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');
        
        // Try login with email first
        $loginData = ['email' => $credentials['email'], 'password' => $credentials['password']];
        
        // If email login fails, try with username
        if (!Auth::attempt($loginData, $remember)) {
            $loginData = ['username' => $credentials['email'], 'password' => $credentials['password']];
        }

        if (Auth::attempt($loginData, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->level) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'kesiswaan':
                    return redirect('/kesiswaan/dashboard');
                case 'guru':
                    return redirect('/guru/dashboard');
                case 'wali_kelas':
                    return redirect('/walikelas/dashboard');
                case 'konselor':
                    return redirect('/konselor/dashboard');
                case 'kepala_sekolah':
                    return redirect('/kepsek/dashboard');
                case 'siswa':
                    return redirect('/siswa/dashboard');
                case 'orang_tua':
                    return redirect('/ortu/dashboard');
                default:
                    return redirect('/admin/dashboard');
            }
        }
        
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}