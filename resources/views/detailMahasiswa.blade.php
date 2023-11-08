@extends('layouts.layoutDosen')

@section('content')
    <section>
        <div class="container-lg text-light">
            <div class="text-center mt-3">
                <h3>Progress Perkembangan Studi Mahasiswa</h3>
                <h3>Fakultas Sains dan Matematika UNDIP Semarang</h3>
            </div>

            <hr>

            <div class="row my-2 g-5 justify-content-around align-items-center">
                <div class="col-lg-6">
                    <dl class="row">
                        <dt class="col-sm-3">Nama</dt>
                        <dd class="col-sm-9">: {{ $mahasiswa->nama }}</dd>

                        <dt class="col-sm-3">NIM</dt>
                        <dd class="col-sm-9">: {{ $mahasiswa->nim }}</dd>

                        <dt class="col-sm-3">Angkatan</dt>
                        <dd class="col-sm-9">: {{ $mahasiswa->angkatan }}</dd>

                        <dt class="col-sm-3">Wali</dt>
                        <dd class="col-sm-9">: {{ $dosen->nama }}</dd>

                </div>

                <div class="col-6 col-lg-4">
                    <img src="{{ Auth::user()->getImageURL() }}" class="img-thumbnail h-50 w-50" alt="foto-profil" />
                </div>
            </div>

            <div class="my-5">
                <div class="text-center mb-5">
                    <h3>Semester</h3>
                </div>

                <div class="row row-cols-2 row-cols-md-5 g-4">
                    @for ($i = 1; $i <= 14; $i++)
                        @php
                            // Check if the current semester exists in the $irsData
                            $isActive = $irsData->contains('semester_aktif', $i);
                            $cardClass = $isActive ? 'active-card' : 'inactive-card';
                        @endphp
                
                        <div class="col">
                            <div class="card p-2 {{ $cardClass }} w-75 h-75">
                                <div class="card-body text-center">
                                    <a href="#" class="h5 card-title small">{{ $i }}</a>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                
            </div>

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const activeCards = document.querySelectorAll('.active-card');
            const inactiveCards = document.querySelectorAll('.inactive-card');

            activeCards.forEach(card => {
                card.style.backgroundColor = '#9ec5fe'; // Set your active card color
            });

            inactiveCards.forEach(card => {
                card.style.backgroundColor = '#dc3545'; // Set your inactive card color
            });
        });
    </script>
@endsection
