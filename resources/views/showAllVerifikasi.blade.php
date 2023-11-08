@extends('layouts.layoutDosen')

@section('content')
    <section id="verifikasi">
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

            <div class="text-center mt-5">
                <h2>Verifikasi</h2>
            </div>
            <div class="container-lg my-5 pb-4">
                <div class="justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <p>IRS</p>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Semester Aktif</th>
                                    <th scope="col">Jumlah SKS</th>
                                    <th scope="col">Scan IRS</th>
                                    <th scope="col">Aksi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($irs as $ir)
                                <tr>
                                    <td>{{ $ir->nama }}</td>
                                    <td>{{ $ir->nim }}</td>
                                    <td>{{ $ir->semester_aktif }}</td>
                                    <td>{{ $ir->jumlah_sks }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $ir->scanIRS) }}" target="_blank">Lihat IRS</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('verifikasi', ['nim' => $ir->nim, 'semester_aktif' => $ir->semester_aktif]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-outline btn-info">Verifikasi</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('rejected', ['nim' => $ir->nim, 'semester_aktif' => $ir->semester_aktif]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-outline btn-info">Rejected</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <p>KHS</p>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Semester Aktif</th>
                                    <th scope="col">IP Semester</th>
                                    <th scope="col">IP Kumulatif</th>
                                    <th scope="col">Jumlah SKS</th>
                                    <th scope="col">Jumlah SKS Kumulatif</th>
                                    <th scope="col">Scan KHS</th>
                                    <th scope="col">Aksi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($khs as $kh)
                                <tr>
                                    <td>{{ $kh->nama }}</td>
                                    <td>{{ $kh->nim }}</td>
                                    <td>{{ $kh->semester_aktif }}</td>
                                    <td>{{ $kh->ip_semester }}</td>
                                    <td>{{ $kh->ip_kumulatif }}</td>
                                    <td>{{ $kh->jumlah_sks }}</td>
                                    <td>{{ $kh->jumlah_sks_kumulatif }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $kh->scanKHS) }}" target="_blank">Lihat KHS</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('verifikasiKHS', ['nim' => $kh->nim, 'semester_aktif' => $kh->semester_aktif]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-outline btn-info">Verifikasi</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('rejectedKHS', ['nim' => $kh->nim, 'semester_aktif' => $kh->semester_aktif]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-outline btn-info">Rejected</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <p>PKL</p>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Semester Aktif</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col">Scan PKL</th>
                                    <th scope="col">Aksi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pkl as $pk)
                                <tr>
                                    <td>{{ $pk->nama }}</td>
                                    <td>{{ $pk->nim }}</td>
                                    <td>{{ $pk->semester_aktif }}</td>
                                    <td>{{ $pk->nilai }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $pk->scanPKL) }}" target="_blank">Lihat PKL</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('verifikasiPKL', ['nim' => $pk->nim, 'semester_aktif' => $pk->semester_aktif]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-outline btn-info">Verifikasi</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('rejectedPKL', ['nim' => $pk->nim, 'semester_aktif' => $pk->semester_aktif]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-outline btn-info">Rejected</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <p>Skripsi</p>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Semester Aktif</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col">Scan Skripsi</th>
                                    <th scope="col">Aksi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($skripsi as $skrips)
                                <tr>
                                    <td>{{ $skrips->nama }}</td>
                                    <td>{{ $skrips->nim }}</td>
                                    <td>{{ $skrips->semester_aktif }}</td>
                                    <td>{{ $skrips->nilai }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $skrips->scanSkripsi) }}" target="_blank">Lihat Skripsi</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('verifikasiSkripsi', ['nim' => $skrips->nim, 'semester_aktif' => $skrips->semester_aktif]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-outline btn-info">Verifikasi</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('rejectedSkripsi', ['nim' => $skrips->nim, 'semester_aktif' => $skrips->semester_aktif]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-outline btn-info">Rejected</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
@endsection
