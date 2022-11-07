@extends('layout.layoutadminfakultas')
@section('title', 'Beranda Admin Fakultas')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>Nama File</th>
                        <th>Lihat File</th>
                        <th>Terima/Tolak</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($mahasiswa->count() > 0)
                        @foreach ($mahasiswa as $mhs)
                            <tr>
                                <td>{{ $mhs->nama }}</td>
                                <td>{{ $mhs->lokasi . '.pdf' }}</td>
                                <td><a href="{{ url('/show/' . $mhs->lokasi) }}" class="btn btn-primary">View</a></td>
                                <td><a href="#accmodal" data-toggle="modal" data-idfile="{{ $mhs->idfile }}"
                                        data-filetype="TERIMA" class="btn btn-success text-white btn-acc">Terima</a>
                                    <a href="#accmodal" data-toggle="modal" data-idfile="{{ $mhs->idfile }}"
                                        data-filetype="TOLAK" class="btn btn-danger text-white btn-acc">Tolak</a>
                                </td>
                            </tr>
                        @endforeach
                        <div class="modal fade" id="accmodal" tabindex="-1" role="dialog" aria-labelledby="accmodallabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="accmodal">Peringatan!</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin menerima dokumen ini?
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-danger text-white" data-dismiss="modal">Kembali</a>
                                        <a id="continue" class="btn btn-success" href="/">Terima</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <td colspan="4">
                            <p class="text-center font-weight-bold mt-3">Tidak ada file yang tersedia</p>
                        </td>
                    @endif
                </tbody>
                <script>
                    $('#accmodal').on('show.bs.modal', function(e) {
                        var idfile = $(e.relatedTarget).data('idfile');
                        var filetype = $(e.relatedTarget).data('filetype');
                        var url = "";
                        if(filetype=="TERIMA"){
                            url = "/terimaadminfakultas/"+idfile;
                            $('.modal-body').html("Apakah anda yakin ingin menerima dokumen ini?");
                            $('#continue').text("Terima");
                        }else{
                            url = "/tolakadminfakultas/"+idfile;
                            $('.modal-body').html("Apakah anda yakin ingin menolak dokumen ini?");
                            $('#continue').text("Tolak");
                        }
                        $('#continue').attr("href", url);
                    });
                </script>
            </table>
        </div>
    </div>
@endsection
