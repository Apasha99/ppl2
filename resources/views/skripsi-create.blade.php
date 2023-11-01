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
    
        <form action="{{route('skripsi.store')}}" method="post" enctype="multipart/form-data">
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

                @error('scanSkripsi')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            <label for="scanSkripsi" class="form-label">Scan Skripsi (PDF)</label>
            <div class="input-group mb-4">
                <input type="file" class="form-control" id="scanSkripsi" name="scanSkripsi" accept=".pdf">
            </div>

            <label for="statusSkripsi" class="form-label">Status Skripsi:</label>
            <div class="input-group mb-4">
                <select id="statusSkripsi" name="statusSkripsi" class="form-select">
                    <option value="belum">Belum Skripsi</option>
                    <option value="sedang">Sedang Skripsi</option>
                    <option value="sudah">Sudah Skripsi</option>
                </select>
            </div>
            
            <div class="text-center my-5">
                <button type="submit" class="btn btn-primary me-2 px-3">Simpan Skripsi</button>
                <a href="{{ route('skripsi.index') }}" class="btn btn-secondary px-3">Kembali</a>
            </div>
        </form>

</div>
@endsection
