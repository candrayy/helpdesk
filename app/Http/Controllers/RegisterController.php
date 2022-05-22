<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Auth;

class RegisterController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')->get();
        if(Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect('admin');
            } elseif (Auth::user()->role_id == 2) {
                return redirect('user');
            } elseif (Auth::user()->role_id == 3) {
                return redirect('technician');
            }
        }else{
            return view('login-regist.register', compact('roles'));
        }
        
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);
        return redirect('login');
    }
}
