@extends('layouts.layoutDepartemen')

@section('content')
    <section>
            <div class="container-lg my-5 text-light">
                <div class="text-center text-light">
                    <div class="display-6">Welcome, {{ Auth::user()->username }}</div>
                </div>
        
                <div class="d-flex ">
                    <div class="row mt-5 py-5 d-flex ">
                        <div class="col-6 col-lg-3">
                            <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-100 w-100" alt="foto-profil" />
                        </div>
        
                        <div class="col-lg-6 ms-4">
                            <table>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $departemen->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Kode</td>
                                    <td>:</td>
                                    <td>{{ $departemen->kode }}</td>
                                </tr>
                                <tr>
                                    <td>Username</td>
                                    <td>:</td>
                                    <td>{{ $departemen->username }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <div class="text-center">
                <h2>Rekap Progress PKL Mahasiswa Informatika</h2>
                <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
            </div>

            <div class="my-5">
                <h4>Angkatan</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tahun</th>
                            <th scope="col">Belum</th>
                            <th scope="col">Sudah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mahasiswas as $mahasiswa)
                        <tr class="table-active">
                            <td>{{ $mahasiswa->angkatan }}</td>
                            <td><a href="{{ route('list.index', ['angkatan' => $mahasiswa->angkatan, 'status' => 'tidak lulus']) }}" class=text-decoration-none>{{ $mahasiswa->tidak_lulus_count }}</a></td>
                            <td><a href="{{ route('list.index', ['angkatan' => $mahasiswa->angkatan, 'status' => 'lulus']) }}" class=text-decoration-none>{{ $mahasiswa->lulus_count }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
    </section>
@endsection
