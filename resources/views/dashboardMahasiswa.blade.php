@extends('layouts.layoutMahasiswa')

@section('content')
    <div class="tab-content mt-5" id="v-pills-tabContent">
        {{-- HOME --}}
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="container-lg my-5 text-light">
                <div class="text-center">
                    <div class="display-6">Welcome, {{ Auth::user()->username }} </div>
                </div>

                <div class="d-flex justify-content-center align-items-center">
                <div class="row mt-5 py-5 d-flex justify-content-center align-items-center">
                    <!-- justify-content-around means spreading around the content if there's any empty space & the gaps stayed equal -->
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
                                    <div class="card-body ms-4">
                                        <h5 class="card-title">IRS</h5>
                                        <p class="card-text">Semester Aktif
                                            <br><span class="small">insert sem aktif disini</span>
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
                                    <div class="card-body ms-4">
                                        <h5 class="card-title">KHS</h5>
                                        <p class="card-text">SKS Kumulatif
                                            <br><span class="small">insert sem aktif disini</span>
                                        </p>
                                        <p class="card-text">IP Kumulatif
                                            <br><span class="small">insert ip kum disini</span>
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
    </div>

    {{-- IRS --}}
    <div class="tab-pane fade" id="v-pills-irs" role="tabpanel" aria-labelledby="v-pills-irs-tab">
        
    </div>

    {{-- KHS --}}
    <div class="tab-pane fade" id="v-pills-khs" role="tabpanel" aria-labelledby="v-pills-khs-tab">
        
    </div>

    {{-- PKL --}}
    <div class="tab-pane fade" id="v-pills-pkl" role="tabpanel" aria-labelledby="v-pills-pkl-tab">...</div>

    {{-- SKRIPSI --}}
    <div class="tab-pane fade" id="v-pills-skripsi" role="tabpanel" aria-labelledby="v-pills-skripsi-tab">...</div>
    </div>
@endsection
