@extends('layouts.layoutMahasiswa')

@section('content')
    {{-- HOME --}}
    <div class="container-lg my-5 text-light">
        <div class="text-center">
            <div class="display-6">Welcome, {{ Auth::user()->username }} </div>
        </div>

        <div class="d-flex justify-content-center align-items-center">
            <div class="row mt-5 py-5 d-flex justify-content-center align-items-center">
                <div class="col-6 col-lg-3">
                    <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-100 w-100" alt="foto-profil" />
                </div>

                <div class="col-lg-6 ms-4">
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <td>NIM</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <td>Angkatan</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->angkatan }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->status }}</td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td>:</td>
                            <td>Teknik Informatika</td>
                        </tr>
                        <tr>
                            <td>Fakultas</td>
                            <td>:</td>
                            <td>Sains dan Matematika</td>
                        </tr>
                        <tr>
                            <td>Dosen Wali</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->dosen_nama }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- irs khs --}}
        <div class="container-lg d-flex justify-content-around">
            <div class="row row-cols-1 row-cols-md-2 g-5 mt-3">
                <div class="col">
                    <div class="card bg-dark text-light border-light border-5 h-100 w-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <!-- Replace the <img> with a large icon -->
                                <i class="bi bi-journals bi-light bi-fluid ps-4" style="font-size: 7rem;"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ms-5">
                                    <h5 class="card-title">PKL</h5>
                                    <p class="card-text">Status PKL
                                        <br><span class="small">{{ $statusPKL }}</span>
                                    </p>
                                    <p class="card-text">Verifikasi
                                        <br><span class="small">{{ $status }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-dark text-light border-light border-5 h-100 w-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <!-- Replace the <img> with a large icon -->
                                <i class="bi bi-journals bi-light bi-fluid ps-4" style="font-size: 7rem;"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ms-5">
                                    <h5 class="card-title">Skripsi</h5>
                                    <p class="card-text">Status Skripsi
                                        <br><span class="small">{{ $statusSkripsi }}</span>
                                    </p>
                                    <p class="card-text">Verifikasi
                                        <br><span class="small">{{ $statusSkr }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-dark text-light border-light border-5 h-100 w-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <!-- Replace the <img> with a large icon -->
                                <i class="bi bi-journal-medical bi-light bi-fluid ps-4" style="font-size: 7rem;"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ms-5">
                                    <h5 class="card-title">KHS</h5>
                                    <p class="card-text">SKS Kumulatif
                                        <br><span class="small">{{ $SKSKumulatif }}</span>
                                    </p>
                                    <p class="card-text">IP Kumulatif
                                        <br><span class="small">{{ $IPKumulatif }}</span>
                                    </p>
                                    <p class="card-text">Status KHS
                                        <br><span class="small">{{ $statusKHS }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-dark text-light border-light border-5 h-100 w-100">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <!-- Replace the <img> with a large icon -->
                                    <i class="bi bi-journal-medical bi-light bi-fluid ps-4" style="font-size: 7rem;"></i>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body ms-5">
                                        <h5 class="card-title">IRS</h5>
                                        <p class="card-text">Semester Aktif
                                            <br><span class="small">{{ $SemesterAktif }}</span>
                                        </p>
                                        <p class="card-text">SKS Yang Diambil
                                            <br><span class="small">{{ $JumlahSKS }}</span>
                                        </p>
                                        <p class="card-text">Status IRS
                                            <br><span class="small">{{ $statusIRS }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
