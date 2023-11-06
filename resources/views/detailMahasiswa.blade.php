@extends('layouts.layoutDosen')

@section('content')
    <section>
        <div class="container-lg text-light">
            <div class="text-center">
                <h2>Progress Perkembangan Studi Mahasiswa</h2>
                <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
            </div>

            <hr>

            <div class="row my-5 g-5 justify-content-around align-items-center">
                <div class="col-lg-6">
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <td>NIM</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <td>Angkatan</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->angkatan }}</td>
                        </tr>
                        <tr>
                            <td>Dosen Wali</td>
                            <td>:</td>
                            <td>{{ $mahasiswa->nip }}</td>
                        </tr>
                    </table>

                </div>

                <div class="col-6 col-lg-4">
                    <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-100 w-100" alt="foto-profil" />
                </div>
            </div>

        </div>
    </section>
@endsection
