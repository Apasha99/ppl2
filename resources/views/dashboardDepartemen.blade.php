@extends('layouts.layoutDepartemen')

@section('content')
    <section class="text-light">
        <div class="container-lg">
            <div class="text-center">
                <h2>Rekap Progress PKL Mahasiswa Informatika</h2>
                <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
            </div>

            <div class="my-5">
                <h4>Angkatan</h4>
                <table class="table">
                    <thead>
                        @foreach ($mahasiswas as $mahasiswa)
                        <tr>
                            <th scope="col" colspan="2"> {{ $mahasiswa->angkatan }} </th>
                            <th scope="col">Sudah</th>
                            <th scope="col">Belum</th>
                        </tr>
                        @endforeach
                    </thead>
                    <tbody>
                        <tr class="table-active">
                            <th scope="row" colspan="2">
                            <td> <a href="/listMahasiswa">88</a> </td>
                            <td> <a href="/listMahasiswa">33</a> </td>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
