<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand me-5">
                <span class="fw-bold">
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
                        <a class="nav-link dropdown-toggle justify-content-end" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1 style="text-align: center; color: #5D6D7E;">Tambah Mahasiswa Baru</h1>
    <div class="mt-5 ">
        <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data" style="width: 50%; margin: auto;">
            @csrf
            <!-- Form fields for mahasiswa attributes -->
            <div style="margin-bottom: 10px;">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" required style="width: 100%;">
                @error('nama')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="nim">NIM:</label>
                <input type="text" name="nim" id="nim" required style="width: 100%;">
                @error('nim')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="angkatan">Angkatan:</label>
                <select name="angkatan" id="angkatan" required style="width: 100%;">
                    <option value="">-- Pilih Angkatan --</option>
                    @for ($i = 18; $i <= 23; $i++)
                        <option value="20{{$i}}">20{{$i}}</option>
                    @endfor
                </select>
                @error('angkatan')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="status">Status:</label><br>
                <input type="radio" id="active" name="status" value="active">
                <label for="active">Aktif</label><br>
                <input type="radio" id="inactive" name="status" value="inactive">
                <label for="inactive">Tidak aktif</label>
                @error('status')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required style="width: 100%;">
                <button type="button" class="btn btn-primary" onclick="generateUsername()" style=" margin-top:10px;">Generate</button>
                @error('username')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="password">Password:</label>
                <input type="text" name="password" id="password" required style="width: 100%;">
                <button type="button" class="btn btn-primary"" onclick="generatePassword()" style="margin-top:10px">Generate</button>
                @error('password')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div style="margin-bottom: 10px;">
                <label for="nip">Nama Doswal:</label>
                <select name="nip" id="nip" required style="width: 100%;">
                    <option value="">Pilih Dosen Wali</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->nip }}">{{ $dosen->nama }}</option>
                    @endforeach
                </select>

                @error('nip')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" style="background-color: #1A5276; color: white; padding: 10px 20px; border: none; cursor: pointer;">Tambah Data</button>
        </form>
    </div>

    <script>
        // Function to generate a random username
        function generateUsername() {
            var usernameField = document.getElementById("username");
            var namaField = document.getElementById("nama");
            if (namaField.value) {
                usernameField.value = namaField.value.replace(/\s/g, '');
            }
        }

        // Function to generate a random password
        function generatePassword() {
            var passwordField = document.getElementById("password");
            passwordField.value = Math.random().toString(36).substring(2, 10); // Generates an 8-character alphanumeric password
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
