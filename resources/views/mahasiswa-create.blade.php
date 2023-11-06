@extends('layouts.layoutOperator')

@section('content')
    <section>
        <div class="container-lg my-5">
            <div class="text-center text-light">
                <h2>Tambah Mahasiswa Baru</h2>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row justify-content-center my-5 text-light">
                <div class="col-lg-6">
                    <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                placeholder="Masukkan Nama Mahasiswa" required>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nim">NIM:</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim"
                                placeholder="Masukkan NIM Mahasiswa" required>
                            @error('nim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="angkatan">Angkatan:</label>
                            <select class="form-select @error('angkatan') is-invalid @enderror" name="angkatan" id="angkatan" required>
                                <option selected value="">-- Pilih Angkatan --</option>
                                @for ($i = 18; $i <= 23; $i++)
                                    <option value="20{{ $i }}">20{{ $i }}</option>
                                @endfor
                            </select>
                            @error('angkatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status:</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="active" name="status" value="active"
                                    checked>
                                <label class="form-check-label" for="active">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="inactive" name="status"
                                    value="inactive">
                                <label class="form-check-label" for="inactive">Tidak aktif</label>
                            </div>
                            @error('status')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nip">Nama Dosen wali:</label>
                            <select class="form-select @error('nip') is-invalid @enderror" name="nip" id="nip" required>
                                <option value="">Pilih Dosen Wali</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->nip }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                            @error('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-center my-5">
                            <button type="submit" class="btn btn-primary px-3">Tambah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
