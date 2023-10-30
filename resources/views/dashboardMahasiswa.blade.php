@extends('layouts.layoutMahasiswa')

@section('navbar')

@endsection

@section('content')

<section>
<div class="container">
    <h1 class="mt-4">Dashboard Mahasiswa</h1>
    <div class="text-center mt-4" style="width:15%">
        <img src="{{ Auth::user()->getImageURL() }}" alt="Foto Profil" class="img-thumbnail">
    </div>
    <table class="table mt-4">
        <tr>
            <th>Nama:</th>
            <td>{{ $mahasiswa->nama}}</td>
        </tr>
        <tr>
            <th>NIM:</th>
            <td>{{ $mahasiswa->nim }}</td>
        </tr>
        <tr>
            <th>Angkatan:</th>
            <td>{{ $mahasiswa->angkatan }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{ $mahasiswa->status }}</td>
        </tr>
        <tr>
            <th>Username:</th>
            <td>{{ $mahasiswa->username }}</td>
        </tr>
        <tr>
            <th>Dosen Wali:</th>
            <td>{{ $mahasiswa->dosen_nama }}</td>
        </tr>
    </table>
</div>
</section>

@endsection
