@extends('layout.layoutdosen')
@section('title','Beranda Dosen')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <table class="table table-light">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Tempat</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @if ($jadwal->count() > 0)
                    @foreach ($jadwal as $j)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $j->nama }}</td>
                        <td>@php
                            $tanggaljadi = new DateTime($j->tanggal);
                            $tanggal = $tanggaljadi->format('d/m/Y');
                            $jam = $tanggaljadi->format('H:i:s');
                            echo $tanggal;
                        @endphp</td>
                        <td>{{ $jam }}</td>
                        <td>{{ $j->tempat }}</td>
                        <td><a href="{{ url('/detailjadwal/'.$j->idjadwal) }}" class="btn btn-primary btn-sm col-4">
                            Detail
                        </a></td>
                    </tr>
                    @endforeach
                    @else
                        <td  colspan="5"><p class="text-center font-weight-bold mt-3">Tidak ada jadwal yang tersedia</p></td>
                    @endif
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection