@extends('layouts.layoutDepartemen')

@section('content')
    <section>
        <div class="container-lg text-light">
            <div class="text-center">
                <h2>Rekap Progress Skripsi Mahasiswa Informatika</h2>
                <h2>Fakultas Sains dan Matematika UNDIP Semarang</h2>
            </div>

            <div class="my-5">
                <div class="text-center">
                    <h4>Angkatan</h4>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tahun</th>
                            <th scope="col">Lulus</th>
                            <th scope="col">Belum Lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswasSkripsi as $mahasiswa)
                            <tr class="table-active">
                                <td>{{ $mahasiswa->angkatan }}</td>
                                <td>
                                    <a href="{{ route('list.skripsi', ['angkatan' => $mahasiswa->angkatan, 'status' => 'verified']) }}"
                                    class="text-decoration-none">
                                        {{  $mahasiswa->lulus_count ?? 'Data tidak tersedia' }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('list.skripsi2', ['angkatan' => $mahasiswa->angkatan, 'status' => 'pending']) }}"
                                    class="text-decoration-none">
                                        {{ $mahasiswa->tidak_lulus_count ?? 'Data tidak tersedia' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-primary" onclick="openPDFModal()">+ Cetak Rekap Skripsi</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal untuk preview dan download PDF -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Preview Rekap Skripsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Elemen untuk menampilkan PDF -->
                    <iframe id="pdfViewer" width="100%" height="600px" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <a id="downloadLink" class="btn btn-primary" href="#" download="rekap_skripsi.pdf">Unduh PDF</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal dan menampilkan PDF di dalamnya
        function openPDFModal() {
            const pdfUrl = "{{ route('generateRekapSkripsi') }}";
            const pdfUrl2 = "{{ route('PreviewSkripsi') }}";

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
                a.download = 'rekap_skripsi.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => console.error('Error:', error));
        });

    </script>
@endsection
