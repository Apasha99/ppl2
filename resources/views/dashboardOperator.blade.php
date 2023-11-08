@extends('layouts.layoutOperator')

@section('content')
    <section>
        <div class="container-lg my-5">
            <div class="text-center text-light">
                <div class="display-6">Welcome, {{Auth::user()->username}}</div>
            </div>

            <div class="row justify-content-center align-items-center gy-3 mt-5">
                <div class="col-lg-2 mx-2 bg-light border border-dark border-2 rounded">
                    <div class="d-flex justify-content-between pt-3 pe-2">
                        <p class="border border-dark border-1 rounded px-3">{{$user_count}}</p>
                        <h6 class="align-items-center"><i class="bi bi-people-fill"></i> User</h6>
                    </div>
                </div>
                <div class="col-lg-3 mx-2 bg-light border border-dark border-2 rounded">
                    <div class="d-flex justify-content-between pt-3 pe-2">
                        <p class="border border-dark border-1 rounded px-3">{{$departemen_count}}</p>
                        <h6 class="align-items-center"><i class="bi bi-building-fill"></i> Departemen</h6>
                    </div>
                </div>
                <div class="col-lg-3 mx-2 bg-light border border-dark border-2 rounded">
                    <div class="d-flex justify-content-between pt-3 pe-2">
                        <p class="border border-dark border-1 rounded px-3">{{$dosen_count}}</p>
                        <h6 class="align-items-center"><i class="bi bi-mortarboard-fill"></i> Dosen Wali</h6>
                    </div>
                </div>
                <div class="col-lg-3 mx-2 bg-light border border-dark border-2 rounded">
                    <div class="d-flex justify-content-between pt-3 pe-2">
                        <p class="border border-dark border-1 rounded px-3">{{$mahasiswa_count}}</p>
                        <h6 class="align-items-center"><i class="bi bi-backpack-fill"></i> Mahasiswa</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light rounded">
        <div class="text-center my-5 pt-5">
            <h1 class="display-6">Daftar Mahasiswa</h1>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <form action="{{ route('export') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">Download Data</button>
            </form>
        </div>
        <div class="container-lg my-5 pb-4">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-person-fill"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="justify-content-center">
                <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Angkatan</th>
                                <th scope="col">Status</th>
                                <th scope="col">NIP Dosen Wali</th>
                                <th scope="col">Nama Dosen Wali</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswas as $mahasiswa)
                            <tr>
                                <td>{{ $mahasiswa->nama }}</td>
                                <td>{{ $mahasiswa->nim }}</td>
                                <td>{{ $mahasiswa->angkatan }}</td>
                                <td>{{ $mahasiswa->status }}</td>
                                <td>{{ $mahasiswa->nip }}</td>
                                <td>{{ $mahasiswa->dosen_nama }}</td>
                                <td>{{ $mahasiswa->username }}</td>
                                <td>{{ $mahasiswa->password }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="/mahasiswa-create" class="btn btn-primary">+ Generate akun</a>
                <a href="/tambahMahasiswa" class="btn btn-info">+ Upload Mahasiswa</a>
            </div>
        </div>
    </section>
@endsection
