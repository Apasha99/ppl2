@extends('layouts.layoutMahasiswa')

@section('content')
<div class="container">
    <br>
    <a href="{{ route('irs.create') }}" class="btn btn-primary">Tambah IRS</a>
    <br>
    <h2 style="color:#fff">Daftar IRS</h2>
    @if(session('success'))
    <div class="alert alert-error text-light">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error text-light">
        {{ session('error') }}
    </div>
    @endif
    @if ($irsData->count() > 0)
        <p> <span style="color:#fff"> Mahasiswa: {{ Auth::user()->mahasiswa->nama }} (NIM: {{ Auth::user()->mahasiswa->nim }})</p>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownSemester" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Semester Aktif
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownSemester">
                @foreach ($irsData as $irs)
                    <li class="dropdown-item" data-semester="{{ $irs->semester_aktif }}">{{ $irs->semester_aktif }}</li>
                @endforeach
            </ul>
        </div>

        <div id="irsDetail" style="display: none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Semester Aktif</th>
                        <th>Jumlah SKS</th>
                        <th>Status</th>
                        <th>Scan IRS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($irsData as $irs)
                        <tr class="irs-row" data-semester="{{ $irs->semester_aktif }}">
                            <td>{{ $irs->semester_aktif }}</td>
                            <td>{{ $irs->jumlah_sks }}</td>
                            <td>{{ $irs->status }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $irs->scanIRS) }}" target="_blank">Lihat IRS</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Belum ada IRS yang diisi.</p>
    @endif
</div>

<script>
    // Handle dropdown item click
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', () => {
            const selectedSemester = item.getAttribute('data-semester');
            showIRSDetail(selectedSemester);
        });
    });

    // Show IRS detail based on selected semester
    function showIRSDetail(semester) {
        document.querySelectorAll('.irs-row').forEach(row => {
            row.style.display = row.getAttribute('data-semester') === semester ? 'table-row' : 'none';
        });
        document.getElementById('irsDetail').style.display = 'block';
    }
</script>
@endsection
