<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        if ($request->remember) {
            Cookie::queue('nik', $credential['nik'], 60 * 24 * 7);
            Cookie::queue('password', $credential['password'], 60 * 24 * 7);
        }

        if (Auth::attempt($credential)) {
            return redirect()->route('dashboard.index');
        }

        return redirect()->back()->with('error', 'Wrong username or password');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return to_route('login');
    }
}
