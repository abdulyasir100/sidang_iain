@extends('layout.layoutdosen')
@section('title', 'Beranda Dosen')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="bg-light rounded p-4 col-12">
                <h4>Informasi Mahasiswa:</h4>
                <hr>
                <p>Nama Mahasiswa : {{ $mahasiswa->Akun->nama }}</p>
                <p>Nomor Telepon Mahasiswa : {{ $mahasiswa->Akun->nomor_telp }}</p>
                <p>Semester : {{ $mahasiswa->semester }}</p>
                <p>Fakultas : {{ $mahasiswa->fakultas }}</p>
                <p>Prodi : {{ $mahasiswa->prodi }}</p>
                <p>Jurusan : {{ $mahasiswa->jurusan }}</p>
                <p>Judul Skripsi : {{ $mahasiswa->judul_skripsi }}</p>
            </div>
            <div class="bg-light mt-4 rounded p-4 col-12">
                <h4>Detail Jadwal:</h3>
                    <hr>
                    @php
                        $tanggaljadi = new DateTime($jadwal->tanggal);
                        $tanggal = $tanggaljadi->format('d/m/Y');
                        $jam = $tanggaljadi->format('H:i:s');
                    @endphp
                    <p>Tempat : {{ $jadwal->tempat }}</p>
                    <p>Tanggal : {{ $tanggal }}</p>
                    <p>Jam : {{ $jam }}</p>
                    @php
                        $status = $jadwal->status;
                        if ($jadwal->status == 0) {
                            $now = date('d/m/Y H:i:s');
                            $comparetgl = $tanggaljadi->format('d/m/Y H:i:s');
                            if ($now > $comparetgl) {
                                if ($jadwal->status != 2) {
                                    $status = 1;
                                }
                            }
                        }
                        //temp test data
                        //$status = 1;
                    @endphp
                    <p>Status : @switch($status)
                            @case(0)
                                Belum Dimulai
                            @break
                            @case(1)
                                Sedang Berlangsung
                            <form action="{{ url('berinilai') }}" method="post">
                                @csrf
                                <input type="number" class="form-control" name="nilai" min="0" max="100"
                                    value=@if ($detail->nilai == null) 0
                                @else
                                    {{ $detail->nilai }} @endif>
                                        <input type="hidden" name="idundangan" value="{{ $idundangan }}">
                                        <input type="hidden" name="idmahasiswa" value="{{ $mahasiswa->idmahasiswa }}">
                                        <a data-toggle="modal" data-target="#nilaimodal" class="btn btn-success mt-3 text-white">Beri Nilai</a>
                                        <div class="modal fade" id="nilaimodal" tabindex="-1" role="dialog"
                                            aria-labelledby="nilaimodallabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="nilaimodal">Peringatan!</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Nilai yang diberikan tidak dapat diubah kembali,
                                                        Harap pastikan kembali nilai yang akan diberikan!
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                                                        <button type="submit" class="btn btn-success">Beri Nilai</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </form>
                        @break
                        @case(2)
                            Selesai
                            <input type="number" class="form-control" name="nilai" min="0" max="100"
                                    disabled value={{ $detail->nilai }}>
                        @break
                    @endswitch
                    </p>
            </div>
        </div>
    </div>
@endsection
