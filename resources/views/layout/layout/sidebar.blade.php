<!doctype html>
<html lang="en">
<head>
    <title>{{ $title }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .logo{
            max-width: 150px;
            max-height: 150px;
        }
        .foot{
            max-width: 100%;
            height: 50px;
            background-color: brown;
            color: white;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light col-2" style="min-height: calc(100vh - 50px)">
            <a href="/" class="col-12 d-flex justify-content-center align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img class="logo" alt="Logo Empat Bersaudara" src="{{ asset('/images/assets/logo-empat-bersaudara.png') }}"></img>
            </a>
            <hr>
            <ul class="nav nav-pills mb-auto flex-column">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link @if($title!='Tambah Produk'&&$title!='Tambah Stok'&&
                    $title!='Tambah Sales'&&$title!='Input Sales'&&$title!='Tambah Barang Keluar'&&$title!='Input Pengeluaran'
                    &&$title!='Tambah Diskon'&&$title!='Tambah Hutang') active @else link-dark @endif" @if($title!='Tambah Produk'
                    &&$title!='Tambah Stok'&&$title!='Tambah Sales'&&$title!='Input Sales'&&$title!='Tambah Barang Keluar' 
                    &&$title!='Input Pengeluaran'&&$title!='Tambah Diskon'&&$title!='Tambah Hutang') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home"></use>
                        </svg>
                        Beranda
                    </a>
                </li>
                @if (\Session::get('tipe')=='admin')
                <hr>
                <li>
                    <a href="{{ url('/create') }}" class="nav-link @if($title=='Tambah Produk') active @else link-dark @endif" @if($title=='Tambah Produk') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#speedometer2"></use>
                        </svg>
                        Tambah Produk
                    </a>
                </li>
                <li>
                    <a href="{{ url('/inputdiskon') }}" class="nav-link @if($title=='Tambah Diskon') active @else link-dark @endif" @if($title=='Tambah Diskon') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#speedometer2"></use>
                        </svg>
                        Tambah Diskon
                    </a>
                </li>
                <li>
                    <a href="{{ url('/input') }}" class="nav-link @if($title=='Tambah Stok') active @else link-dark @endif" @if($title=='Tambah Stok') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#table"></use>
                        </svg>
                        Tambah Stok
                    </a>
                </li>
                <li>
                    <a href="{{ url('/pelangganbaru') }}" class="nav-link @if($title=='Tambah Sales') active @else link-dark @endif" @if($title=='Tambah Sales') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#grid"></use>
                        </svg>
                        Tambah Sales
                    </a>
                </li>
                <li>
                    <a href="{{ url('/tambahbarangkeluar') }}" class="nav-link @if($title=='Tambah Barang Keluar') active @else link-dark @endif" @if($title=='Tambah Barang Keluar') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#grid"></use>
                        </svg>
                        Barang Keluar
                    </a>
                </li>
                <li>
                    <a href="{{ url('/inputsales') }}" class="nav-link @if($title=='Input Sales') active @else link-dark @endif" @if($title=='Input Sales') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#grid"></use>
                        </svg>
                        Input Penjualan
                    </a>
                </li>
                <li>
                    <a href="{{ url('/inputpengeluaran') }}" class="nav-link @if($title=='Input Pengeluaran') active @else link-dark @endif" @if($title=='Input Pengeluaran') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#grid"></use>
                        </svg>
                        Input Pengeluaran
                    </a>
                </li>
                <li>
                    <a href="{{ url('/hutang') }}" class="nav-link @if($title=='Tambah Hutang') active @else link-dark @endif" @if($title=='Tambah Hutang') aria-current="page" @endif>
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#grid"></use>
                        </svg>
                        Tambah Hutang
                    </a>
                </li>
                @endif
                <hr>
                <li>
                    <a href="{{ url('/logout') }}" class="nav-link link-dark">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#table"></use>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>
<footer>
    <div class="foot d-flex justify-content-center align-content-center mt-4 py-3">
        <p>Contact : 085277985537</p>
    </div>
</footer>
</html>
