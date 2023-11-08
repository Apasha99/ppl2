<?php

namespace App\Http\Controllers;

use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

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
        // Periksa apakah data PKL sudah ada untuk semester yang dipilih
        $existingPKL = PKL::where('nim', $nim)->first();

        if ($existingPKL) {
            $errorMessage = "Anda telah memasukkan progress PKL";
            Session :: flash ('error', $errorMessage);
            // Jika data PKL sudah ada, lakukan pembaruan daripada penambahan
            return $this->update($request, $existingPKL);
        }

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

        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric'],
            'statusPKL' => [Rule::in(['lulus', 'tidak lulus'])],
            'nilai' => [Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'scanPKL' => ['required', 'file', 'mimes:pdf', 'max:10240'],
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

    private function update(Request $request, PKL $existingPKL): RedirectResponse
    {
        $validated = $request->validate([
            'statusPKL' => [Rule::in(['lulus', 'tidak lulus'])],
            'nilai' => [Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'scanPKL' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $PDFPath = null;

        if ($request->hasFile('scanPKL') && $request->file('scanPKL')->isValid()) {
            $PDFPath = $request->file('scanPKL')->store('file', 'public');
        }

        $existingPKL->statusPKL = $request->input('statusPKL');
        $existingPKL->nilai = $request->input('nilai');
        $existingPKL->status = 'pending';
        $existingPKL->scanPKL = $PDFPath; // Assign the PDF path here
        $saved = $existingPKL->save();

        if ($saved) {
            return redirect()->route('pkl.index')->with('success', 'PKL updated successfully');
        } else {
            return redirect()->route('pkl.create')->with('error', 'Failed to update PKL');
        }
    }

}
