<?php

namespace App\Http\Controllers;

use App\Models\Skripsi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class SkripsiController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::select('nama', 'nim')->get();
        $nim = $request->user()->mahasiswa->nim;
        $skripsiData = Skripsi::where('nim',$nim)
                    ->select('semester_aktif','nilai','lama_studi','tanggal_sidang','statusSkripsi','nim','status','scanSkripsi')->get();

        return view('skripsi', [
            'mahasiswa' => $mahasiswa,
            'skripsiData' => $skripsiData,
        ]);
    }

    public function create(Request $request)
    {
        $nim = $request->user()->mahasiswa->nim; // Use the logged-in user to get the nim
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($mahasiswa) {
            // Get the active semesters for the given student
            $semesterAktifSkripsi = Skripsi::where('nim', $nim)->pluck('semester_aktif')->toArray();

            // Create an array of available semesters by diffing the full range and active semesters
            $availableSemesters = array_diff(range(7,14), $semesterAktifSkripsi);
        } else {
            // Handle the case where the Mahasiswa is not found
            return redirect()->route('skripsi.index')->with('error', 'Mahasiswa not found with the provided nim.');
        }
        
        return view('skripsi-create', compact('availableSemesters', 'mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        $nim = $request->user()->mahasiswa->nim;
        $latestSkripsi = Skripsi::where('nim', $nim)->orderBy('semester_aktif', 'desc')->first();
        
        if ($latestSkripsi) {
            $latestSemester = $latestSkripsi->semester_aktif;
            $inputSemester = $request->input('semester_aktif');

            if ($inputSemester > $latestSemester + 1) {
                // PKL diisi tidak sesuai urutan, berikan pesan kesalahan
                return redirect()->route('skripsi.create')->with('error', 'Anda harus mengisi Skripsi sesuai urutan semester.');
        }}elseif($request->input('semester_aktif') != 7){
            return redirect()->route('skripsi.create')->with('error', 'Anda harus memulai dengan Skripsi semester 7.');
        }

        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric','unique:skripsi'], // Correct the validation rule syntax
            'statusSkripsi' => [Rule::in(['lulus', 'tidak lulus'])],
            'nilai'=>[Rule::in(['A', 'B','C','D','E'])],
            'lama_studi'=>[Rule::in(['3', '4','5','6','7'])],
            'tanggal_sidang'=>['required'],
            'scanSkripsi' => ['required', 'file', 'mimes:pdf', 'max:10240'], // Correct the validation rule syntax
        ]);

        $PDFPath = null;

        if ($request->hasFile('scanSkripsi') && $request->file('scanSkripsi')->isValid()) {
            $PDFPath = $request->file('scanSkripsi')->store('file', 'public');
        }

        $skripsi = new Skripsi();
        $skripsi->semester_aktif = $request->input('semester_aktif');
        $skripsi->statusSkripsi = $request->input('statusSkripsi');
        $skripsi->nilai = $request->input('nilai');
        $skripsi->lama_studi = $request->input('lama_studi');
        $skripsi->tanggal_sidang = $request->input('tanggal_sidang');
        $skripsi->status = 'pending';
        $skripsi->scanSkripsi = $PDFPath; // Assign the PDF path here
        $skripsi->nim = $request->user()->mahasiswa->nim;
        $skripsi->nip = $request->user()->mahasiswa->nip;
        $saved = $skripsi->save();

        if ($saved) {
            return redirect()->route('skripsi.index')->with('success', 'Skripsi added successfully');
        } else {
            return redirect()->route('skripsi.create')->with('error', 'Failed to add Skripsi');
        }
    }

}
