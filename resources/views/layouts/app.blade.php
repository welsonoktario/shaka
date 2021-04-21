<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    @auth
        <div class="row vh-100" style="max-height: 100vh; max-width: 100vw">
            <div class="col-2">
                <div class="sticky-top">
                    @include('pasien.components.sidebar')
                </div>
            </div>
            <div class="col-10">
                @yield('content')
            </div>
        </div>
    @endauth
    @guest
        @yield('content')
    @endguest
    @yield('js')
</body>
</html>
