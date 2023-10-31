<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Add this for validation rule

class IRSController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::select('nama', 'nim')->get();

        $irsData = IRS::select('nim', 'status', 'jumlah_sks', 'semester_aktif')->get();

        return view('irs', [
            'mahasiswa' => $mahasiswa,
            'irsData' => $irsData,
        ]);
    }

    public function create(Request $request)
    {
        $nim = $request->input('nim');
        $mahasiswa = Mahasiswa::all();

        // Get the active semesters for the given student
        $semesterAktifIRS = IRS::where('nim', $nim)->pluck('semester_aktif')->all();

        // Check if IRS is already filled for the given student and active semester
        $irsSudahDiisi = IRS::where('nim', $nim)->where('semester_aktif', $semesterAktifIRS)->exists();

        // Create an array of available semesters by diffing the full range and active semesters
        $availableSemesters = array_diff(range(1, 14), $semesterAktifIRS);
        
        return view('irs-create', compact('availableSemesters', 'irsSudahDiisi'));
    }

    public function store(Request $request)
    {
        // Store the uploaded file
        $scanIRSPath = $request->file('scanIRS')->store('scanIRS', 'local');

        $validatedData = $request->validate([
            'semester_aktif' => ['required', 'numeric', Rule::in(range(1, 14))],
            'jumlah_sks' => 'required|numeric|between:1,24',
            'scanIRS' => 'required|file|mimes:pdf|max:10240',
            'nim' => ['required', 'exists:mahasiswa,nim'],
        ]);

        // Retrieve the 'nip' from the related Mahasiswa model based on the student's data
        $nim = $request->input('nim');
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        // Check if the Mahasiswa exists (you can add additional checks here)
        if ($mahasiswa) {
            // Include the 'status' and 'dosen_wali' fields in the data
            $validatedData['status'] = 'pending';
            $validatedData['dosen_wali'] = $mahasiswa->nip;

            // Set the 'nim' field to match the provided 'nim'
            $validatedData['nim'] = $nim;

            // Store the file path in the database
            $validatedData['scanIRS'] = $scanIRSPath;

            IRS::create($validatedData);

            return redirect()->route('irs.create')->with('success', 'Data IRS berhasil ditambahkan!');
        } else {
            return redirect()->route('irs.create')->with('error', 'Mahasiswa not found with the provided nim.');
        }
    }
}
