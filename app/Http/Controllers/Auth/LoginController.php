<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

            return redirect()->intended($this->redirectTo());
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

    protected function redirectTo()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'SuperAdmin':
            case 'Admin':
                return '/admin-dashboard';
            case 'User':
                return '/dashboard';
            default:
                return '/';
        }
    }

    public function showregisterForm()
    {
        return view('auth.auth-register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'User', // default role
        ]);

        auth()->login($user);

        return redirect()->route('login')->with('success', 'User created successfully.');
    }
}
