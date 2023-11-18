@extends('layouts.layoutDepartemen')

@section('content')
<section>
    <div class="container-lg text-light">
        <div class="text-center my-5">
            <h2>Daftar Belum Lulus PKL Mahasiswa Informatika</h2>
            <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
        </div>

        <div>
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
            <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-primary" onclick="openPDFModal()">+ Cetak List PKL</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal untuk preview dan download PDF -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Preview List PKL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Elemen untuk menampilkan PDF -->
                    <iframe id="pdfViewer" width="100%" height="600px" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <a id="downloadLink" class="btn btn-primary" href="#" download="list_pkl.pdf">Unduh PDF</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Fungsi untuk membuka modal dan menampilkan PDF di dalamnya
        function openPDFModal() {
            const pdfUrl = "{{ route('generateListPKLBelum',['angkatan' => $mahasiswa->angkatan, 'status' => 'pending']) }}";
            const pdfUrl2 = "{{ route('PreviewListPKLBelum',['angkatan' => $mahasiswa->angkatan, 'status' => 'pending']) }}";

            const pdfViewer = document.getElementById('pdfViewer');
            const downloadLink = document.getElementById('downloadLink');

            pdfViewer.src = pdfUrl2;
            downloadLink.href = pdfUrl;

            const myModal = new bootstrap.Modal(document.getElementById('pdfModal'));
            myModal.show();
        }

        // Fungsi untuk mengatur unduhan saat tombol "Unduh PDF" ditekan
        document.getElementById('downloadLink').addEventListener('click', function(event) {
            event.preventDefault();
            const url = this.getAttribute('href');
            
            // Menggunakan fetch untuk mengunduh file
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/pdf'
                }
            })
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(new Blob([blob]));
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = 'list_belum_pkl.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => console.error('Error:', error));
        });

    </script>
@endsection
