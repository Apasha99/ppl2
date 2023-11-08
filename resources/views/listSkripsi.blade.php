@extends('layouts.layoutDosen')

@section('content')
    <section id="listSkripsi">
        <div class="container-lg my-5 text-light">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-person-fill-check"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="text-center mt-3">
                <h3>Daftar Sudah/Belum Lulus Skripsi Mahasiswa Informatika</h3>
                <h3>Fakultas Sains dan Matematika UNDIP Semarang</h3>
            </div>
            <div class="container-lg my-5 pb-4">
                <div class="justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Angkatan</th>
                                    <th scope="col">Semester Aktif</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col">Scan Skripsi</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($skripsi as $skrips)
                                <tr>
                                    <td>{{ $skrips->nama }}</td>
                                    <td>{{ $skrips->nim }}</td>
                                    <td>{{ $skrips->angkatan }}</td>
                                    <td>{{ $skrips->semester_aktif }}</td>
                                    <td>{{ $skrips->nilai }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $skrips->scanSkripsi) }}" target="_blank">Lihat Skripsi</a>
                                    </td>
                                    <td>{{ $skrips->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
@endsection
