@extends('layouts.layoutMahasiswa')

@section('content')
<div class="container">
    <br>
    <a href="{{ route('skripsi.create') }}" class="btn btn-primary">Tambah Skripsi</a>
    <br>
    <h2 style="color:#fff">Daftar Skripsi</h2>
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
    @if ($skripsiData->count() > 0)
        <p> <span style="color:#fff"> Mahasiswa: {{ Auth::user()->mahasiswa->nama }} (NIM: {{ Auth::user()->mahasiswa->nim }})</span></p>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type of="button" id="dropdownSemester" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Semester Aktif
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownSemester">
                @foreach ($skripsiData as $skripsi)
                    <li class="dropdown-item" data-semester="{{ $skripsi->semester_aktif }}">{{ $skripsi->semester_aktif }}</li>
                @endforeach
            </ul>
        </div>

        <div id="skripsiDetail" style="display: none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Semester Aktif</th>
                        <th>Nilai</th>
                        <th>Lama Studi</th>
                        <th>Tanggal Sidang</th>
                        <th>Status Skripsi</th>
                        <th>Status</th>
                        <th>Scan Skripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skripsiData as $skripsi)
                        <tr class="skripsi-row" data-semester="{{ $skripsi->semester_aktif }}">
                            <td>{{ $skripsi->semester_aktif }}</td>
                            <td>{{ $skripsi->nilai }}</td>
                            <td>{{ $skripsi->lama_studi }}</td>
                            <td>{{ $skripsi->tanggal_sidang }}</td>
                            <td>{{ $skripsi->statusSkripsi }}</td>
                            <td>{{ $skripsi->status }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $skripsi->scanSkripsi) }}" target="_blank">Lihat Skripsi</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Belum ada Skripsi yang diisi.</p>
    @endif
</div>

<script>
    // Handle dropdown item click
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', () => {
            const selectedSemester = item.getAttribute('data-semester');
            showSkripsiDetail(selectedSemester);
        });
    });

    // Show Skripsi detail based on selected semester
    function showSkripsiDetail(semester) {
        document.querySelectorAll('.skripsi-row').forEach(row => {
            row.style.display = row.getAttribute('data-semester') === semester ? 'table-row' : 'none';
        });
        document.getElementById('skripsiDetail').style.display = 'block';
    }
</script>
@endsection
