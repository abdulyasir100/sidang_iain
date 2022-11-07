@extends('layout.layoutadminprodi')
@section('title', 'Beranda Admin Prodi')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Status</th>
                        <th class="text-center">Undang</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($dosen as $d)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->nip }}</td>
                            <td>
                                <p style="@if (is_null($d->status)) color:green;
                                @else @if ($d->id_mahasiswa == $data['idmahasiswa']) color:red;
                                @else color:green; @endif @endif">
                                    @php
                                        if ($d->id_mahasiswa == $data['idmahasiswa']) {
                                            echo 'Tidak Tersedia';
                                        } else {
                                            echo 'Tersedia';
                                        }
                                    @endphp
                                </p>
                            </td>
                            <td>
                                @if (is_null($d->status))
                                    <form class="text-center" action="{{ url('undang') }}" method="post">
                                        @csrf
                                        <span class="btn btn-success text-white" data-toggle="modal"
                                            data-target="#dosenmodal1">Undang</span>
                                        <input type="hidden" name="idmahasiswa" value="{{ $data['idmahasiswa'] }}">
                                        <input type="hidden" name="iddosen" value="{{ $d->idAktor }}">
                                        <input type="hidden" name="tempat" value="{{ $data['tempat'] }}">
                                        <input type="hidden" name="tanggal" value={{ $data['jadwal'] }}>
                                        <div class="modal fade" id="dosenmodal1" tabindex="-1" role="dialog"
                                            aria-labelledby="dosenmodallabel1" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="dosenmodal1">Peringatan!</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin mengirim undangan kepada dosen berikut?<br>
                                                        Undangan akan dikirim melalui Email dan tidak dapat di<i>undo</i>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a class="btn btn-danger text-white"
                                                            data-dismiss="modal">Kembali</a>
                                                        <button type="submit" class="btn btn-success">Undang</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    @if ($d->id_mahasiswa == $data['idmahasiswa'])
                                        <p class="text-center">-</p>
                                    @else
                                        <form class="text-center" action="{{ url('undang') }}" method="post">
                                            @csrf
                                            <span class="btn btn-success text-white" data-toggle="modal"
                                                data-target="#dosenmodal2">Undang</span>
                                            <input type="hidden" name="idmahasiswa" value="{{ $data['idmahasiswa'] }}">
                                            <input type="hidden" name="iddosen" value="{{ $d->idAktor }}">
                                            <input type="hidden" name="tempat" value="{{ $data['tempat'] }}">
                                            <input type="hidden" name="tanggal" value={{ $data['jadwal'] }}>
                                            <div class="modal fade" id="dosenmodal2" tabindex="-1" role="dialog"
                                                aria-labelledby="dosenmodallabel2" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="dosenmodal2">Peringatan!</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin mengirim undangan kepada dosen
                                                            berikut?<br>
                                                            Undangan akan dikirim melalui Email dan tidak dapat
                                                            di<i>undo</i>.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a class="btn btn-danger text-white"
                                                                data-dismiss="modal">Kembali</a>
                                                            <button type="submit" class="btn btn-success">Undang</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
