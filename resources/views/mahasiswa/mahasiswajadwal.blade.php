@extends('layout.layoutmahasiswa')
@section('title', 'Beranda mahasiswa')
@section('content')
    <div class="container mt-4">
        <div class="row card">
            <div class="card-body">
                <h3 class="card-title">Informasi Mahasiswa:</h3>
                <hr>
                <p class="card-text">Nama Mahasiswa : {{ $mahasiswa->Akun->nama }}</p>
                <p class="card-text">Nomor Telepon Mahasiswa : {{ $mahasiswa->Akun->nomor_telp }}</p>
                <p class="card-text">Semester : {{ $mahasiswa->semester }}</p>
                <p class="card-text">Fakultas : {{ $mahasiswa->fakultas }}</p>
                <p class="card-text">Prodi : {{ $mahasiswa->prodi }}</p>
                <p class="card-text">Jurusan : {{ $mahasiswa->jurusan }}</p>
                <p class="card-text">Judul Skripsi : {{ $mahasiswa->judul_skripsi }}</p>
            </div>
        </div>
        <br>
        <div class="row card">
            <div class="card-body">
                <h3 class="card-title">Detail Jadwal:</h3>
                <hr>
                @php
                    $tanggaljadi = new DateTime($jadwal->tanggal);
                    $tanggal = $tanggaljadi->format('d/m/Y');
                    $jam = $tanggaljadi->format('H:i:s');
                @endphp
                <p class="card-text">Tempat : {{ $jadwal->tempat }}</p>
                <p class="card-text">Tanggal : {{ $tanggal }}</p>
                <p class="card-text">Jam : {{ $jam }}</p>
                @php
                    $status = 0;
                    $now = date('d/m/Y H:i:s');
                    if ($tanggaljadi > $now) {
                        if ($jadwal->status != 2) {
                            $status = 1;
                        } else {
                            $status = 2;
                        }
                    }
                @endphp
                <p>Status : @switch($status)
                        @case(0)
                            Belum Dimulai
                        @break

                        @case(1)
                            Sedang Berlangsung
                        @break

                        @case(2)
                            Selesai
                        @break
                    @endswitch
                </p>
                <b class="card-text">Dosen Penguji : </b>
                <hr>
                <ol>
                    @foreach ($dosen as $d)
                        <li>{{ $d->nama }} / {{ $d->nip }} / {{ $d->nomor_telp }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection
