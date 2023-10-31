<!DOCTYPE html>
<html>

<head>
    <title>Data PKL</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Data PKL</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIM</th>
                    <th>Status PKL</th>
                    <th>Scan PKL</th>
                    <th>Action</th> <!-- Kolom untuk tombol edit dan delete -->
                </tr>
            </thead>
            <tbody>
                @foreach ($dataPKL as $pkl)
                    <tr>
                        <td>{{ $pkl->id }}</td>
                        <td>{{ $pkl->nim }}</td>
                        <td>{{ $pkl->status_pkl }}</td>
                        <td>
                            @if ($pkl->scan_pkl)
                                {{ basename($pkl->scan_pkl) }}
                            @else
                                Belum Diunggah
                            @endif
                        </td>
                       
                        <td>
                            <a href="{{ route('pkl.edit', ['nim' => $pkl->nim]) }}" class="btn btn-primary">Edit</a>

                            <!-- Form untuk menghapus data -->
                            <form action="{{ route('pkl.destroy', ['nim' => $pkl->nim]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tombol untuk menambahkan data PKL -->
        <a href="{{ route('pkl.create') }}" class="btn btn-success">+ Tambah Data PKL</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
