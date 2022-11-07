<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Beranda Admin Prodi')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/c1452f204d.js" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <a class="navbar-brand" href="{{ url('/berandaadminprodi') }}">
    <img src="{{asset('image/assets/logo_iain.png')}}" height="40" class="d-inline-block align-top" style="float:left"alt="">
    <h3 style="padding-left:10px float:right">IAIN PADANGSIDIMPUAN</h3>
  </a>
  <div class="text-white ms-auto">
  Anda login sebagai {{Session::get('nama')}}
  <a href="{{ url('/logout') }}"><button type="button" class="btn btn-danger mb-1 ml-1">Logout</button></a>
  </div>
  </nav>
  <div class="row">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light col-2" style="min-height: calc(100vh - 50px)">
        <ul class="nav nav-pills mb-auto flex-column">
            <li class="nav-item">
                <a class="nav-link link-dark text-dark" href="{{ url('/berandaadminprodi') }}">
                    <svg class="bi me-2" width="16" height="16">
                    </svg>
                    Beranda
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
</html>