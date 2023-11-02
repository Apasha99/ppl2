<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class KHSController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::select('nama', 'nim')->get();
        $nim = $request->user()->mahasiswa->nim;
        $khsData = KHS::where('nim',$nim)
                ->select('nim', 'status', 'jumlah_sks', 'semester_aktif','jumlah_sks_kumulatif','ip_semester','ip_kumulatif','scanKHS')
                ->get();

        return view('khs', [
            'mahasiswa' => $mahasiswa,
            'khsData' => $khsData,
        ]);
    }

    public function create(Request $request)
    {
        $nim = $request->user()->mahasiswa->nim; // Use the logged-in user to get the nim
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            // Get the active semesters for the given student
            $latestKHS = KHS::where('nim', $nim)->orderBy('semester_aktif', 'desc')->first();
            $semesterAktifKHS = KHS::where('nim', $nim)->pluck('semester_aktif')->toArray();

            // Create an array of available semesters by diffing the full range and active semesters
            $availableSemesters = array_diff(range(1, 14), $semesterAktifKHS);
        } else {
            // Handle the case where the Mahasiswa is not found
            return redirect()->route('khs.index')->with('error', 'Mahasiswa not found with the provided nim.');
        }
        
        return view('khs-create', compact('availableSemesters', 'mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {   
        $nim = $request->user()->mahasiswa->nim;
        $latestKHS = KHS::where('nim', $nim)->orderBy('semester_aktif', 'desc')->first();

        if ($latestKHS) {
            $latestSemester = $latestKHS->semester_aktif;
            $inputSemester = $request->input('semester_aktif');
            
            if ($inputSemester > $latestSemester + 1) {
                // KHS diisi tidak sesuai urutan, berikan pesan kesalahan
                
                return redirect()->route('khs.create')->with('error', 'Anda harus mengisi KHS sesuai urutan semester.');
            }
        } elseif ($request->input('semester_aktif') != 1) {
            return redirect()->route('khs.create')->with('error', 'Anda harus memulai dengan KHS semester 1.');
        }
        
        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric'], // Correct the validation rule syntax
            'jumlah_sks' => ['required', 'numeric', 'between:18,24'], // Correct the validation rule syntax
            'jumlah_sks_kumulatif' => ['required', 'numeric', 'between:18,144'],
            'ip_semester' => ['required'],
            'ip_kumulatif' =>['required'],
            'scanKHS' => ['required', 'file', 'mimes:pdf', 'max:10240'], // Correct the validation rule syntax
        ]);

        $PDFPath = null;

        if ($request->hasFile('scanKHS') && $request->file('scanKHS')->isValid()) {
            $PDFPath = $request->file('scanKHS')->store('file', 'public');
        }

        $khs = new KHS();
        $khs->semester_aktif = $request->input('semester_aktif');
        $khs->jumlah_sks = $request->input('jumlah_sks');
        $khs->jumlah_sks_kumulatif = $request->input('jumlah_sks_kumulatif');
        $khs->ip_semester = $request->input('ip_semester');
        $khs->ip_kumulatif = $request->input('ip_kumulatif');
        $khs->status = 'pending';
        $khs->scanKHS = $PDFPath; // Assign the PDF path here
        $khs->nim = $request->user()->mahasiswa->nim;
        $khs->nip = $request->user()->mahasiswa->nip;
        $saved = $khs->save();

        if ($saved) {
            return redirect()->route('khs.index')->with('success', 'KHS added successfully');
        } else {
            return redirect()->route('khs.create')->with('error', 'Failed to add KHS');
        }
    }

}
