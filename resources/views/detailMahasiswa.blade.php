@extends('layouts.layoutDosen')

@section('content')

    <section>

        <div class="text-center text-light">
            <h2>IRS</h2>
        </div>

        <div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="{{ route('irs.updateStatus') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                    @if ($irsData->count() > 0)
                        <table class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Semester Aktif</th>
                                    <th scope="col">Jumlah SKS</th>
                                    <th scope="col">Scan IRS</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($irsData as $irs)
                                    <tr class="irs-row" data-semester="{{ $irs->semester_aktif }}">
                                        <td scope="row">{{ $irs->semester_aktif }}</td>
                                        <td>{{ $irs->jumlah_sks }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $irs->scanIRS) }}" target="_blank">Lihat IRS</a>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-circle-fill"></i></button>
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-x-lg"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    </form>
                </div>
            </div>
        </div>

    </section>


@endsection
