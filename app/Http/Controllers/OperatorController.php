<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.username', '=', 'users.username')
            ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'dosen_wali.nip', 'dosen_wali.nama as dosen_nama')
            ->get();

        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.role_id', 'roles.name')
            ->get();

        $operators = Operator::join('users', 'operator.username', '=', 'users.username')
            ->select('users.username', 'users.password', 'operator.nama', 'operator.nip', 'operator.fotoProfil')
            ->get();

        return view('dashboardOperator', ['operators' => $operators, 'mahasiswas' => $mahasiswas, 'users' => $users]);
    }

    public function create()
    {
        $dosens = Dosen::all();
        return view('mahasiswa-create',['dosens'=>$dosens]);
    }

    public function store(Request $request)
    {   
        $validated = $request->validate([
            'nama' => 'required',
            'nim' => 'required|numeric',
            'angkatan' => 'required|numeric',
            'status' => 'required',
            'nip' => 'required|exists:dosen_wali,nip',
        ]);

        $username = strtolower(str_replace(' ', '', $request->nama));
        // Cek apakah username sudah digunakan, jika ya, tambahkan angka acak
        if (User::where('username', $username)->exists()) {
            $username = strtolower(str_replace(' ', '', $request->nama)) . rand(1, 100);
        }

        $password = Str::random(8);

        DB::transaction(function () use ($request, $username) {
            // Membuat user baru
            $user = new User;
            $user->username = $username;
            $user->password = $request->password;
            $user->role_id = 1; // mengatur role_id menjadi 1
            $user->save();

            // Membuat mahasiswa baru
            $mahasiswa = new Mahasiswa;
            $mahasiswa->nama = $request->nama;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->angkatan = $request->angkatan;
            $mahasiswa->status = $request->status;
            $mahasiswa->nip = $request->nip;
            $mahasiswa->username = $username; // menghubungkan ke user yang baru dibuat
            $mahasiswa->iduser = $user->id;
            $mahasiswa->save();
        });

        return redirect('dashboardOperator')->with('status', 'Data Mahasiswa berhasil ditambahkan.');
    }

    public function edit($nip)
    {
        $operators = Operator::where('nip', $nip)->first();
        $users = User::all();
        return view('profilOperator', ['users' => $users, 'operators' => $operators]);
    }

    public function update(Request $request, $nip)
    {
        $operators = Operator::where('nip', $nip)->first();
        $user = User::where('username', $operators->username)->first();

        $validated = $request->validate([
            'username' => 'required',
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_confirm_password' => 'required|same:new_password',
            'fotoProfil' => 'required|max:10240|image|mimes:jpeg,png,jpg',
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            // Jika password lama benar
            $user->fill([
                'password' => Hash::make($request->new_password), // Menggunakan Hash::make() untuk mengenkripsi password baru
            ])->save();

            //$validated['password'] = Hash::make($validated['password']);

            $operators->update($validated);
            $user->update($validated);

            if ($request->hasFile('fotoProfil') && $request->file('fotoProfil')->isValid()) {
                $fotoProfil = $request->file('fotoProfil');
                $fotoProfilPath = $fotoProfil->store('fotoProfil', 'public');
                $operators->fotoProfil = $fotoProfilPath;
                $operators->save();
            }

            return redirect('profilOperator')->with('status', 'Profil berhasil diupdate');
        } else {
            return redirect()->route('operator.edit', $nip)->withErrors($validated)->withInput();
        }
    }
}
