<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function webLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on role
            if ($user->role->name === 'Admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name === 'Requester') {
                return redirect()->route('tasks.index');
            } elseif ($user->role->name === 'Contributor') {
                return redirect()->route('tasks.index');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role not recognized');
            }
        }

        return back()->with('error', 'Invalid credentials');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
