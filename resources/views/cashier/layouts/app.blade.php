<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title_page')</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <script src="{{ asset('js/jquery.min.js') }}"></script>

  <style>
    /* * {
      overflow: hidden;
    } */

    * {
      list-style: none;
    }

    #app {
        padding-left: 0;
    }

    .nav__hover {
      color: #000 !important;
      text-decoration: none;
      font-weight: bold;
      transition: 0.1s;
    }

    .nav__hover:hover {
      background-color: #FC0254 !important;
    }
  </style>
</head>

<body>
  <div id="app" class="container position-relative border-2 border-start border-end vh-100">
    <header class="row mt-2">
      {{-- img --}}
      <div class="d-flex justify-content-center">
        <a href="">
          <img src="{{ asset('/logo.png') }}" alt="">
        </a>
      </div>

      <nav class="d-flex justify-content-center align-items-center mt-3">
        <ul class="d-flex mb-0 ps-0 border-top border-2 border-bottom">
          <li><a href="" class="nav__hover px-3 py-2 border-2 border-start fs-4 ">Trang chủ</a></li>
          <li><a href="{{ route('tables.index') }}" class="nav__hover px-3 py-2 border-2 border-start fs-4 ">Quản trị</a>
          </li>
          <li><a href="" class="nav__hover px-3 py-2 border-2 border-start fs-4 border-end">Liên hệ</a></li>
        </ul>
      </nav>
    </header>

    <main class="py-4">
      @if (session()->has('success'))
        <div class="alert alert-success mt-2 col-md-7 mx-auto">{{ session('success') }}</div>
      @endif
      @yield('content')
    </main>

    <footer class="position-absolute bottom-0 border-top border-2 w-100 text-center py-3">
        <span>@coppyright NKT</span>
    </footer>
  </div>
</body>

</html>
