@extends('layouts.layoutMahasiswa')

@section('content')
    <section id="profil-mhs">
        <div class="container-lg my-5 text-light">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-person-fill-check"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="text-center mt-5">
                <h2>Edit Profil</h2>
            </div>

            <div class="row my-4 g-4 justify-content-center align-items-center">
                <div class="col-md-5 text-center text-md-start">
                    <form action="{{ route('mahasiswa.showEdit', [Auth::user()->id]) }}" method="get">
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
                            <input type="text" class="form-control" id="nim" name="nip"
                                value="{{ $mahasiswas->nim }}" disabled>
                        </div>

                        @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group mb-5">
                            <input type="username" class="form-control" id="username" name="username"
                                value="{{ $user->username }}" disabled>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                </div>

                <div class="col-md-4 text-center d-none d-md-block">
                    <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-50 w-50 mb-2" alt="foto-profil" />
                    <h5>Foto Profil</h5>
                    @error('fotoProfil')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </form>
            </div>
        </div>

    </section>
@endsection
