<?php

namespace App\Http\Controllers;

use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class PKLController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::select('nama', 'nim')->get();
        $nim = $request->user()->mahasiswa->nim;
        $pklData = PKL::where('nim',$nim)
                ->select('semester_aktif','nilai','statusPKL','scanPKL','nim','status')->get();
        
        return view('pkl', [
            'mahasiswa' => $mahasiswa,
            'pklData' => $pklData,
        ]);
    }

    public function create(Request $request)
    {
        $nim = $request->user()->mahasiswa->nim; // Use the logged-in user to get the nim
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            // Get the active semesters for the given student
            $semesterAktifPKL = PKL::where('nim', $nim)->pluck('semester_aktif')->toArray();

            // Create an array of available semesters by diffing the full range and active semesters
            $availableSemesters = array_diff(range(6,14), $semesterAktifPKL);
        } else {
            // Handle the case where the Mahasiswa is not found
            return redirect()->route('pkl.index')->with('error', 'Mahasiswa not found with the provided nim.');
        }
        
        return view('pkl-create', compact('availableSemesters', 'mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        $nim = $request->user()->mahasiswa->nim;
        $latestPKL = PKL::where('nim', $nim)->orderBy('semester_aktif', 'desc')->first();
        
        if ($latestPKL) {
            $latestSemester = $latestPKL->semester_aktif;
            $inputSemester = $request->input('semester_aktif');

            if ($inputSemester > $latestSemester + 1) {
                // PKL diisi tidak sesuai urutan, berikan pesan kesalahan
                return redirect()->route('pkl.create')->with('error', 'Anda harus mengisi PKL sesuai urutan semester.');
        }}elseif($request->input('semester_aktif') != 6){
            return redirect()->route('pkl.create')->with('error', 'Anda harus memulai dengan PKL semester 6.');
        }
        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric','unique:pkl'], // Correct the validation rule syntax
            'statusPKL' => [Rule::in(['lulus', 'tidak lulus'])],
            'nilai'=>[Rule::in(['A', 'B','C','D','E'])],
            'scanPKL' => ['required', 'file', 'mimes:pdf', 'max:10240'], // Correct the validation rule syntax
        ]);

        $PDFPath = null;

        if ($request->hasFile('scanPKL') && $request->file('scanPKL')->isValid()) {
            $PDFPath = $request->file('scanPKL')->store('file', 'public');
        }

        $pkl = new PKL();
        $pkl->semester_aktif = $request->input('semester_aktif');
        $pkl->statusPKL = $request->input('statusPKL');
        $pkl->nilai = $request->input('nilai');
        $pkl->status = 'pending';
        $pkl->scanPKL = $PDFPath; // Assign the PDF path here
        $pkl->nim = $request->user()->mahasiswa->nim;
        $pkl->nip = $request->user()->mahasiswa->nip;
        $saved = $pkl->save();

        if ($saved) {
            return redirect()->route('pkl.index')->with('success', 'PKL added successfully');
        } else {
            return redirect()->route('pkl.create')->with('error', 'Failed to add PKL');
        }
    }

}
