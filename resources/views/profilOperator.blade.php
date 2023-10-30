@extends('layouts.layout')

@section('content')

    <section id="profil-oper">
        <div class="container-lg my-5 text-light">
            <div class="text-center">
                <h2>Edit Profil</h2>
            </div>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="row my-4 g-4 justify-content-around align-items-center">
                <!-- align-items-center means positioning all elements to the center inside the box / container, in this case the columns -->
                <div class="col-md-5 text-center text-md-start">
                <form action="{{ route('operator.showEdit',[Auth::user()->id]) }}" method="get">
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
                            value="{{ $user->username }}" disabled>
                        @error('username')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>

            </div>
            <div class="col-md-5 text-center d-none d-md-block">
                <label for="foto" class="form-label text-center">Foto Profil</label>
                <div class="avatar flex items-center justify-center mt-[100px]">
                    <div class="w-48 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="{{ Auth::user()->getImageURL() }}" />
                    </div>
                </div>
                @error('fotoProfil')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            </div>
        </div>

    </section>
@endsection