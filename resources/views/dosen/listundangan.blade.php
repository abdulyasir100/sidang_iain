@extends('layout.layoutdosen')
@section('title', 'Daftar Undangan')
@section('content')
    <div class="container mt-4">
        <div class="row">
            @if (count($undangan)>0)
            @php
                $i=0;
            @endphp
            @foreach ($undangan as $u)
            <div class="col-5 rounded bg-white p-4 mr-2 ml-2">
                @php
                    $tanggaljadi = new DateTime($u->tanggal);
                    $tanggal = $tanggaljadi->format('d/m/Y');
                    $jam = $tanggaljadi->format('H:i:s');
                @endphp
                <p>Tempat : {{ $u->tempat }}</p>
                <p>Tanggal : {{ $tanggal }}</p>
                <p>Jam : {{ $jam }}</p>
                <hr>
                <div>
                    <a href="{{ url('undangansidang/'.$u->idundangan) }}" class="btn btn-success">View</a>
                </div>

            </div>
            @endforeach
            @else
            <h5 class="text-center col-12">Tidak ada undangan ditemukan</h5>
            @endif
        </div>
    </div>
@endsection
