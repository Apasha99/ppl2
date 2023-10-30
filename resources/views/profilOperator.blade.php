<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Operator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

    <section id="profil-oper">
        <div class="container-lg my-5">
            @method('POST')
            <div class="text-center">
                <h2>Edit Profil</h2>
            </div>
            @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="row my-4 g-4 justify-content-around align-items-center">
                <!-- align-items-center means positioning all elements to the center inside the box / container, in this case the columns -->
                <div class="col-md-5 text-center text-md-start">
                @if($operators)
                    <form action="{{ route('operator.update', ['nip' => $operators->nip, 'username' => $operators->username]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label for="nama" class="form-label">Nama</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $operators->nama }}" disabled>
                        </div>

                        <label for="nip" class="form-label">NIP</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nip" name="nip" value="{{ $operators->nip }}" disabled>
                        </div>

                        <label for="username" class="form-label">Username</label>
                        <div class="input-group mb-3">
                            <!-- <span class="input-group-text">
                                <i class="bi bi-envelope-fill"></i>
                            </span> -->
                            <input type="username" class="form-control" id="username" name="username"
                                value="{{ $operators->username }}" disabled>
                            @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- <label for="current_password" class="form-label">Password Lama</label>
                        <div class="input-group mb-5">
                            <input type="password" class="form-control" id="current_password"
                                name="current_password" value="{{ $operators->current_password }}" disabled>
                            @error('current_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group mb-5">
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Masukkan Password Baru">
                            @error('new_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <label for="new_confirm_password" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group mb-5">
                            <input type="new_confirm_password" class="form-control" id="new_confirm_password"
                                name="password" placeholder="Masukkan Konfirmasi Password Baru">
                            @error('new_confirm_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div> -->

                        <a href="profilOperator" class="btn btn-warning">Edit</a>
                        <a href="profilOperator" type="submit" class="btn btn-success">Save</a>
                    </form>

                </div>
                <div class="col-md-5 text-center d-none d-md-block">
                    <div class="avatar flex items-center justify-center mt-[100px]">
                        <div class="w-48 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="{{ Auth::user()->getImageURL() }}" />
                        </div>
                    </div>
                    <input type="fotoProfil" class="form-control mt-3" id="fotoProfil" accept=".jpg, .jpeg, .png">
                    @error('fotoProfil')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            </div>
        </div>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
