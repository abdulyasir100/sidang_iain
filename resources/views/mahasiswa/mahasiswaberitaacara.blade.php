@extends('layout.layoutmahasiswa')
@section('title','Beranda mahasiswa')
@section('content')
<div class="container">
    @if (Session::get('status')=="Gagal Sidang")
    <div class="row card text-center mt-3">
        <div class="col-12 card-body p-3">
            <span>Pendaftaran ulang sidang dapat dilakukan 2 minggu setelah sidang ini berakhir</span>
        </div>
    </div>
    @endif
    <div class="row card text-center mt-3">
        <div class="col-12 card-body p-3">
            <span>Klik Disini Untuk Mengunduh Berita Acara <a class="btn btn-success ml-3" href="{{ url('/beritaacara') }}">Unduh Berita Acara</a></span>
        </div>
    </div>
</div>
@endsection