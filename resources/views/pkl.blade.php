@extends('layouts.layoutMahasiswa')

@section('content')
<div class="container">
    <br>
    <a href="{{ route('pkl.create') }}" class="btn btn-primary">Tambah PKL</a>
    <br>
    <h2 style="color:#fff">Daftar PKL</h2>
    @if(session('success'))
    <div class="alert alert-success text-light">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger text-light">
        {{ session('error') }}
    </div>
    @endif
    @if ($pklData->count() > 0)
        <p> <span style="color:#fff"> Mahasiswa: {{ Auth::user()->mahasiswa->nama }} (NIM: {{ Auth::user()->mahasiswa->nim }})</span></p>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type of="button" id="dropdownSemester" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Semester Aktif
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownSemester">
                @foreach ($pklData as $pkl)
                    <li class="dropdown-item" data-semester="{{ $pkl->semester_aktif }}">{{ $pkl->semester_aktif }}</li>
                @endforeach
            </ul>
        </div>

        <div id="pklDetail" style="display: none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Semester Aktif</th>
                        <th>Status PKL</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Berita Acara Sidang PKL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pklData as $pkl)
                        <tr class="pkl-row" data-semester="{{ $pkl->semester_aktif }}">
                            <td>{{ $pkl->semester_aktif }}</td>
                            <td>{{ $pkl->nilai }}</td>
                            <td>{{ $pkl->statusPKL }}</td>
                            <td>{{ $pkl->status }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $pkl->scanPKL) }}" target="_blank">Lihat PKL</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Belum ada PKL yang diisi.</p>
    @endif
</div>

<script>
    // Handle dropdown item click
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', () => {
            const selectedSemester = item.getAttribute('data-semester');
            showPKLDetail(selectedSemester);
        });
    });

    // Show PKL detail based on selected semester
    function showPKLDetail(semester) {
        document.querySelectorAll('.pkl-row').forEach(row => {
            row.style.display = row.getAttribute('data-semester') === semester ? 'table-row' : 'none';
        });
        document.getElementById('pklDetail').style.display = 'block';
    }
</script>
@endsection
