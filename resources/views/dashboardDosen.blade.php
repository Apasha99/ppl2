@extends('layouts.layoutDosen')

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
                                <td>{{ $dosens->nama }}</td>
                            </tr>
                            <tr>
                                <td>NIP</td>
                                <td>:</td>
                                <td>{{ $dosens->nip }}</td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td>{{ $dosens->username }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center gy-3 mt-5">
                <div class="col-lg-3 mx-2 bg-light border border-dark border-2 rounded">
                    <div class="d-flex justify-content-between pt-3 pe-2">
                        <p class="border border-dark border-1 rounded px-3 text-dark">{{ $mahasiswaPerwalianCount }}</p>
                        <h6 class="align-items-center text-dark"><i class="bi bi-mortarboard-fill"></i> Mahasiswa Perwalian
                        </h6>
                    </div>
                </div>
                <div class="col-lg-3 mx-2 bg-light border border-dark border-2 rounded">
                    <div class="d-flex justify-content-between pt-3 pe-2">
                        <p class="border border-dark border-1 rounded px-3 text-dark">{{ $mahasiswaCount }}</p>
                        <h6 class="align-items-center text-dark"><i class="bi bi-backpack-fill"></i> Mahasiswa</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light rounded">
        <div class="text-center my-5 pt-5">
            <h1 class="display-6 text-dark">Daftar Mahasiswa</h1>
        </div>
        <div class="col-lg-10 mx-10">
            <form action="{{ route('searchMhs') }}" method="GET">
                <label for="search" style="color:#000">Cari Mahasiswa:</label>
                <input type="text" class="input input-bordered w-full" id="search" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama/nim/angkatan/status">
                <button type="submit" class="btn btn-primary w-full">Cari</button>
            </form>
        </div>
        
        <div class="container-lg my-5 pb-4">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-person-fill"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="justify-content-center">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Angkatan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTable">
                        @foreach ($mahasiswaPerwalian as $mahasiswa)
                            <tr>
                                <td>{{ $mahasiswa->nama }}</td>
                                <td>{{ $mahasiswa->nim }}</td>
                                <td>{{ $mahasiswa->angkatan }}</td>
                                <td>{{ $mahasiswa->status }}</td>
                                <td>
                                    <a href=" {{route('detail',$mahasiswa->nim) }} " class="btn btn-warning btn-sm">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
