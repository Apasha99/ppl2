@extends('layouts.layoutDepartemen')

@section('content')
<section>
    <div class="container-lg text-light">
        <div class="text-center my-5">
            <h2>Daftar Sudah/Belum Lulus PKL Mahasiswa Informatika</h2>
            <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
        </div>

        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Angkatan</th>
                        <th scope="col">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($mahasiswas as $mahasiswa)
                    <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $mahasiswa->nim }}</td>
                        <td>{{ $mahasiswa->nama }}</td>
                        <td>{{ $mahasiswa->angkatan }}</td>
                        <td>{{ $mahasiswa->nilai }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>            
        </div>
    </div>
</section>
@endsection