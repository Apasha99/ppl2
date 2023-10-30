<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* Custom styles go here */
        .card-data {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
        }
        
        .card-desc {
            font-size: 14px;
        }
        
        .card-count {
            font-size: 24px;
            font-weight: bold;
        }
        
        #daftar-mhs {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand me-5">
                <span class="fw-bold">
                    {{-- insert image here --}}
                    Dashboard Operator
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active me-2" aria-current="page" href="dashboardOperator"><i
                                class="bi bi-house-door-fill"></i> Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle justify-content-end" href="" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('operator.edit', ['nip' => $operators->nip]) }}">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- DASHBOARD OPERATOR DASHBOARD OPERATOR --}}
    <h1 class="mt-4">Welcome, {{Auth::user()->username}}</h1>
    <div class="row mt-5">
        <div class="col-lg-3 ">
            <div class="card-data">
                <div class="row">
                    <div class="col-6"><i class="bi bi-journal-richtext"></i></div>
                    <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                        <div class="card-desc">User</div>
                        <div class="card-count">{{$user_count}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 ">
            <div class="card-data">
                <div class="row">
                    <div class="col-6"><i class="bi bi-journal-richtext"></i></div>
                    <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                        <div class="card-desc">Mahasiswa</div>
                        <div class="card-count">{{$mahasiswa_count}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 ">
            <div class="card-data">
                <div class="row">
                    <div class="col-6"><i class="bi bi-journal-richtext"></i></div>
                    <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                        <div class="card-desc">Dosen Wali</div>
                        <div class="card-count">{{$dosen_count}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 ">
            <div class="card-data">
                <div class="row">
                    <div class="col-6"><i class="bi bi-journal-richtext"></i></div>
                    <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                        <div class="card-desc">Departemen</div>
                        <div class="card-count">{{$departemen_count}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="daftar-mhs">
        <div class="text-center my-5">
            <h3>Daftar Mahasiswa</h3>
        </div>

        <div class="container-lg my-5">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
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
                            <th scope="col">NIP Dosen Wali</th>
                            <th scope="col">Dosen Wali</th>
                            <th scope="col">Username</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswas as $mahasiswa)
                        <tr>
                            <td>{{ $mahasiswa->nama }}</td>
                            <td>{{ $mahasiswa->nim }}</td>
                            <td>{{ $mahasiswa->angkatan }}</td>
                            <td>{{ $mahasiswa->status }}</td>
                            <td>{{ $mahasiswa->dosen_wali->nip }}</td>
                            <td>{{ $mahasiswa->dosen_wali->nama}}</td>
                            <td>{{ $mahasiswa->username }}</td>
                            <td>
                                <button class="btn btn-warning">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="/mahasiswa-create" class="btn btn-success">+ Tambah Mahasiswa</a>
                <!-- Ganti "/tambah-mahasiswa" dengan URL yang sesuai -->
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
