@extends('layouts.layoutMahasiswa')

@section('content')
<div class="container">
    <h2 style="color:#fff">Tambah KHS</h2>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
        <form action="{{route('khs.store')}}" method="post" enctype="multipart/form-data">
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
                <label for="scanKHS" class="form-label" style="color:#fff">Scan KHS (PDF)</label>
                <input type="file" class="form-control" id="scanKHS" name="scanKHS" accept=".pdf">
                @error('scanKHS')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah_sks" class="form-label" style="color:#fff">Jumlah SKS Yang Diambil</label>
                <input type="number" class="form-control" id="jumlah_sks" name="jumlah_sks" min="18" max="24">
                @error('jumlah_sks')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jumlah_sks_kumulatif" class="form-label" style="color:#fff">Jumlah SKS Kumulatif</label>
                <input type="number" class="form-control" id="jumlah_sks_kumulatif" name="jumlah_sks_kumulatif" min="18" max="144">
                @error('jumlah_sks_kumulatif')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ip_semester" class="form-label" style="color:#fff">IP Semester</label>
                <input type="decimal" class="form-control" id="ip_semester" name="ip_semester">
                @error('ip_semester')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ip_kumulatif" class="form-label" style="color:#fff">IP Kumulatif</label>
                <input type="decimal" class="form-control" id="ip_kumulatif" name="ip_kumulatif">
                @error('ip_kumulatif')
                    <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan KHS</button>
            <a href="{{ route('khs.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

</div>
@endsection
