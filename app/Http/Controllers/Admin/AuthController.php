<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->is_admin) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'ليس لديك صلاحية الوصول إلى لوحة التحكم',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'بيانات الاعتماد المقدمة غير صحيحة',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
} 