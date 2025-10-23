<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/products');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // Tampilkan Halaman Register
    public function registerForm()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|max:255',
        ]);

        $user_model = new User;
        $user = $user_model->get_user()->where("email", $request['email'])->first();

        if (!empty($user)) {
            return redirect()->route('register')->with(['error' => 'Email yang anda masukkan sudah terdaftar.']);
        }

       $user_model->storeUser($request);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }

    // Log out
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }   
}
    