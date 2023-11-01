@extends('layouts.layoutMahasiswa')

@section('content')
<div class="container">
    <h2 style="color:#fff">Tambah PKL</h2>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
        <form action="{{route('pkl.store')}}" method="post" enctype="multipart/form-data">
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
                <label for="scanPKL" class="form-label" style="color:#fff">Scan PKL (PDF)</label>
                <input type="file" class="form-control" id="scanPKL" name="scanPKL" accept=".pdf">
                @error('scanPKL')
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
                <label for="statusPKL" class="form-label" style="color:#fff">Status PKL:</label>
                <select id="statusPKL" name="statusPKL"  class="form-control">
                    <option value="lulus">Lulus</option>
                    <option value="tidak lulus">Tidak Lulus</option>
                </select>
                @error('statusPKL')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan PKL</button>
            <a href="{{ route('pkl.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

</div>
@endsection
