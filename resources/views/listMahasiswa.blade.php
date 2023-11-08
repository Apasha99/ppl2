@extends('layouts.layoutDepartemen')

@section('content')
<section class="text-light">
    <div class="container-lg">
        <div class="text-center my-5">
            <h2>Daftar ___ ___ Mahasiswa Informatika</h2>
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
                    @foreach ($mahasiswas as $mahasiswa)
                    <tr>
                        <th scope="row">1</th>
                        <td> {{ $mahasiswa->nim }} </td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td> </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
</section>
@endsection