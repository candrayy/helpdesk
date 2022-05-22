<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect('admin');
            } elseif (Auth::user()->role_id == 2) {
                return redirect('user');
            } elseif (Auth::user()->role_id == 3) {
                return redirect('technician');
            }
        }
        return view('login-regist.login');
    }

    public function loginAttempt(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'status' => 'active'
        ];

        if (Auth::Attempt($data)) {
            if (Auth::user()->role_id == 1) {
                return redirect('admin');
            } elseif (Auth::user()->role_id == 2) {
                return redirect('user');
            } elseif (Auth::user()->role_id == 3) {
                return redirect('technician');
            }
        }else{
            return redirect('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }
}
