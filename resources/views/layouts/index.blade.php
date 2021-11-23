<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title')</title>
    <meta name="msapplication-TileColor" content="#206bc4" />
    <meta name="theme-color" content="#206bc4" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <link rel="icon" href="{{ asset('img/logo-white.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('img/logo-white.png') }}" type="image/x-icon" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    @yield('custom-css')
</head>

<body class="antialiased">
    <div class="wrapper">
        @include('layouts.navbar')
        <div class="page-wrapper">
            <div class="container-xl">
                @yield('header')
            </div>
            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
    @yield('modal')

    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>    
    @yield('custom-js')
</body>

</html>
