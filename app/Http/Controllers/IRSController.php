<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class IRSController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::select('nama', 'nim')->get();
        $irsData = IRS::select('nim', 'status', 'jumlah_sks', 'semester_aktif','scanIRS')->get();

        return view('irs', [
            'mahasiswa' => $mahasiswa,
            'irsData' => $irsData,
        ]);
    }

    public function create(Request $request)
    {
        $nim = $request->user()->mahasiswa->nim; // Use the logged-in user to get the nim
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            // Get the active semesters for the given student
            $semesterAktifIRS = IRS::where('nim', $nim)->pluck('semester_aktif')->toArray();

            // Create an array of available semesters by diffing the full range and active semesters
            $availableSemesters = array_diff(range(1, 14), $semesterAktifIRS);
        } else {
            // Handle the case where the Mahasiswa is not found
            return redirect()->route('irs.index')->with('error', 'Mahasiswa not found with the provided nim.');
        }
        
        return view('irs-create', compact('availableSemesters', 'mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric','unique:irs'], // Correct the validation rule syntax
            'jumlah_sks' => ['required', 'numeric', 'between:1,24'], // Correct the validation rule syntax
            'scanIRS' => ['required', 'file', 'mimes:pdf', 'max:10240'], // Correct the validation rule syntax
        ]);

        $PDFPath = null;

        if ($request->hasFile('scanIRS') && $request->file('scanIRS')->isValid()) {
            $PDFPath = $request->file('scanIRS')->store('file', 'public');
        }

        $irs = new IRS();
        $irs->semester_aktif = $request->input('semester_aktif');
        $irs->jumlah_sks = $request->input('jumlah_sks');
        $irs->status = 'pending';
        $irs->scanIRS = $PDFPath; // Assign the PDF path here
        $irs->nim = $request->user()->mahasiswa->nim;
        $irs->nip = $request->user()->mahasiswa->nip;
        $saved = $irs->save();

        if ($saved) {
            return redirect()->route('irs.index')->with('success', 'IRS added successfully');
        } else {
            return redirect()->route('irs.create')->with('error', 'Failed to add IRS');
        }
    }

}
