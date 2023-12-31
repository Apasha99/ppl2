@extends('layouts.layoutMahasiswa')

@section('content')
    <section id="profil-mhs2">
        <div class="container-lg my-5 text-light">
            <div class="text-center">
                <h2>Edit Profil</h2>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row my-4 g-4 justify-content-center align-items-center">
                <div class="col-md-5 text-center text-md-start">
                    <form action="{{ route('mahasiswa.showProfil', [Auth::user()->id]) }}" method="get">
                        @csrf
                        <label for="nama" class="form-label">Nama</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ $mahasiswas->nama }}" disabled>
                        </div>

                        <label for="nim" class="form-label">NIM</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nim" name="nim"
                                value="{{ $mahasiswas->nim }}" disabled>
                        </div>

                        <label for="username" class="form-label">Username</label>
                        <div class="input-group mb-3">
                            <input type="username" class="form-control" id="username" name="username"
                                value="{{ $user->username }}" disabled>
                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="alamat" class="form-label">Alamat</label>
                        <div class="input-group mb-3">
                            <input type="alamat" class="form-control" id="alamat" name="alamat"
                                value="{{ $mahasiswas->alamat }}" disabled>
                            @error('alamat')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="provinsi" class="form-label">Provinsi</label>
                        <div class="input-group mb-3">
                            <input type="provinsi" class="form-control" id="provinsi" name="provinsi"
                                value="{{ $mahasiswas->provinsi }}" disabled>
                            @error('provinsi')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="kabkota" class="form-label">Kab/Kota</label>
                        <div class="input-group mb-3">
                            <input type="kabkota" class="form-control" id="kabkota" name="kabkota"
                                value="{{ $mahasiswas->kabkota }}" disabled>
                            @error('kabkota')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="noHandphone" class="form-label">Nomor Handphone</label>
                        <div class="input-group mb-5">
                            <input type="noHandphone" class="form-control" id="noHandphone" name="noHandphone"
                                value="{{ $mahasiswas->noHandphone }}" disabled>
                            @error('noHandphone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>

                <div class="col-md-4 text-center d-none d-md-block">
                    <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-50 w-50 mb-2" alt="foto-profil" />
                    <h5>Foto Profil</h5>
                    @error('fotoProfil')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

    </section>
@endsection
