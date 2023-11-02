<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash; 
use App\Models\Operator;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    public function login() {
        return view('login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = $request->user(); 
        
            if ($user->role_id === 1 ) {
                if($user->cekProfil === 1){
                    return redirect()->intended('/dashboardMahasiswa');
                }
                return redirect()->route('mahasiswa.edit')->with('error','Harap lengkapi data profil anda!');
            } else if ($user->role_id === 2) {
                return redirect()->intended('/dashboardDosen');
            } else if ($user->role_id === 3) {
                return redirect()->intended('/dashboardOperator');
            } else if ($user->role_id === 4) {
                return redirect()->intended('/dashboardDepartemen');
            }
            
        };

        return back()->with('loginError', 'Login Gagal');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

}
