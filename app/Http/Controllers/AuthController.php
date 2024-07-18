<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('admin.login.index');
    }

    public function verify(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
            return redirect()->intended('admin');
        }
        else if (Auth::guard('kasir')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'kasir'])) {
            return redirect()->intended('kasir');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout() {
       
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        else if (Auth::guard('kasir')->check()) {
            Auth::guard('kasir')->logout();
        }
 
        return redirect('/admin/login');
    }
}
