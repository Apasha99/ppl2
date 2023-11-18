<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Progress PKL Mahasiswa Informatika</title>
    <!-- CSS styling -->
    <style>
        /* CSS style untuk membuat tampilan tabel */
        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>
    <div>
        <h2>Rekap Progress PKL Mahasiswa Informatika</h2>
        <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>

        <table>
            <thead>
                <tr>
                    <th>Angkatan</th>
                    <th>Lulus</th>
                    <th>Tidak Lulus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswas as $mahasiswa)
                    <tr>
                        <td>{{ $mahasiswa->angkatan }}</td>
                        <td>{{ $mahasiswa->lulus_count }}</td>
                        <td>{{ $mahasiswa->tidak_lulus_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>