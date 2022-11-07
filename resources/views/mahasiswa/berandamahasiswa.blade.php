@extends('layout.layoutmahasiswa')
@section('title', 'Beranda mahasiswa')
@section('content')
    <style>
        .alertmodal {
            display: block;
        }

    </style>
    <div class="container mt-4">
        <div class="row mt-4">
            <div class="col-12">
                <h3>Download : </h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama File</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($download as $dl)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $dl->lokasi }}</td>
                                <td>{{ $dl->deskripsi }}</td>
                                <td><a href="{{ url('/download/' . $dl->idfile) }}" class="btn btn-success">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                @php
                    $total = 0;
                @endphp
                <form action="{{ url('upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h3>Upload: </h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nama File</th>
                                <th scope="col" class="text-center">Upload</th>
                            </tr>
                        </thead>
                        <div class="form-group">
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Transkrip Nilai Sementara</td>
                                    <td>
                                        @if (!is_null($file_mhs) && isset($file_mhs[0]))
                                            <p>{{ $file_mhs[0]->lokasi . '.pdf' }}</p>
                                        @else
                                            <p class="text-center">-</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!isset($file_mhs[0]) || $file_mhs[0]->status == 2)
                                            <input class="form-file form-control" type="file" name="t_nilai" required>
                                    </td>
                                @else
                                    @php
                                        $total++;
                                    @endphp
                                    <a href="{{ url('/show/' . $file_mhs[0]->lokasi) }}" class="btn btn-primary">View</a>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Bukti Lunas Pembayaran UKT</td>
                                    <td>
                                        @if (!is_null($file_mhs) && isset($file_mhs[1]))
                                            <p>{{ $file_mhs[1]->lokasi . '.pdf' }}</p>
                                        @else
                                            <p class="text-center">-</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!isset($file_mhs[1]) || $file_mhs[1]->status == 2)
                                            <input class="form-file form-control" type="file" name="b_ukt" required>
                                    </td>
                                @else
                                    @php
                                        $total++;
                                    @endphp
                                    <a href="{{ url('/show/' . $file_mhs[1]->lokasi) }}" class="btn btn-primary">View</a>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>PDDikti</td>
                                    <td>
                                        @if (!is_null($file_mhs) && isset($file_mhs[2]))
                                            <p>{{ $file_mhs[2]->lokasi . '.pdf' }}</p>
                                        @else
                                            <p class="text-center">-</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!isset($file_mhs[2]) || $file_mhs[2]->status == 2)
                                            <input class="form-file form-control" type="file" name="pddikti" required>
                                    </td>
                                @else
                                    @php
                                        $total++;
                                    @endphp
                                    <a href="{{ url('/show/' . $file_mhs[2]->lokasi) }}" class="btn btn-primary">View</a>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Berita Acara Ujian Komprehensif</td>
                                    <td>
                                        @if (!is_null($file_mhs) && isset($file_mhs[3]))
                                            <p>{{ $file_mhs[3]->lokasi . '.pdf' }}</p>
                                        @else
                                            <p class="text-center">-</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!isset($file_mhs[3]) || $file_mhs[3]->status == 2)
                                            <input class="form-file form-control" type="file" name="b_ujian" required>
                                    </td>
                                @else
                                    @php
                                        $total++;
                                    @endphp
                                    <a href="{{ url('/show/' . $file_mhs[3]->lokasi) }}" class="btn btn-primary">View</a>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Surat Pernyataan Keabsahan dan Kebenaran Dokumen</td>
                                    <td>
                                        @if (!is_null($file_mhs) && isset($file_mhs[4]))
                                            <p>{{ $file_mhs[4]->lokasi . '.pdf' }}</p>
                                        @else
                                            <p class="text-center">-</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!isset($file_mhs[4]) || $file_mhs[4]->status == 2)
                                            <input class="form-file form-control" type="file" name="s_dokumen" required>
                                    </td>
                                @else
                                    @php
                                        $total++;
                                    @endphp
                                    <a href="{{ url('/show/' . $file_mhs[4]->lokasi) }}" class="btn btn-primary">View</a>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Surat Pernyataan Menyusun Skripsi Sendiri</td>
                                    <td>
                                        @if (!is_null($file_mhs) && isset($file_mhs[5]))
                                            <p>{{ $file_mhs[5]->lokasi . '.pdf' }}</p>
                                        @else
                                            <p class="text-center">-</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!isset($file_mhs[5]) || $file_mhs[5]->status == 2)
                                            <input class="form-file form-control" type="file" name="s_skripsi" required>
                                    </td>
                                @else
                                    @php
                                        $total++;
                                    @endphp
                                    <a href="{{ url('/show/' . $file_mhs[5]->lokasi) }}" class="btn btn-primary">View</a>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Surat Pernyataan Pembimbing</td>
                                    <td>
                                        @if (!is_null($file_mhs) && isset($file_mhs[6]))
                                            <p>{{ $file_mhs[6]->lokasi . '.pdf' }}</p>
                                        @else
                                            <p class="text-center">-</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!isset($file_mhs[6]) || $file_mhs[6]->status == 2)
                                            <input class="form-file form-control" type="file" name="s_pembimbing" required>
                                    </td>
                                @else
                                    @php
                                        $total++;
                                    @endphp
                                    <a href="{{ url('/show/' . $file_mhs[6]->lokasi) }}" class="btn btn-primary">View</a>
                                    </td>
                                    @endif
                                </tr>
                            </tbody>
                        </div>
                    </table>
                    @if ($total < 7)
                        <span class="ml-auto mb-5 btn btn-md btn-primary float-right" data-toggle="modal"
                            data-target="#uploadmodal">Upload Semua
                            Berkas</span>
                    @endif
                    <div class="modal fade" id="uploadmodal" tabindex="-1" role="dialog"
                        aria-labelledby="uploadmodalabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadmodalabel">Peringatan!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Periksa kembali dokumen yang ingin anda Upload <br>
                                    Anda yakin ingin mengupload semua berkas?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-success">Upload Semua Berkas</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                    <script>
                        $(document).ready(function() {
                            $("#alertmodal").modal('show');
                    });
                    </script>
                    <div class="modal fade show" id="alertmodal" tabindex="-1" role="dialog"
                        aria-labelledby="alertmodalabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadmodalabel">Peringatan!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    File harus dalam bentuk PDF!
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
