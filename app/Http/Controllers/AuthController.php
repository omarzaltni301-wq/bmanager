<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
        $remember = $request->has('remember');
        $loginType = $request->input('login_type', 'user');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            if ($loginType === 'admin') {
                if (Auth::user()->is_admin) {
                    return redirect()->intended(route('admin.dashboard'));
                } else {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'You do not have administrative privileges.',
                    ])->withInput($request->only('email'));
                }
            }
            
            // "get it back before the changes" -> user login goes to normal dashboard
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted',
        ], [
            'full_name.regex' => 'Name cannot contain numbers or special symbols.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to BMANAGER!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
