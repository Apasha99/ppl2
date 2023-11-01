<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PKL; // Import model PKL

class PKLController2 extends Controller
{
    public function create()
    {
        $pkl = new PKL(); // Buat instansiasi objek PKL kosong
        return view('pklcreate', compact('pkl')); // Kirimkan variabel $pkl ke view
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nim' => 'required',
            'status_pkl' => 'required',
            'scan_pkl' => 'required|file|mimes:pdf|max:2048', // Maksimum 2MB
        ]);

        if ($request->hasFile('scan_pkl')) {
            $file = $request->file('scan_pkl');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/pkl', $fileName);

            $data['scan_pkl'] = 'pkl/' . $fileName;
        }

        PKL::create($data);

        return redirect()->route('pkl.index')->with('success', 'Data PKL berhasil ditambahkan');
    }

    public function showAllPKL()
    {
        $pklData = PKL::all(); // Mengambil semua data dari tabel PKL

        foreach ($pklData as $pkl) {
            echo "ID: " . $pkl->id . "<br>";
            // Menampilkan nilai 'id' dari setiap entri PKL
        }
    }

    public function index()
    {
        $dataPKL = PKL::all(); // Ambil semua data PKL dari tabel

        return view('pklindex', compact('dataPKL')); // Nama view harus sesuai dengan file yang ada di direktori resources/views
    }

    public function edit($nim)
    {
        $pkl = PKL::where('nim', $nim)->first();

        if (!$pkl) {
            return redirect()->route('pklindex')->with('error', 'Data PKL tidak ditemukan');
        }

        return view('pkledit', compact('pkl'));
    }

    public function update(Request $request, $nim)
    {
        $data = $request->validate([
            'nim' => 'required',
            'status_pkl' => 'required',
            'other_field' => 'required', // Tambahkan field ini jika diperlukan
        ]);

        $pkl = PKL::where('nim', $nim)->first();

        if (!$pkl) {
            return redirect()->route('pklindex')->with('error', 'Data PKL tidak ditemukan');
        }

        // Tambah logika untuk mengunggah file jika ada file yang diunggah
        if ($request->hasFile('scan_pkl')) {
            $file = $request->file('scan_pkl');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/pkl', $filename); // Simpan file ke direktori storage
            $data['scan_pkl'] = 'pkl/' . $filename; // Simpan nama file ke dalam database
        }

        $pkl->update($data);

        return redirect()->route('pkl.index')->with('success', 'Data PKL berhasil diperbarui');
    }



    public function destroy($nim)
    {
        // Temukan data PKL berdasarkan ID
        $pkl = PKL::find($nim);

        if ($pkl) {
            // Hapus data PKL
            $pkl->delete();

            return redirect()->route('pklindex')->with('success', 'Data berhasil dihapus');
        }

        // Jika data tidak ditemukan, mungkin Anda ingin menangani kasus ini dengan pesan kesalahan atau tindakan lain sesuai kebutuhan.

        return redirect()->route('pklindex')->with('error', 'Data tidak ditemukan');
    }
    
	public function upload()
    {
        return view('upload'); // Sesuaikan dengan nama view yang Anda gunakan
    }

    public function proses_upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
            'keterangan' => 'required',
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('file');

        // nama file
        echo 'File Name: ' . $file->getClientOriginalName();
        echo '<br>';

        // ekstensi file
        echo 'File Extension: ' . $file->getClientOriginalExtension();
        echo '<br>';

        // real path
        echo 'File Real Path: ' . $file->getRealPath();
        echo '<br>';

        // ukuran file
        echo 'File Size: ' . $file->getSize();
        echo '<br>';

        // tipe mime
        echo 'File Mime Type: ' . $file->getMimeType();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'data_file';
        $file->move($tujuan_upload, $file->getClientOriginalName());
    }

}