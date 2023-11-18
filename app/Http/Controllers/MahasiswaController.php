<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    //ini bagian profil sekali pakai
    public function edit(Request $request): View
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip', 'mahasiswa.alamat', 'mahasiswa.kabkota', 'mahasiswa.provinsi', 'mahasiswa.noHandphone', 'users.id', 'users.username', 'users.password','users.foto')
            ->first();
        return view('profilMahasiswa', ['user' => $user, 'mahasiswas' => $mahasiswas]);
    }

    public function showEdit(Request $request): View
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;
        $kabupatenKotaOptions = ["Kabupaten Demak", "Kabupaten Kudus", "Kabupaten Boyolali", "Kota Solo","Kota Bandung", "Kabupaten Ciamis", "Kabupaten Cianjur", "Kabupaten Cirebon"];
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip', 'mahasiswa.alamat', 'mahasiswa.kabkota', 'mahasiswa.provinsi', 'mahasiswa.noHandphone', 'users.id', 'users.username', 'users.password','users.foto')
            ->first();
        return view('profilMahasiswa-edit', ['user' => $user, 'mahasiswas' => $mahasiswas,'kabupatenKotaOptions'=>$kabupatenKotaOptions]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'alamat' => 'required|string',
            'kabkota' => 'required|string',
            'provinsi' => 'required|string',
            'noHandphone' => 'required',
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
                return redirect()
                    ->route('mahasiswa.showEdit')
                    ->with('error', 'Password lama tidak cocok.');
            }
        }

        DB::beginTransaction();

        try {
            $user->update([
                'username' => $validated['username'],
                'cekProfil' => 1,
            ]);

            Mahasiswa::where('iduser', $user->id)->update([
                'username' => $validated['username'],
                'alamat' => $validated['alamat'],
                'kabkota' => $validated['kabkota'],
                'provinsi' => $validated['provinsi'],
                'noHandphone' => $validated['noHandphone'],
            ]);

            if ($validated['new_password'] !== null) {
                $user->update([
                    'password' => Hash::make($validated['new_password']),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('dashboardMahasiswa')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('mahasiswa.showEdit')
                ->with('error', 'Gagal memperbarui profil.');
        }
    }

    //ini yang bagian profil mahasiswa
    public function editProfil(Request $request): View
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;
        
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip', 'mahasiswa.alamat', 'mahasiswa.kabkota', 'mahasiswa.provinsi', 'mahasiswa.noHandphone', 'users.id', 'users.username', 'users.password','users.foto')
            ->first();
        return view('editprofilMahasiswa', ['user' => $user, 'mahasiswas' => $mahasiswas]);
    }

    public function showProfil(Request $request): View
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;
        $kabupatenKotaOptions = ["Kabupaten Demak", "Kabupaten Kudus", "Kabupaten Boyolali", "Kota Solo","Kota Bandung", "Kabupaten Ciamis", "Kabupaten Cianjur", "Kabupaten Cirebon"];
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip', 'mahasiswa.alamat', 'mahasiswa.kabkota', 'mahasiswa.provinsi', 'mahasiswa.noHandphone', 'users.id', 'users.username', 'users.password','users.foto')
            ->first();
        return view('editprofilMahasiswa-show', ['user' => $user, 'mahasiswas' => $mahasiswas,'kabupatenKotaOptions'=>$kabupatenKotaOptions]);
    }

    public function updateProfil(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'alamat' => 'nullable|string',
            'kabkota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'noHandphone' => 'nullable',
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
                return redirect()
                    ->route('mahasiswa.showProfil')
                    ->with('error', 'Password lama tidak cocok.');
            }
        }

        DB::beginTransaction();

        try {
            $user->update([
                'username' => $validated['username'],
                'cekProfil' => 1,
            ]);

            Mahasiswa::where('iduser', $user->id)->update([
                'username' => $validated['username'],
                'alamat' => $validated['alamat'],
                'kabkota' => $validated['kabkota'],
                'provinsi' => $validated['provinsi'],
                'noHandphone' => $validated['noHandphone'],
            ]);

            if ($validated['new_password'] !== null) {
                $user->update([
                    'password' => Hash::make($validated['new_password']),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('mahasiswa.editProfil')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('mahasiswa.showProfil')
                ->with('error', 'Gagal memperbarui profil.');
        }
    }

}
