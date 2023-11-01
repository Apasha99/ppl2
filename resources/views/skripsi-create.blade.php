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
            @error('lama_studi')
                <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                </div>
            @enderror
            <label for="lama_studi" class="form-label">Lama Studi</label>
            <div class="input-group mb-4">
                <input type="number" class="form-control" id="lama_studi" name="lama_studi" min="3"
                    max="7">
            </div>
            <label for="tanggal_sidang">Tanggal Sidang:</label>
            <input type="date" class="input input-bordered w-full" id="tanggal_sidang" name="tanggal_sidang" value="{{ old('tanggal_sidang', date('Y-m-d')) }}">
            @error('tanggal_sidang')
            <div class="alert alert-error">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="scanSkripsi" class="form-label" style="color:#fff">Scan Skripsi (PDF)</label>
                <input type="file" class="form-control" id="scanSkripsi" name="scanSkripsi" accept=".pdf">
                @error('scanSkripsi')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>

            @error('nilai')
                <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                </div>
            @enderror
            <label for="nilai" class="form-label" style="color:#fff">Nilai:</label>
            <select id="nilai" name="nilai"  class="form-control">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>

            <div class="mb-3">
                <label for="statusSkripsi" class="form-label" style="color:#fff">Status Skripsi:</label>
                <select id="statusSkripsi" name="statusSkripsi"  class="form-control">
                    <option value="lulus">Lulus</option>
                    <option value="tidak lulus">Tidak Lulus</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Skripsi</button>
            <a href="{{ route('skripsi.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

</div>
@endsection
