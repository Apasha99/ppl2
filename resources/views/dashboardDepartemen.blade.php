@extends('layouts.layoutDepartemen')

@section('content')
    <section>
        <div class="container-lg my-5 text-light">
            <div class="text-center">
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
@endsection
