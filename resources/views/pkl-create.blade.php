@extends('layouts.layoutMahasiswa')

@section('content')
    <div class="container-lg my-5 text-light">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="text-center mt-5">
            <h2>Tambah PKL</h2>
        </div>

        <div class="row justify-content-center my-5">
            <div class="col-lg-6">
                <form action="{{ route('pkl.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @error('semester_aktif')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                    <label for="semester_aktif" class="form-label">Semester Aktif</label>
                    <div class="input-group mb-4">
                        <select class="form-select" id="semester_aktif" name="semester_aktif">
                            <option value="">Pilih semester</option>
                            @foreach ($availableSemesters as $semester)
                                <option value="{{ $semester }}">{{ $semester }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('nilai')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                    <label for="nilai" class="form-label">Nilai:</label>
                    <div class="input-group mb-4">
                        <select id="nilai" name="nilai" class="form-select">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>

                    @error('statusPKL')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                    <label for="statusPKL" class="form-label">Status PKL:</label>
                    <div class="input-group mb-4">
                        <select id="statusPKL" name="statusPKL" class="form-select">
                            <option value="lulus">Lulus</option>
                            <option value="tidak lulus">Tidak Lulus</option>
                        </select>
                    </div>

                    @error('scanPKL')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                    <label for="scanPKL" class="form-labef">Scan PKL (PDF)</label>
                    <div class="input-group mb-4">
                        <input type="file" class="form-control" id="scanPKL" name="scanPKL" accept=".pdf">
                    </div>
                    
                    <div class="text-center my-5">
                        <button type="submit" class="btn btn-primary me-2 px-3">Simpan PKL</button>
                        <a href="{{ route('pkl.index') }}" class="btn btn-secondary px-3">Kembali</a>
                    </div>
                </form>

            </div>
        @endsection
