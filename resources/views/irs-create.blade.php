@extends('layouts.layoutMahasiswa')

@section('content')
    <div class="container">
        <h2 style="color:#fff">Tambah IRS</h2>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($irsSudahDiisi)
            <p>IRS untuk semester ini sudah diisi.</p>
        @else
            <form action="{{ route('irs.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="semester_aktif" class="form-label" style="color:#fff">Semester Aktif</label>
                    <select class="form-select" id="semester_aktif" name="semester_aktif">
                        <option value="">Pilih semester</option>
                        @for ($i = 1; $i <= $availableSemesters; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('semester_aktif')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for= "scanIRS" class="form-label" style="color:#fff">Scan IRS (PDF)</label>
                    <input type="file" class="form-control" id="scanIRS" name="scanIRS" accept=".pdf">
                    @error('scanIRS')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah_sks" class="form-label" style="color:#fff">Jumlah SKS Yang Diambil</label>
                    <input type="number" class="form-control" id="jumlah_sks" name="jumlah_sks" min="1" max="24">
                    @error('jumlah_sks')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan IRS</button>
                <a href="{{ route('irs.irs') }}" class="btn btn-secondary">Kembali</a>
            </form>
        @endif
    </div>
@endsection
