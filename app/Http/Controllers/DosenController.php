<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function detail(Request $request, $mahasiswa){
        $irsData = IRS::select('nim', 'jumlah_sks', 'semester_aktif', 'scanIRS')->orderBy('semester_aktif', 'asc')->get();

        return view('detailMahasiswa', [
            'mahasiswa' => $mahasiswa,
            'irsData' => $irsData,
        ]);
    }
    public function edit(Request $request): View
    {
        $user = $request->user();
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username')
                ->first();
        return view('profilDosen', ['user' => $user,'dosens'=>$dosens]);
    }

    public function showEdit(Request $request): View
    {
        $user = $request->user();
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username','users.password')
                ->first();
        return view('profilDosen-edit', ['user' => $user,'dosens'=>$dosens]);
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
                return redirect()->route('dosen.showEdit')->with('error', 'Password lama tidak cocok.');
            }
        }
        
        DB::beginTransaction();

        try {
            $user->update([
                'username' => $validated['username'],
            ]);

            Dosen::where('iduser', $user->id)->update([
                'username' => $validated['username'],
            ]);

            if ($validated['new_password'] !== null) {
                $user->update([
                    'password' => Hash::make($validated['new_password'])
                ]);
            }

            DB::commit();

            return redirect()->route('dosen.edit')->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dosen.showEdit')->with('error', 'Gagal memperbarui profil.');
        }
    }
}
