@extends('layouts.layoutDosen')

@section('content')
    <section>
        <div class="container-lg text-light">
            <div class="text-center mt-3">
                <h3>Progress Perkembangan Studi Mahasiswa</h3>
                <h3>Fakultas Sains dan Matematika UNDIP Semarang</h3>
            </div>

            <hr>

            <div class="row my-2 g-5 justify-content-around align-items-center">
                <div class="col-lg-6">
                    <dl class="row">
                        <dt class="col-sm-3">Nama</dt>
                        <dd class="col-sm-9">: {{ $mahasiswa->nama }}</dd>

                        <dt class="col-sm-3">NIM</dt>
                        <dd class="col-sm-9">: {{ $mahasiswa->nim }}</dd>

                        <dt class="col-sm-3">Angkatan</dt>
                        <dd class="col-sm-9">: {{ $mahasiswa->angkatan }}</dd>

                        <dt class="col-sm-3">Wali</dt>
                        <dd class="col-sm-9">: {{ $dosen->nama }}</dd>

                </div>

                <div class="col-6 col-lg-4">
                    <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-50 w-50" alt="foto-profil" />
                </div>

                
            </div>
@endsection
