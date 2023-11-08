<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Dosen;
use App\Models\GenerateAkun;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;

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

            $generate_akun = new GenerateAkun;
            $generate_akun->nim = $request->nim;
            $generate_akun->username = $username;
            $generate_akun->password = $password;
            $generate_akun->save();
        });

        return redirect('dashboardOperator')->with('status', 'Data Mahasiswa berhasil ditambahkan. Username : '. $username . ' Password : '. $password)->withInput();
    }

    public function edit(Request $request): View
    {
        $user = $request->user();
        $nip = $request->user()->operator->nip;
        $operators = Operator::join('users', 'operator.iduser', '=', 'users.id')
                ->where('nip',$nip)
                ->select('operator.nama', 'operator.nip', 'users.id', 'users.username')
                ->first();
        return view('profilOperator', ['user' => $user,'operators'=>$operators]);
    }

    public function showEdit(Request $request): View
    {
        $user = $request->user();
        $nip = $request->user()->operator->nip;
        $operators = Operator::join('users', 'operator.iduser', '=', 'users.id')
                ->where('nip',$nip)
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

    public function tambah()
    {
        $mahasiswas = Mahasiswa::join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                                ->select('mahasiswa.nama as nama', 'mahasiswa.nim','mahasiswa.nip','mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip','dosen_wali.nama as dosen_nama','mahasiswa.username')
                                ->whereNull('mahasiswa.iduser')->get();
  
        return view('tambahMahasiswa', compact('mahasiswas'));
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        $file = request()->file('file');

        if ($file) {
            // Memeriksa apakah file yang diunggah adalah file Excel XLSX
            if ($file->getClientOriginalExtension() === 'xlsx') {
                Excel::import(new MahasiswaImport, $file, 'Xlsx');
                return redirect('tambahMahasiswa')->with('status', 'Data Mahasiswa berhasil ditambahkan.');
            } else {
                return redirect('tambahMahasiswa')->with('error', 'File yang diunggah harus dalam format Excel XLSX.');
            }
        } else {
            return redirect('tambahMahasiswa')->with('error', 'Anda belum mengunggah file.');
        }
    }


    public function export()
    {
        return Excel::download(new MahasiswaExport, 'mahasiswa.xlsx');
    }

    public function generateAkun(Request $request) {
        // Get the array of NIMs in the Mahasiswa table with a null "iduser"
        $nimsWithNullIduser = Mahasiswa::whereNull('iduser')->pluck('nim');
    
        // Memulai transaksi database
        DB::beginTransaction();
    
        try {
            foreach ($nimsWithNullIduser as $generate_akun_nim) {
                // Get the Mahasiswa record related to this NIM
                $mahasiswa = Mahasiswa::where('nim', $generate_akun_nim)->first();
    
                if ($mahasiswa) {
                    // Generate a username by removing spaces and making it lowercase
                    $username = strtolower(str_replace(' ', '', $mahasiswa->nama));
    
                    // Check if the username already exists, and append a random number until it's unique
                    while (User::where('username', $username)->exists()) {
                        $username = strtolower(str_replace(' ', '', $mahasiswa->nama)) . rand(1, 100);
                    }
    
                    $password = Str::random(8);
                    
                    GenerateAkun::create([
                        'nim' => $generate_akun_nim,
                        'username' => $username,
                        'password' => $password, // Password belum di-hash
                    ]);
    
                    // Create a new User in the "user" table
                    $user = User::create([
                        'username' => $username,
                        'password' => Hash::make($password), // Hash the password
                        'role_id' => 1,
                    ]);
    
                    // Update the Mahasiswa with the generated username and "iduser"
                    $mahasiswa->username = $username;
                    $mahasiswa->iduser = $user->id;
                    $mahasiswa->save();
                } else {
                    // Handle the case where Mahasiswa record doesn't exist
                    DB::rollBack();
                    return redirect('tambahMahasiswa')->with('error', 'Mahasiswa record not found for NIM: ' . $generate_akun_nim);
                }
            }
    
            // Commit the transaction
            DB::commit();
    
            return redirect('dashboardOperator')->with('status', 'Data Mahasiswa berhasil digenerate.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of any errors
            DB::rollBack();
            return redirect('tambahMahasiswa')->with('error', 'Gagal menggenerate akun Mahasiswa.');
        }
    }    
}