<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('admin.login.index');
    }  

    public function verify(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors([
                'mesg' => 'Email atau password anda salah!',
            ]);
        }else{
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
                return redirect()->intended('admin');
            }
            else if (Auth::guard('kasir')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'kasir'])) {
                return redirect()->intended('kasir');
            }
     
        }
        return back()->withErrors([
            'mesg' => 'Email atau password anda salah!',
        ]);
    }


    public function checkAuth(Request $request)
    {
        return response()->json(['authenticated' => $request->session()->has('user_name')
        , 'auth_kode' => $request->session()->get('kode', false)
        , 'auth_name' => $request->session()->get('user_name', false)
        , 'auth_meja' => $request->session()->get('meja', false)
    ]);
    }

    public function ajaxLoginWithName(Request $request)
    {
        function generateFourDigitCode() {
            return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'authenticated' => $request,
            ]);
        }else{
            $request->session()->put([
                'user_name' => $request->name,
                'kode' => generateFourDigitCode(),
                'meja' => $request->meja
            ]);
            return response()->json(['authenticated' => true, 'authenticatedKode' => $request->session()->has('kode')]);
        }
        return;
    }
   
    public function logoutUser(Request $request)
    {
        $request->session()->forget('user_name');
        $request->session()->forget('kode');
        $request->session()->forget('meja');

        return response()->json(['authenticated' => false]);
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