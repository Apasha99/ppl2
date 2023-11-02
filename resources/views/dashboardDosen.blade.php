@extends('layouts.layoutDosen')

@section('content')
    <section>
        <div class="container-lg my-5">
            <div class="text-center text-light">
                <div class="display-6">Welcome, {{ Auth::user()->username }}</div>
            </div>

            <div class="row justify-content-center align-items-center gy-3 mt-5">
                <div class="col-lg-3 mx-2 bg-light border border-dark border-2 rounded">
                    <div class="d-flex justify-content-between pt-3 pe-2">
                        <p class="border border-dark border-1 rounded px-3">{{ $mahasiswaperwalian_count }}</p>
                        <h6 class="align-items-center"><i class="bi bi-mortarboard-fill"></i> Mahasiswa Perwalian</h6>
                    </div>
                </div>
                <div class="col-lg-3 mx-2 bg-light border border-dark border-2 rounded">
                    <div class="d-flex justify-content-between pt-3 pe-2">
                        <p class="border border-dark border-1 rounded px-3">{{ $mahasiswaCount }}</p>
                        <h6 class="align-items-center"><i class="bi bi-backpack-fill"></i> Mahasiswa</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light rounded">
        <div class="text-center my-5 pt-5">
            <h1 class="display-6">Daftar Mahasiswa</h1>
        </div>

        <div class="col-lg-6 mx-2">
            <form class="d-flex" role="search">
                <select id="filterAngkatan" class="form-select me-2">
                    <option value="" selected>Semua Angkatan</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                </select>

                <input class="form-control me-2" type="search" id="searchInput"
                    placeholder="Cari mahasiswa berdasarkan nama" aria-label="Search">
                <button class="btn btn-outline-success" type="button" onclick="searchMahasiswa()">Search</button>
            </form>
        </div>

        <div class="container-lg my-5 pb-4">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-person-fill"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="justify-content-center">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Angkatan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTable">
                        @foreach ($mahasiswas as $mahasiswa)
                            <tr>
                                <td>{{ $mahasiswa->nama }}</td>
                                <td>{{ $mahasiswa->nim }}</td>
                                <td>{{ $mahasiswa->angkatan }}</td>
                                <td>{{ $mahasiswa->status }}</td>
                                <td>
                                    <a href=" /mahasiswa-detail/{{$mahasiswa}} " class="btn btn-warning btn-sm">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="searchError" class="alert alert-danger mt-2" style="display: none;"></div>

        <script>
            function searchMahasiswa() {
                var input = document.getElementById('searchInput').value.toLowerCase();
                var filterAngkatan = document.getElementById('filterAngkatan').value;
                var table = document.getElementById('mahasiswaTable');
                var rows = table.getElementsByTagName('tr');
                var errorDiv = document.getElementById('searchError');
        
                errorDiv.style.display = 'none';
        
                var resultFound = false;
        
                for (var i = 0; i < rows.length; i++) {
                    var nama = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                    var nim = rows[i].getElementsByTagName('td')[1].textContent; // Dapatkan NIM dari kolom ke-2
                    var angkatan = rows[i].getElementsByTagName('td')[2].textContent;
        
                    if ((nama.includes(input) || nim.includes(input)) && (filterAngkatan === "" || angkatan === filterAngkatan)) {
                        rows[i].style.display = '';
                        resultFound = true;
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
        
                if (!resultFound) {
                    errorDiv.innerHTML = 'Nama atau NIM tidak ada di dalam daftar mahasiswa';
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.style.display = 'none';
                }
            }
        </script>        

    </section>
@endsection
