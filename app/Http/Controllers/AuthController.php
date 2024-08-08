<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if (Auth::guard('karyawan')->attempt(['nik' => $request->nik, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with('warning', 'NIK atau PASSWORD yang dimasukan salah');
        }
    }
    public function proseslogout()
    {
       if (Auth::guard('karyawan')->check()) { 
        Auth::guard('karyawan')->logout();
        return redirect('/');
        }

    }

    public function proseslogoutadmin()
    {
        if (Auth::guard('users')->check()) { 
            Auth::guard('users')->logout();
            return redirect('/panel');
            }
    }

    public function prosesloginadmin(Request $request)
    {
        if (Auth::guard('users')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/panel/dashboardadmin');
        } else {
            return redirect('/panel')->with('warning', 'Email / Password salah');
        }
    }
}

