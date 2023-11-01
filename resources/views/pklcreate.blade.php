<!-- <!DOCTYPE html>
<html>

<head>
    <title>Tambah Data PKL</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Tambah Data PKL</h1>
        <form method="post" action="{{ route('pkl.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" class="form-control" name="nim" required>
            </div>

            <label for="status_pkl">Status PKL:</label>
            <select class="form-control" name="status_pkl">
                <option value="Lulus PKL" {{ $pkl->status_pkl == 'Lulus PKL' ? 'selected' : '' }}>Lulus PKL</option>
                <option value="Belum PKL" {{ $pkl->status_pkl == 'Belum PKL' ? 'selected' : '' }}>Belum PKL</option>
                <option value="Sedang Ambil PKL" {{ $pkl->status_pkl == 'Sedang Ambil PKL' ? 'selected' : '' }}>Sedang Ambil PKL</option>
            </select>


            <div class="form-group">
                <label for="scan_pkl">Scan PKL:</label>
                @if (isset($pkl->scan_pkl))
                    <a href="{{ asset('storage/' . $pkl->scan_pkl) }}" target="_blank">Lihat PDF</a>
                @endif
                <input type="file" class="form-control" name="scan_pkl" accept=".pdf">
            </div>
            <button type="submit" class="btn btn-primary">Tambahkan Data PKL</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html> -->

<!-- TIDAK FIX -->
