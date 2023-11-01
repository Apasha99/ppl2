<!-- <!DOCTYPE html>
<html>

<head>
    <title>Edit Data PKL</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Edit Data PKL</h1>
        <form method="post" action="{{ route('pkl.update', $pkl->nim) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" class="form-control" name="nim" value="{{ $pkl->nim }}" required>
            </div>
            <div class="form-group">
                <label for="status_pkl">Status PKL:</label>
                <select class="form-control" name="status_pkl">
                    <option value="Lulus PKL" {{ $pkl->status_pkl == 'Lulus PKL' ? 'selected' : '' }}>Lulus PKL</option>
                    <option value="Belum PKL" {{ $pkl->status_pkl == 'Belum PKL' ? 'selected' : '' }}>Belum PKL</option>
                    <option value="Sedang Ambil PKL" {{ $pkl->status_pkl == 'Sedang Ambil PKL' ? 'selected' : '' }}>
                        Sedang Ambil PKL</option>
                </select>
            </div>

             File Upload Section 
            <div class="form-group">
                <label for="scan_pkl">Scan PKL:</label>
                @if (isset($pkl->scan_pkl))
                    <a href="{{ asset('storage/' . $pkl->scan_pkl) }}" target="_blank">Lihat PDF</a>
                @endif
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="scan_pkl">File PKL (PDF)</label>
                        <input type="file" class="form-control-file" name="scan_pkl" accept=".pdf">
                    </div>
                </form>
            </div>



             Add more form fields as needed 

            Submit Button
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

     Additional scripts and styles 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html> -->
<!-- TIDAK FIX -->