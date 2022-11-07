<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Beranda Dosen')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/c1452f204d.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="collapse navbar-collapse pt-3" id="navbarSupportedContent" style="display: unset !important;">
            <ul class="nav nav-pills mr-auto">
                <li class="nav-item active">
                    <a class="navbar-brand" href="{{ url('/berandadosen') }}">
                        <img src="{{ asset('image/assets/logo_iain.png') }}" height="40"
                            class="d-inline-block align-top" style="float:left" alt="">
                        <h3 style="float:right">IAIN PADANGSIDIMPUAN</h3>
                    </a>
                </li>
                <li class="nav-item dropdown ml-auto">
                    <a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                    </a>
                    @php
                        $totalnotif = $undangan->count();
                    @endphp
                    <ul class="dropdown-menu">
                        <li class="head text-light bg-dark">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <span>Notifikasi @if ($totalnotif>0)
                                       ( {{ $totalnotif }} )
                                    @endif</span>
                                </div>
                        </li>
                        @if ($totalnotif>0)
                        @php
                        //limit notification
                            $i=0;
                            $limit = 5;
                        @endphp
                        @foreach ($undangan as $undang)
                        @if ($i < $limit)
                        <li class="notification-box">
                            <div class="row ml-3">
                                <a href="{{ url('undangansidang/'.$undang->idundangan) }}" class="pe-auto">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <strong class="text-info">{{ $undang->nama }}</strong>
                                        <div>
                                            Anda telah diundang sebagai dosen penguji
                                        </div>
                                        <small class="text-info">Klik untuk lihat detail</small><br>
                                        <small class="text-warning">{{ $undang->created_at }}</small>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @else
                            @php
                                break;
                            @endphp
                        @endif
                        @endforeach
                        @else
                        <li class="notification-box">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <p class="text-center mt-3">Tidak ada undangan</p>
                                </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    Anda login sebagai {{ Session::get('nama') }}
                    <a class="btn btn-danger mb-1 ml-1" href="{{ url('/logout') }}">Logout</a>
                </li>

            </ul>
        </div>
    </nav>
    <div class="row">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light col-2" style="min-height: calc(100vh - 50px)">
            <ul class="nav nav-pills mb-auto flex-column">
                <li class="nav-item">
                    <a class="nav-link link-dark text-dark" href="{{ url('/berandadosen') }}">
                        <svg class="bi me-2" width="16" height="16">
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <a class="nav-link link-dark">
                        <svg class="bi me-2" width="16" height="16">
                        </svg>
                        Skripsi
                    </a>
                </li>
                <li>
                    <a class="nav-link link-dark">
                        <svg class="bi me-2" width="16" height="16">
                        </svg>
                        Sidang
                    </a>
                </li>
                <li>
                    <a class="nav-link link-dark text-dark" href="{{ url('/undangandosen') }}">
                        <svg class="bi me-2" width="16" height="16">
                        </svg>
                        Undangan
                    </a>
                </li>
                <hr>
                <li>
                    <a href="{{ url('/logout') }}" class="nav-link link-dark text-dark">
                        <svg class="bi me-2" width="16" height="16">
                        </svg>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-10">
            @yield('content')
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script>
      $("a.nav-link").hover(function(){
        $(this).css("background-color", "#0390fc");
        }, function(){
        $(this).css("background-color", "transparent");
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>
<script>
    $(document).ready(function() {

        var down = false;

        $('#bell').click(function(e) {
            var color = $(this).text();
            if (down) {

                $('#box').css('height', '0px');
                $('#box').css('opacity', '0');
                down = false;
            } else {
                $('#box').css('height', 'auto');
                $('#box').css('opacity', '1');
                down = true;
            }
        });

    });
</script>

</html>
