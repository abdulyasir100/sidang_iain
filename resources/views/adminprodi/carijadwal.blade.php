@extends('layout.layoutadminprodi')
@section('title','Beranda Admin Prodi')
@section('content')

    <div class="container mt-4">
        <div class="row">
            <form action="{{ url('/caridosen') }}" method="get">
                @csrf
                <div id="mhs-info" class="bg-light rounded p-4 font-weight-bold">
                    <p>Nama : {{ $mahasiswa->nama }}</p>
                    <p>Nim : {{ $mahasiswa->nim }}</p>
                    <p>Semester : {{ $mahasiswa->semester }}</p>
                    <p>Fakultas : {{ $mahasiswa->fakultas }}</p>
                    <p>Jurusan : {{ $mahasiswa->jurusan }}</p>
                    <p>Prodi : {{ $mahasiswa->prodi }}</p>
                    <p>Judul Skripsi : {{ $mahasiswa->judul_skripsi }}</p>
                </div>
                <div class="bg-light mt-3 rounded p-4 form-group">
                    <span class="col-10">
                        <div>
                            <label for="jadwal">Jadwal Sidang:</label>
                            @if(isset($jadwal))
                                @php
                                    //format tanggal
                                    $tanggal = strtotime($jadwal->tanggal);
                                    $tanggaljadi = date('Y-m-d\Th:m:s', $tanggal);
                                @endphp
                            @endif
                            <input id="jadwal" class="form-date col-6" type="datetime-local" name="jadwal" @if(isset($jadwal)) value="{{ $tanggaljadi }}"@endif autocomplete="off" required>
                        </div>
                        <div class="mt-2">
                            <label for="tempat">Tempat Sidang:</label>
                            <input id="tempat" class="col-6"type="text" name="tempat" @if(isset($jadwal)) value="{{ $jadwal->tempat }}"@endif placeholder="Ex : Gedung B Ruang 5" required>
                        </div>
                    </span>
                    <button type="submit" class="btn btn-success col-2 float-right">Cari</button>
                    <input type="hidden" name="idmahasiswa" value="{{ $mahasiswa->idmahasiswa }}">
                </div>
            </form>
        </div>
    </div>
@endsection