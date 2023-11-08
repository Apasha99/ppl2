@extends('layouts.layoutDosen')

@section('content')
    <section id="listPKL">
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
                <h3>Daftar Sudah/Belum Lulus PKL Mahasiswa Informatika</h3>
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
                                    <th scope="col">Scan PKL</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pkl as $pk)
                                <tr>
                                    <td>{{ $pk->nama }}</td>
                                    <td>{{ $pk->nim }}</td>
                                    <td>{{ $pk->angkatan }}</td>
                                    <td>{{ $pk->semester_aktif }}</td>
                                    <td>{{ $pk->nilai }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $pk->scanPKL) }}" target="_blank">Lihat PKL</a>
                                    </td>
                                    <td>{{ $pk->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
@endsection
