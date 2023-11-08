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
            <h2>Tambah KHS</h2>
        </div>

        <div class="row justify-content-center my-5">
            <div class="col-lg-6">
                <form action="{{ route('khs.store') }}" method="post" enctype="multipart/form-data">
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
                        <input type="number" class="form-control" id="jumlah_sks" name="jumlah_sks" min="18"
                            max="24">
                    </div>

                    @error('jumlah_sks_kumulatif')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                    <label for="jumlah_sks_kumulatif" class="form-label">Jumlah SKS Kumulatif</label>
                    <div class="input-group mb-4">
                        <input type="number" class="form-control" id="jumlah_sks_kumulatif" name="jumlah_sks_kumulatif"
                            min="18" max="144">
                    </div>

                    @error('ip_semester')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                    <label for="ip_semester" class="form-label">IP Semester</label>
                    <div class="input-group mb-4">
                        <input type="decimal" class="form-control" id="ip_semester" name="ip_semester">
                    </div>

                    @error('ip_kumulatif')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                    <label for="ip_kumulatif" class="form-label">IP Kumulatif</label>
                    <div class="input-group mb-4">
                        <input type="decimal" class="form-control" id="ip_kumulatif" name="ip_kumulatif">
                    </div>

                    @error('scanKHS')
                        <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                    <label for="scanKHS" class="form-label">Scan KHS (PDF)</label>
                    <div class="input-group mb-4">
                        <input type="file" class="form-control" id="scanKHS" name="scanKHS" accept=".pdf">
                    </div>

                    <div class="text-center my-5">
                        <button type="submit" class="btn btn-primary me-2 px-3">Simpan KHS</button>
                        <a href="{{ route('khs.index') }}" class="btn btn-secondary px-3">Kembali</a>
                    </div>

                </form>

            </div>
        @endsection
