@extends('layout.layoutadminprodi')
@section('title','Beranda Admin Prodi')
@section('content')
  <div class="container mt-4">
      <div class="row">
          <h3>List Mahasiswa : </h3>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th class="text-center">Cari Jadwal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @if ($mahasiswa->count() > 0)
                    @foreach ($mahasiswa as $mhs)
                    <tr>
                        <th>
                            {{ $i++ }}
                        </th>
                        <th>
                            {{ $mhs->nama }}
                        </th>
                        <th>
                            {{ $mhs->nim }}
                        </th>
                        <th class="text-center">
                            <a href="{{ url('/carijadwal/'.$mhs->idmahasiswa) }}" class="btn btn-success btn-sm col-4"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg></a>
                        </th>
                    </tr>
                @endforeach
                    @else
                        <tr>
                            <td  colspan="4"><p class="text-center font-weight-bold mt-3">Tidak ada mahasiswa yang menunggu jadwal</p></td>
                        </tr>
                    @endif
                </tbody>
            </table>
      </div>
  </div>
@endsection