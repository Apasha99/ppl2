@extends('layouts.layoutMahasiswa')

@section('content')
    <section id="profil-oper">
        <div class="container-lg my-5 text-light justify-content-center align-items-center">
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

            <div class="text-center">
                <h2>Edit Profil</h2>
            </div>

            <div class="row my-4 g-4 justify-content-center align-items-center">
                <div class="col-md-5 text-center text-md-start">
                    <form action="{{ route('mahasiswa.update', [Auth::user()->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label for="nama" class="form-label">Nama</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ $mahasiswas->nama }}" disabled>
                        </div>

                        <label for="nim" class a="form-label">NIM</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nim" name="nim"
                                value="{{ $mahasiswas->nim }}" disabled>
                        </div>

                        <label for="angkatan" class a="form-label">Angkatan</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="angkatan" name="angkatan"
                                value="{{ $mahasiswas->angkatan }}" disabled>
                        </div>

                        <label for="username" class="form-label">Username</label>
                        @error('username')
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="username" name="username"
                            value="{{ $user->username }}">
                        </div>

                        <label for="alamat" class="form-label">Alamat</label>
                        @error('alamat')
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="text-area" class="form-control" id="alamat" name="alamat" value=""
                            placeholder="Masukkan alamat anda" required>
                        </div>

                        <label for="provinsi" class="form-label">Provinsi</label>
                        @error('provinsi')
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="provinsi" name="provinsi" value=""
                            placeholder="Masukkan provinsi anda" required>
                        </div>

                        <label for="kabkota" class="form-label">Kabupaten/Kota</label>
                        @error('kabkota')
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="kabkota" name="kabkota" value=""
                            placeholder="Masukkan kabupaten/kota anda" required>
                        </div>

                        <label for="noHandphone" class="form-label">Nomor Handphone</label>
                        @error('noHandphone')
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="noHandphone" name="noHandphone" value=""
                            placeholder="Masukkan nomor handphone anda" required>
                        </div>

                        <label for="current_password" class="form-label">Password Lama</label>
                        @error('current_password')
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="current_password" name="current_password"
                            placeholder="Masukkan Password Lama" required>
                        </div>

                        <label for="new_password" class="form-label">Password Baru</label>
                        @error('new_password')
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                        @enderror
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="new_password" name="new_password"
                            placeholder="Masukkan Password Baru" required>
                        </div>

                        <label for="new_confirm_password" class="form-label">Konfirmasi Password Baru</label>
                        @error('new_confirm_password')
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                        @enderror
                        <div class="input-group mb-5">
                            <input type="password" class="form-control" id="new_confirm_password"
                            name="new_confirm_password" placeholder="Masukkan Konfirmasi Password Baru" required>
                        </div>

                        <div class="col-md-4 ms-5 text-center d-none d-md-block">
                            @error('foto')
                            <p class="text-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
                            @enderror
                            <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-50 w-50 mb-2"
                                alt="foto-profil" />
                            <h5>Foto Profil</h5>
                            <input type="file" class="form-control mt-3" id="foto" name="foto"
                                accept=".jpg, .jpeg, .png" required>
                        </div>

                        <div class="text-center my-5">
                            <button type="submit" class="btn btn-success me-2 px-3">Save</button>
                            <a href="profilMahasiswa" class="btn btn-secondary px-3">Cancel</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
