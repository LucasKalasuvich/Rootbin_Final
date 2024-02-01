<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="shortcut icon" href="{{ asset('picture/ramsay.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
</head>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="card fat">
                        <div class="card-body">
                            <div class="card-left">
                                <div class="card-top-header">
                                    <img src="{{ asset('picture/ramsay.png') }}" alt="">
                                    <h2>Rootbin</h2>
                                </div>
                                <p>Welcome Back, Please login to your account.</p>
                                <form method="POST" action="{{ route('login') }}" class="my-login-validation"
                                    novalidate="">
                                    @csrf
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="text">Nomor Induk Kependudukan</label>
                                        <input class="form-control @error('nik') is-invalid @enderror" id="nik"
                                            type="text" placeholder="NIK" name="nik" value="{{ old('nik') }}"
                                            required autocomplete="nik" autofocus />
                                        @error('nik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="password">Password

                                        </label>
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            id="password" type="password" placeholder="password" name="password"
                                            required autocomplete="current-password" />

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="forgot_password">
                                        <a href="forgot.html">
                                            Forgot Password?
                                        </a>
                                    </div>
                                    <div class="btn-submit">
                                        <button type="submit" class="btn">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="card-right">
                                <img src="{{ asset('picture/picture2.png') }}" alt="dokumen.jpg">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
