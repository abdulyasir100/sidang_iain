@extends('layout.layoutdosen')
@section('title', 'Beranda Dosen')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-10 rounded bg-white p-4">
                <h4>Detail Jadwal:</h4>
                <hr>
                @php
                    $tanggaljadi = new DateTime($detail->Jadwal->tanggal);
                    $tanggal = $tanggaljadi->format('d/m/Y');
                    $jam = $tanggaljadi->format('H:i:s');
                @endphp
                <p>Nama Mahasiswa : {{ $mahasiswa->Akun->nama }}</p>
                <p>NIM Mahasiswa : {{ $mahasiswa->nim }}</p>
                <p>Judul Skripsi : {{ $mahasiswa->judul_skripsi }}</p>
                <p>Tempat : {{ $detail->Jadwal->tempat }}</p>
                <p>Tanggal : {{ $tanggal }}</p>
                <p>Jam : {{ $jam }}</p>
                <hr>
                <div>
                    <a href="#accmodal" data-toggle="modal" class="btn btn-success">Terima</a>
                    <a href="#deccmodal" data-toggle="modal" class="btn btn-danger">Tolak</a>
                </div>

            </div>
        </div>
        <div class="modal fade" id="accmodal" tabindex="-1" role="dialog" aria-labelledby="accmodallabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="accmodal">Peringatan!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menerima undangan ini?
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-danger text-white" data-dismiss="modal">Kembali</a>
                        <a id="continue" class="btn btn-success" href="/terimaundangan/{{ $detail->idundangan }}">Terima</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deccmodal" tabindex="-1" role="dialog" aria-labelledby="deccmodallabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deccmodal">Peringatan!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menolak undangan ini?
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-danger text-white" data-dismiss="modal">Kembali</a>
                        <a id="continue" class="btn btn-success" href="/tolakundangan/{{ $detail->idundangan }}">Tolak</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
