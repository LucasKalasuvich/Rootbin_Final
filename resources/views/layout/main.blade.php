<!DOCTYPE html>
<html lang="en">
@php(date_default_timezone_set('Asia/Jakarta'))

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rootbin</title>
    <link rel="shortcut icon" href="{{ asset('picture/ramsay.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/navbar.css') }}">

    <!-- Styles -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Lato';
            background-color: #B6C4EE;

        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    @stack('css')
</head>

<body id="app-layout">

    @include('layout.navbar')

    {{-- <hr style=" border: none;height: 8px;color: #000000;background-color: #000000; "> --}}

    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="thumbnail">
                    <div aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <h5
                                    style="color: #102d84; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif">
                                    {{ $breadcrumb }}
                                </h5>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            @if (Request::path() == 'dashboard')
                <div class="col-sm-4 d-flex justify-content-end">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="caption">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn" style="background-color: #102d84"><a
                                                href="#" class="text-light text-decoration-none">
                                                <i class="bi bi-person float-right"></i>
                                                ({{ auth()->user()->name }})</a></button>
                                        <button type="button" class="btn btn-primary"
                                            style="background-color: #102d84"><a href="#"
                                                class="text-light text-decoration-none">*{{ auth()->user()->role }}</a></button>
                                        <a href="{{ route('logout') }}"
                                            class="btn btn-primary text-light text-decoration-none"
                                            style="background-color: #102d84">Log
                                            Out</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
        </div>

        @yield('content')

    </div>

    <div class="mt-5">
        @include('layout.footer')
    </div>


    <!-- JavaScripts -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <script script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/adminlte/dist/js/adminlte.js"></script>
    @stack('js')
</body>

</html>
