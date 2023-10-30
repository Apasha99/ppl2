<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash; 

class AuthController extends Controller
{
    public function login() {
        return view('login');
    }

    public function authenticating(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        // Cek login valid
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id == 1 && Auth::user()->status == 'inactive') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')
                    ->with('status', 'failed')
                    ->with('message', 'Your account is not active yet, please contact admin!');
            }

            $request->session()->regenerate();
            if (Auth::user()->role_id == 1) {
                return redirect('dashboardMahasiswa');
            }

            if (Auth::user()->role_id == 2) {
                return redirect('dashboardDosen');
            }

            if (Auth::user()->role_id == 3) {
                return redirect('dashboardOperator');
            }

            if (Auth::user()->role_id == 4) {
                return redirect('dashboardDepartemen');
            }
        }

        Session::flash('status', 'failed');
        Session::flash('message', 'Login gagal. Periksa username dan password Anda.');
        return redirect('/login');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }


}
