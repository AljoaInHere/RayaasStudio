<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'mitra') {
                return redirect()->route('dashboard.mitra');
            }
            return redirect()->route('dashboard.customer');
        }
        return redirect()->route('choose.role');
    }

    public function chooseRole()
    {
        return view('auth.choose_role');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->role == 'mitra') {
                return redirect()->route('dashboard.mitra');
            }
            return redirect()->route('dashboard.customer');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister(Request $request)
    {
        $role = $request->query('role', 'customer');
        if (!in_array($role, ['customer', 'mitra'])) {
            $role = 'customer';
        }
        return view('auth.register', ['role' => $role]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:customer,mitra',
        ]);

        User::create([
            'name' => $request->username,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}