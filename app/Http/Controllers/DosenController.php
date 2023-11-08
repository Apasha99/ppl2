<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Dosen; // Pastikan mengimpor model Dosen
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function detail(Request $request, $nim){
        $mahasiswa = Mahasiswa::where('nim' , $nim)
                            ->select('nama','nim','angkatan','nip')
                            ->first();

        $dosen = Dosen::leftJoin('users', 'dosen_wali.iduser', '=', 'users.id')
                ->where('dosen_wali.iduser', Auth::user()->id)
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.username')
                ->first();
        //$irsData = IRS::select('nim', 'jumlah_sks', 'semester_aktif', 'scanIRS')->orderBy('semester_aktif', 'asc')->get();

        $irsData = IRS::with('mahasiswa', 'pkl')
                ->where('irs.nim', $nim)
                ->select('irs.semester_aktif', 'irs.nim', 'irs.jumlah_sks', 'irs.semester_aktif', 'irs.scanIRS', 'pkl.scanPKL', 'pkl.nilai')
                ->orderBy('semester_aktif', 'asc')
                ->get();

        return view('detailMahasiswa', [
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
            'irsData' => $irsData
        ]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $nip = $request->user()->dosen->nip;
        
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip',$nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username')
            ->first();
        return view('profilDosen', ['user' => $user, 'dosens' => $dosens]);
    }

    public function showEdit(Request $request)
    {
        $user = $request->user();
        $nip = $request->user()->dosen->nip;
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip',$nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username', 'users.password')
            ->first();
        return view('profilDosen-edit', ['user' => $user, 'dosens' => $dosens]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => 'nullable|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8',
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
