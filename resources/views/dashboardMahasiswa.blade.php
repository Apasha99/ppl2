@extends('layouts.layoutMahasiswa')

@section('content')
    <div class="tab-content mt-5" id="v-pills-tabContent">
        {{-- HOME --}}
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="container-lg my-5 text-light">
                <div class="text-center">
                    <div class="display-6">Welcome, {{Auth::user()->username}} </div>
                </div>

                <div class="row mt-5 py-5 justify-content-center align-items-center">
                    <!-- justify-content-around means spreading around the content if there's any empty space & the gaps stayed equal -->
                    <div class="col-6 col-lg-3">
                        <img src="{{ Auth::user()->getImageURL() }}" class="img-fluid rounded" alt="foto-profil">
                    </div>
        
                    <div class="col-lg-6">
                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $mahasiswa->nama}}</td>
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

                {{-- irs khs --}}
                <div class="row justify-content-around text-dark">
                    <div class="col-lg-4 bg-light border border-dark border-2 rounded ps-5 pt-3">
                            <h5 class="align-items-center">IRS</h5>
                            <p>Semester Aktif 
                                <br><span class="text-muted">insert sem aktif disini</span>
                            </p>
                    </div>
                    <div class="col-lg-4 bg-light border border-dark border-2 rounded ps-5 pt-3">
                            <h5 class="align-items-center">KHS</h5>
                            <p>SKS Kumulatif
                                <br><span class="text-muted">insert sks kum disini</span>
                            </p>
                            <p>IP Kumulatif
                                <br><span class="text-muted">insert ip kum disini</span>
                            </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- IRS --}}
        <div class="tab-pane fade" id="v-pills-irs" role="tabpanel" aria-labelledby="v-pills-irs-tab">
            
        </div>

        {{-- KHS --}}
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>

        {{-- PKL --}}
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>

        {{-- SKRIPSI --}}
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
    </div>
@endsection


