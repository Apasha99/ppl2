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
            <h2>Tambah Skripsi</h2>
        </div>

        <div class="row justify-content-center my-5">
            <div class="col-lg-6">
                <form action="{{ route('skripsi.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    @error('semester_aktif')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                    <label for="semester_aktif" class="form-label" style="color:#fff">Semester Aktif</label>
                    <div class="input-group mb-4">
                        <select class="form-select" id="semester_aktif" name="semester_aktif">
                            <option value="">Pilih semester</option>
                            @foreach ($availableSemesters as $semester)
                                <option value="{{ $semester }}">{{ $semester }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('lama_studi')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                    <label for="lama_studi" class="form-label">Lama Studi</label>
                    <div class="input-group mb-4">
                        <input type="number" class="form-control" id="lama_studi" name="lama_studi" min="3"
                            max="7">
                    </div>

                    @error('tanggal_sidang')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                    <label for="tanggal_sidang" class="form-label">Tanggal Sidang:</label>
                    <div class="input-group mb-4">
                        <input type="date" class="form-control" id="tanggal_sidang" name="tanggal_sidang"
                        value="{{ old('tanggal_sidang', date('Y-m-d')) }}">
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

                    <label for="statusSkripsi" class="form-label">Status Skripsi:</label>
                    <div class="input-group mb-4">
                        <select id="statusSkripsi" name="statusSkripsi" class="form-select">
                            <option value="lulus">Lulus</option>
                            <option value="tidak lulus">Tidak Lulus</option>
                        </select>
                    </div>

                    @error('scanSkripsi')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                    <label for="scanSkripsi" class="form-label">Scan Skripsi (PDF)</label>
                    <div class="input-group mb-4">
                        <input type="file" class="form-control" id="scanSkripsi" name="scanSkripsi" accept=".pdf">
                    </div>

                    <div class="text-center my-5">
                        <button type="submit" class="btn btn-primary me-2 px-3">Simpan Skripsi</button>
                        <a href="{{ route('skripsi.index') }}" class="btn btn-secondary px-3">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    @endsection
