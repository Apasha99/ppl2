<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List Progress Skripsi Mahasiswa Informatika</title>
    <!-- Bootstrap CSS (jika menggunakan framework Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS styling -->
    <style>
        /* CSS style untuk membuat tampilan tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; /* Jarak antara tabel dan tombol */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container-lg {
            margin-top: 20px; /* Jarak atas container */
        }
        .btn-print {
            float: right; /* Tombol Cetak di sebelah kanan */
            margin-bottom: 10px; /* Jarak dari bawah tombol */
        }
    </style>
</head>
<body>
    <div class="container-lg">
        <div class="text-center mt-5 mb-4">
            <h2>Daftar Belum Lulus Skripsi Mahasiswa Informatika</h2>
            <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Angkatan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach ($mahasiswas as $mahasiswa)
                <tr>
                    <th scope="row">{{ $counter++ }}</th>
                    <td>{{ $mahasiswa->nim }}</td>
                    <td>{{ $mahasiswa->nama }}</td>
                    <td>{{ $mahasiswa->angkatan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
    </div>

    <!-- Bootstrap JavaScript (jika menggunakan framework Bootstrap) -->
    <!-- Anda mungkin perlu menyertakan script JavaScript Bootstrap di bagian bawah -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk fungsi buka modal PDF (seperti yang diinstruksikan di tombol) -->
    <script>
        function openPDFModal() {
            // Fungsi untuk membuka modal atau melakukan sesuatu yang relevan untuk mencetak PDF
            // Anda dapat menambahkan fungsi JavaScript yang sesuai di sini
            alert('Buka modal untuk mencetak PDF');
        }
    </script>
</body>
</html>
