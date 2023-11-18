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
                                    <th colspan="{{ 2*count($data) }}" class="text-center mt-3">Angkatan</th>
                                </tr>
                                <tr>
                                    @foreach ($data as $item)
                                        <th colspan="2" class="text-center mt-3">{{ $item->angkatan }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach ($data as $item)
                                        <td>Lulus</td>
                                        <td>Tidak Lulus</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($data as $item)
                                        <td>
                                            <a href="{{ route('list.index', ['angkatan' => $mahasiswa->angkatan, 'status' => 'verified']) }}"
                                            class="text-decoration-none">
                                                {{  $item->lulus_count ?? 'Data tidak tersedia' }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('list.index2', ['angkatan' => $mahasiswa->angkatan, 'status' => 'verified']) }}"
                                            class="text-decoration-none">
                                                {{  $item->tidak_lulus_count ?? 'Data tidak tersedia' }}
                                            </a>
                                        </td>
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
