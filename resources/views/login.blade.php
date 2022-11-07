<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidang IAIN Padangsidimpuan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: url("image/assets/bg_kampus.png");
            background-position: left bottom;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: auto 240px;
            background-color: rgba(0, 191, 255);
            background-blend-mode: screen;
            width: 98vw;
        }
    </style>
</head>

<body>
    <div class="row" style="margin-top:20vh">
        <div class="col-8 text-center mt-3">
            <h1 class="text-white font-weight-bolder display-4">Selamat Datang</h1>
            <h1 class="text-white">Website Sidang</h1>
            <h3 class="text-white">IAIN PADANGSIDIMPUAN</h3>
            <img src="image/assets/logo_iain.png" alt="IAIN PADANGSIDIMPUAN">
        </div>
        <div class="col-4 mt-5">
            <div class="container bg-light border border-3 border-white rounded rounded-lg p-3">
                <form action="{{ url('/login') }}" method="post" style="">
                    @csrf
                    <div class="form-group" <label for="email">Email:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="name@example.com" name="email" autofocus required value="{{ old('email') }}">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Password">Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>
