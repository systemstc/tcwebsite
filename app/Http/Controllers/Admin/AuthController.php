<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                ActivityLog::record('login_failed', 'auth', null, "Inactive account login attempt: {$credentials['email']}");
                return back()->withErrors(['email' => 'This account is inactive.']);
            }

            $request->session()->regenerate();
            ActivityLog::record('login', 'auth', $user->id, "User {$user->name} logged in successfully");

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Logged in successfully.');
        }

        ActivityLog::record('login_failed', 'auth', null, "Failed login attempt for: {$credentials['email']}");

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            ActivityLog::record('logout', 'auth', $user->id, "User {$user->name} logged out");
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
