@extends('layouts.layoutMahasiswa')

@section('content')
<div class="container">
    <h2 style="color:#fff">Tambah Skripsi</h2>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
        <form action="{{route('skripsi.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="semester_aktif" class="form-label" style="color:#fff">Semester Aktif</label>
                <select class="form-select" id="semester_aktif" name="semester_aktif">
                    <option value="">Pilih semester</option>
                    @foreach ($availableSemesters as $semester)
                        <option value="{{ $semester }}">{{ $semester }}</option>
                    @endforeach
                </select>
                @error('semester_aktif')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="scanSkripsi" class="form-label" style="color:#fff">Scan Skripsi (PDF)</label>
                <input type="file" class="form-control" id="scanSkripsi" name="scanSkripsi" accept=".pdf">
                @error('scanSkripsi')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="statusSkripsi" class="form-label" style="color:#fff">Status Skripsi:</label>
                <select id="statusSkripsi" name="statusSkripsi"  class="form-control">
                    <option value="belum">Belum Skripsi</option>
                    <option value="sedang">Sedang Skripsi</option>
                    <option value="sudah">Sudah Skripsi</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Skripsi</button>
            <a href="{{ route('skripsi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

</div>
@endsection
