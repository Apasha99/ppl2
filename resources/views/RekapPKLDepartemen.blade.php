@extends('layouts.layoutDepartemen')

@section('content')
    <section>
        <div class="container-lg text-light">
            <div class="text-center mt-3">
                <h2>Rekap Progress PKL Mahasiswa Informatika</h2>
                <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
            </div>

            <hr>

            <div class="row my-2 justify-content-center align-items-center">
                <div class="col-lg-10">
                    <div class="table-responsive">
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th colspan="12" class="text-center mt-3">Angkatan</th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-center mt-3">2018</th>
                                    <th colspan="2" class="text-center mt-3">2019</th>
                                    <th colspan="2" class="text-center mt-3">2020</th>
                                    <th colspan="2" class="text-center mt-3">2021</th>
                                    <th colspan="2" class="text-center mt-3">2022</th>
                                    <th colspan="2" class="text-center mt-3">2023</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Lulus</td>
                                    <td>Tidak Lulus</td>
                                    <td>Lulus</td>
                                    <td>Tidak Lulus</td>
                                    <td>Lulus</td>
                                    <td>Tidak Lulus</td>
                                    <td>Lulus</td>
                                    <td>Tidak Lulus</td>
                                    <td>Lulus</td>
                                    <td>Tidak Lulus</td>
                                    <td>Lulus</td>
                                    <td>Tidak Lulus</td>
                                </tr>
                                <tr>
                                    @foreach ($data as $item)
                                        <td>{{ $item->luluspkl }}</td>
                                        <td>{{ $item->tdkluluspkl }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
