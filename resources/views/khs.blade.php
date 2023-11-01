@extends('layouts.layoutMahasiswa')

@section('content')
<div class="container">
    <br>
    <a href="{{ route('khs.create') }}" class="btn btn-primary">Tambah KHS</a>
    <br>
    <h2 style="color:#fff">Daftar KHS</h2>
    @if(session('success'))
    <div class="alert alert-success text-light"> Correct the alert CSS class for success 
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger text-light">
        {{ session('error') }}
    </div>
    @endif
    @if ($khsData->count() > 0)
        <p> <span style="color:#fff"> Mahasiswa: {{ Auth::user()->mahasiswa->nama }} (NIM: {{ Auth::user()->mahasiswa->nim }})</span></p>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownSemester" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Semester Aktif
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownSemester">
                @foreach ($khsData as $khs)
                    <li class="dropdown-item" data-semester="{{ $khs->semester_aktif }}">{{ $khs->semester_aktif }}</li>
                @endforeach
            </ul>
        </div>

        <div id="khsDetail" style="display: none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Semester Aktif</th>
                        <th>Jumlah SKS Semester</th>
                        <th>Jumlah SKS Kumulatif</th>
                        <th>IP Semester</th>
                        <th>IP Kumulatif</th>
                        <th>Status</th>
                        <th>Scan KHS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($khsData as $khs)
                        <tr class="khs-row" data-semester="{{ $khs->semester_aktif }}">
                            <td>{{ $khs->semester_aktif }}</td>
                            <td>{{ $khs->jumlah_sks }}</td>
                            <td>{{ $khs->jumlah_sks_kumulatif }}</td>
                            <td>{{ $khs->ip_semester }}</td>
                            <td>{{ $khs->ip_kumulatif }}</td>
                            <td>{{ $khs->status }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $khs->scanKHS) }}" target="_blank">Lihat KHS</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Belum ada KHS yang diisi.</p>
    @endif
</div> 

<script>
    // Handle dropdown item click
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', () => {
            const selectedSemester = item.getAttribute('data-semester');
            showKHSDetail(selectedSemester);
        });
    });

    // Show KHS detail based on selected semester
    function showKHSDetail(semester) { // Correct the function name
        document.querySelectorAll('.khs-row').forEach(row => {
            row.style.display = row.getAttribute('data-semester') === semester ? 'table-row' : 'none';
        });
        document.getElementById('khsDetail').style.display = 'block';
    }
</script>
@endsection-
