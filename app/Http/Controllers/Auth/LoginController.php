<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        // Tentukan field yang digunakan: email atau username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)) {
            // Login berhasil
            $userRole = Auth::user()->role;
            $userSlug = Str::slug($userRole, '-');

            return redirect()->intended('/dashboard');
        }

        // Jika login gagal
        return back()->withErrors([
            'login' => 'Email/Username atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user

        // Hapus session dan redirect ke halaman login
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Sesuaikan dengan route login Anda
    }
}
