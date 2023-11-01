@extends('layouts.layoutOperator')

@section('content')
    <section>
        <div class="container-lg my-5">
            <div class="text-center text-light">
                <h2>Tambah Mahasiswa Baru</h2>
            </div>
            @if (session('success'))
                <div class="alert alert-error">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            {{-- <input type="file" class="form-control mt-3" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  />   --}}

            <div class="row justify-content-center my-5 text-light">
                <div class="col-lg-6">
                    <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @error('nama')
                            <div class="text-danger mt-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                        <label for="nama" class="form-label">Nama:</label>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama Mahasiswa" required>
                        </div>

                        @error('nim')
                            <div class="text-danger mt-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                        <label for="nim" class="form-label">NIM:</label>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" id="nim" name="nim"
                                placeholder="Masukkan NIM Mahasiswa" required>
                        </div>

                        @error('angkatan')
                            <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                        <label for="angkatan" class="form-label">Angkatan:</label>
                        <div class="input-group mb-4">
                            <select class="form-select" name="angkatan" id="angkatan" required>
                                <option selected value="">-- Pilih Angkatan --</option>
                                @for ($i = 18; $i <= 23; $i++)
                                    <option value="20{{ $i }}">20{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        @error('status')
                            <div class="text-danger mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                        <label for="status" class="form-label">Status:</label>
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="active" name="status" value="active"
                                    checked>
                                <label class="form-check-label" for="active">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="inactive" name="status"
                                    value="inactive">
                                <label class="form-check-label" for="inactive">Tidak aktif</label>
                            </div>
                        </div>

                        @error('username')
                            <div class="text-danger mt-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                        <label for="username" class="form-label">Username:</label>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Generate Username Mahasiswa" required disabled>
                            <button type="button" class="btn btn-outline-warning"
                                onclick="generateUsername()">Generate</button>
                        </div>

                        @error('password')
                            <div class="text-danger mt-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                        <label for="password" class="form-label">Password:</label>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" id="password" name="password"
                                placeholder="Generate Password Mahasiswa" required disabled>
                            <button type="button" class="btn btn-outline-warning"
                                onclick="generatePassword()">Generate</button>
                        </div>

                        @error('nip')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="nip" class="form-label">Nama Dosen wali:</label>
                        <div class="input-group mb-4">
                            <select class="form-select" name="nip" id="nip" required>
                                <option value="">Pilih Dosen Wali</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->nip }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>

                <div class="text-center my-5">
                    <button type="submit" class="btn btn-primary px-3">Tambah Data</button>
                </div>

                </form>
            </div>
        </div>

        </div>

    </section>
@endsection

@section('script')
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
            passwordField.value = Math.random().toString(36).substring(2,
                10); // Generates an 8-character alphanumeric password
        }
    </script>
@endsection
