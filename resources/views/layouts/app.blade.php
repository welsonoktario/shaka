<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
  @auth
    <div id="wrapper">
      @include('pasien.components.loading')
      @include('pasien.components.sidebar')
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content" style="max-height: 100vh">
          @include('pasien.components.navbar')
          @yield('content')
        </div>
      </div>
    </div>
  @endauth
  @guest
    @yield('content')
  @endguest

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

  @stack('scripts')
</body>

</html>
