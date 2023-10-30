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
use Illuminate\View\View;

class OperatorController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.username', '=', 'users.username')
            ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'users.password','dosen_wali.nip', 'dosen_wali.nama as dosen_nama')
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
            'nim' => [
                'required',
                'string',
                'regex:/^\d{1,20}$/',
            ],
            'angkatan' => 'required|integer',
            'status' => 'required',
            'nip' => 'required|exists:dosen_wali,nip',
        ]);
        $username = strtolower(str_replace(' ', '', $request->nama));
        // Cek apakah username sudah digunakan, jika ya, tambahkan angka acak
        if (User::where('username', $username)->exists()) {
            $username = strtolower(str_replace(' ', '', $request->nama)) . rand(1, 100);
        }

        $password = Str::random(8);

        DB::transaction(function () use ($request, $username, $password) {
            // Membuat user baru
            $user = new User;
            $user->username = $username;
            $user->password = $password;
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

    public function edit(Request $request): View
    {
        $user = $request->user();
        $operators = Operator::join('users', 'operator.iduser', '=', 'users.id')
                ->select('operator.nama', 'operator.nip', 'users.id', 'users.username')
                ->first();
        return view('profilOperator', ['user' => $user,'operators'=>$operators]);
    }

    public function showEdit(Request $request): View
    {
        $user = $request->user();
        $operators = Operator::join('users', 'operator.iduser', '=', 'users.id')
                ->select('operator.nama', 'operator.nip', 'users.id', 'users.username','users.password')
                ->first();
        return view('profilOperator-edit', ['user' => $user,'operators'=>$operators]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => 'nullable|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8',
            'new_confirm_password' => 'nullable|same:new_password',
            'foto' => 'max:10240|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->has('foto')) {
            $fotoPath = $request->file('foto')->store('profile', 'public');
            $validated['foto'] = $fotoPath;

            $user->update([
                'foto' => $validated['foto'],
            ]);
        }

        if ($validated['new_password'] !== null) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->route('operator.showEdit')->with('error', 'Password lama tidak cocok.');
            }
        }

        DB::beginTransaction();

        try {
            $user->update([
                'username' => $validated['username'],
            ]);

            Operator::where('iduser', $user->id)->update([
                'username' => $validated['username'],
            ]);

            if ($validated['new_password'] !== null) {
                $user->update([
                    'password' => Hash::make($validated['new_password'])
                ]);
            }

            DB::commit();

            return redirect()->route('operator.edit')->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('operator.showEdit')->with('error', 'Gagal memperbarui profil.');
        }
    }
}
