@extends('layouts.layoutOperator')

@section('content')
    <section>
        <div class="container-lg my-5">
            <div class="text-center text-light">
                <h2>Import Data Mahasiswa</h2>
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
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Pilih File Untuk Import:</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Import Mahasiswa</button>
                    </form>
                </div>
            </div>
            <div class="justify-content-center">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Angkatan</th>
                            <th scope="col">Status</th>
                            <th scope="col">NIP Dosen Wali</th>
                            <th scope="col">Nama Dosen Wali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswas as $mahasiswa)
                        <tr>
                            <td>{{ $mahasiswa->nama }}</td>
                            <td>{{ $mahasiswa->nim }}</td>
                            <td>{{ $mahasiswa->angkatan }}</td>
                            <td>{{ $mahasiswa->status }}</td>
                            <td>{{ $mahasiswa->nip}}</td>
                            <td>{{ $mahasiswa->dosen_nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <form action="{{ route('generateAkun') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Generate Akun</button>
                </form>
            </div>
        </div>
    </section>
@endsection
