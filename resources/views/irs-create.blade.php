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
            <h2>Tambah IRS</h2>
        </div>

        <div class="row justify-content-center my-5">
            <div class="col-lg-6">
                <form action="{{ route('irs.store') }}" method="post" enctype="multipart/form-data">
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

                    @error('jumlah_sks')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                    <label for="jumlah_sks" class="form-label">Jumlah SKS Yang Diambil</label>
                    <div class="input-group mb-4">
                        <input type="number" class="form-control" id="jumlah_sks" name="jumlah_sks" min="1"
                            max="24">
                    </div>

                    @error('scanIRS')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                    <label for="scanIRS" class="form-label">Scan IRS (PDF)</label>
                    <div class="input-group mb-4">
                        <input type="file" class="form-control" id="scanIRS" name="scanIRS" accept=".pdf">
                    </div>

                    <div class="text-center my-5">
                        <button type="submit" class="btn btn-primary me-2 px-3">Simpan IRS</button>
                        <a href="{{ route('irs.index') }}" class="btn btn-secondary px-3">Kembali</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
