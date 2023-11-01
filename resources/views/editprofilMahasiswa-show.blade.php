@extends('layouts.layoutMahasiswa')

@section('content')
    <section id="profil-mhs2">
        <div class="container-lg my-5 text-light">
            <div class="text-center">
                <h2>Edit Profil</h2>
            </div>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="row my-4 g-4 justify-content-center align-items-center">
                <div class="col-md-5 text-center text-md-start">
                    <form action="{{ route('mahasiswa.updateProfil',[Auth::user()->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="nama" class="form-label">Nama</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $mahasiswas->nama }}" disabled>
                        </div>

                        <label for="nim" class a="form-label">NIM</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ $mahasiswas->nim }}" disabled>
                        </div>

                        @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                        </div>

                        @error('alamat')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="alamat" class="form-label">Alamat</label>
                        <div class="input-group mb-3">
                            <input type="text-area" class="form-control" id="alamat" name="alamat" value="{{ $mahasiswas->alamat }}" placeholder="Masukkan alamat anda">
                        </div>

                        @error('provinsi')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ $mahasiswas->provinsi }}" placeholder="Masukkan provinsi anda">
                        </div>
                        
                        @error('kabkota')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="kabkota" class="form-label">Kabupaten/Kota</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="kabkota" name="kabkota" value="{{ $mahasiswas->kabkota }}" placeholder="Masukkan kabupaten/kota anda">
                        </div>

                        @error('noHandphone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="noHandphone" class="form-label">Nomor Handphone</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="noHandphone" name="noHandphone" value="{{ $mahasiswas->noHandphone }}" placeholder="Masukkan nomor handphone anda">
                        </div>

                        @error('current_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="current_password" class="form-label">Password Lama</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan Password Lama" >
                        </div>

                        @error('new_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan Password Baru" >
                        </div>
                        
                        @error('new_confirm_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="new_confirm_password" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group mb-5">
                            <input type="password" class="form-control" id="new_confirm_password" name="new_confirm_password" placeholder="Masukkan Konfirmasi Password Baru">
                        </div>
                        
                        @error('foto')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="col-md-4 ms-5 text-center d-none d-md-block">
                            <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-50 w-50 mb-2" alt="foto-profil" />
                            <h5>Foto Profil</h5>
                            <input type="file" class="form-control mt-3" id="foto" name="foto" accept=".jpg, .jpeg, .png" >
                        </div>

                        <button type="submit" class="btn btn-success me-2">Save</button>
                        <a href="editprofilMahasiswa" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
