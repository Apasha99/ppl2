@extends('layouts.layout')

@section('content')

    <section id="profil-oper">
        <div class="container-lg my-5 text-light">
            @method('POST')
            <div class="text-center">
                <h2>Edit Profil</h2>
            </div>
            @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="row my-4 g-4 justify-content-around align-items-center">
                <!-- align-items-center means positioning all elements to the center inside the box / container, in this case the columns -->
                <div class="col-md-5 text-center text-md-start">
                @if($operators)
                    <form action="{{ route('operator.update', ['nip' => $operators->nip, 'username' => $operators->username]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label for="nama" class="form-label">Nama</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $operators->nama }}" disabled>
                        </div>

                        <label for="nip" class="form-label">NIP</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nip" name="nip" value="{{ $operators->nip }}" disabled>
                        </div>

                        <label for="username" class="form-label">Username</label>
                        <div class="input-group mb-3">
                            <!-- <span class="input-group-text">
                                <i class="bi bi-envelope-fill"></i>
                            </span> -->
                            <input type="username" class="form-control" id="username" name="username"
                                value="{{ $operators->username }}" disabled>
                            @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- <label for="current_password" class="form-label">Password Lama</label>
                        <div class="input-group mb-5">
                            <input type="password" class="form-control" id="current_password"
                                name="current_password" value="{{ $operators->current_password }}" disabled>
                            @error('current_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group mb-5">
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Masukkan Password Baru">
                            @error('new_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <label for="new_confirm_password" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group mb-5">
                            <input type="new_confirm_password" class="form-control" id="new_confirm_password"
                                name="password" placeholder="Masukkan Konfirmasi Password Baru">
                            @error('new_confirm_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div> -->

                        <a href="profilOperator" class="btn btn-warning">Edit</a>
                        <a href="profilOperator" type="submit" class="btn btn-success">Save</a>
                    </form>

                </div>
                <div class="col-md-5 text-center d-none d-md-block">
                    <div class="avatar flex items-center justify-center mt-[100px]">
                        <div class="w-48 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="{{ Auth::user()->getImageURL() }}" />
                        </div>
                    </div>
                    <input type="fotoProfil" class="form-control mt-3" id="fotoProfil" accept=".jpg, .jpeg, .png">
                    @error('fotoProfil')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            </div>
        </div>

    </section>
@endsection