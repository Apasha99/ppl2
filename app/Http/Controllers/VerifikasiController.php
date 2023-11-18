<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;

class VerifikasiController extends Controller
{
    public function showAll(Request $request)
    {        
        $nip = $request->user()->dosen->nip;
        $irs = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('irs','irs.nim','=','mahasiswa.nim')
                ->where('irs.status','pending')
                ->select('mahasiswa.nama','mahasiswa.nim','irs.semester_aktif','irs.jumlah_sks','irs.scanIRS')
                ->get();
        $khs = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('khs','khs.nim','=','mahasiswa.nim')
                ->where('khs.status','pending')
                ->select('mahasiswa.nama','mahasiswa.nim','khs.semester_aktif','khs.jumlah_sks','khs.scanKHS','khs.jumlah_sks_kumulatif','khs.ip_semester','khs.ip_kumulatif')
                ->get();
        $pkl = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('pkl','pkl.nim','=','mahasiswa.nim')
                ->where('pkl.status','pending')
                ->select('mahasiswa.nama','mahasiswa.nim','pkl.semester_aktif','pkl.scanPKL','pkl.nilai','pkl.statusPKL')
                ->get();
        $skripsi = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('skripsi','skripsi.nim','=','mahasiswa.nim')
                ->where('skripsi.status','pending')
                ->select('mahasiswa.nama','mahasiswa.nim','skripsi.semester_aktif','skripsi.scanSkripsi','skripsi.nilai','skripsi.statusSkripsi')
                ->get();
        return view('showAllVerifikasi', ['irs'=>$irs,'khs'=>$khs,'pkl'=>$pkl,'skripsi'=>$skripsi]);
    }

    public function verifikasi(Request $request,$nim, $semester_aktif)
    {
        $irs = IRS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();
        
        if ($irs) {
            IRS::where('nim', $irs->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'verified']);
            return redirect()->route('showAll')->with('success', 'IRS berhasil diverifikasi.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat memverifikasi.');
        }
    }

    public function rejected($nim,$semester_aktif){
        $irs = IRS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();
    
        if ($irs) {
            IRS::where('nim', $irs->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'rejected']);
            return redirect()->route('showAll')->with('success', 'IRS berhasil ditolak.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menolak.');
        }
    }

    public function verifikasiKHS($nim, $semester_aktif)
    {
        $khs = KHS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($khs){
            KHS::where('nim', $khs->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'verified']);
            return redirect()->route('showAll')->with('success', 'KHS berhasil diverifikasi.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat memverifikasi.');
        }
    }

    public function rejectedKHS($nim,$semester_aktif){
        $khs = KHS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($khs){
            KHS::where('nim', $khs->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'rejected']);
            return redirect()->route('showAll')->with('success', 'KHS berhasil ditolak.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menolak.');
        }
    }

    public function verifikasiPKL($nim, $semester_aktif)
    {
        $pkl = PKL::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($pkl){
            PKL::where('nim', $pkl->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'verified']);
            return redirect()->route('showAll')->with('success', 'PKL berhasil diverifikasi.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat memverifikasi.');
        }
    }

    public function rejectedPKL($nim,$semester_aktif){
        $pkl = PKL::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($pkl){
            PKL::where('nim', $pkl->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'rejected']);
            return redirect()->route('showAll')->with('success', 'PKL berhasil ditolak.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menolak.');
        }
    }
    
    public function verifikasiSkripsi($nim, $semester_aktif)
    {
        $skripsi = Skripsi::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($skripsi){
            Skripsi::where('nim', $skripsi->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'verified']);
            return redirect()->route('showAll')->with('success', 'Skripsi berhasil diverifikasi.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat memverifikasi.');
        }
    }

    public function rejectedSkripsi($nim,$semester_aktif){
        $skripsi = Skripsi::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($skripsi){
            Skripsi::where('nim', $skripsi->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'rejected']);
            return redirect()->route('showAll')->with('success', 'Skripsi berhasil ditolak.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menolak.');
        }
    }
    
}
