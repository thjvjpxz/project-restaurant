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
    * {
      overflow: hidden;
    }

    .nav-main {
      list-style: none;
    }

    .nav-main a:hover {
      color: #fff !important;
    }

    .active {
      color: #fff !important;
    }
  </style>
</head>

<body>
  <div class="container-fluid vh-100">
    <div class="row h-100">
      <div class="col-md-2" style="background-color: #474f89">
        <div class="d-flex justify-content-center py-3">
          <span class="fs-3 fw-bold text-white">ADMIN</span>
        </div>
        <nav class="row justify-content-center">
          <ul class="col-md-9 d-flex flex-column align-items-center">
            <li class="nav-main fs-5"><a
                class="text-decoration-none text-white-50 nav-link {{ request()->is('admin/tables') ? 'active' : '' }}"
                href="{{ route('tables.index') }}">Table</a></li>
            <li class="nav-main fs-5"><a
                class="text-decoration-none text-white-50 nav-link {{ request()->is('admin/dishes') ? 'active' : '' }}"
                href="{{ route('dishes.index') }}">Dish</a></li>
            <li class="nav-main fs-5"><a
                class="text-decoration-none text-white-50 nav-link {{ request()->is('admin/categories') ? 'active' : '' }}"
                href="{{ route('categories.index') }}">Category</a></li>
            <li class="nav-main fs-5"><a
                class="text-decoration-none text-white-50 nav-link {{ request()->is('admin/orders') ? 'active' : '' }}"
                href="{{ route('orders.index') }}">Order</a></li>
            <li class="nav-main fs-5"><a class="text-decoration-none text-white-50 nav-link"
                href="{{ route('cashier.index') }}">Go
                home</a></li>
          </ul>
        </nav>
      </div>
      <div class="col-md-10 position-relative">
        <div class="row bg-white border-bottom mb-5">
          <div class="col-md-6">
            <div class="d-flex align-items-center gap-3">
              <div class="ms-4">
                <span><i class="bi bi-list fs-1"></i></span>
              </div>
              <div class="input-group w-50">
                <span class="input-group-text px-2 py-1">
                  <a href=""><i class="bi bi-search"></i></a>
                </span>
                <input type="text" class="form-control ps-2" placeholder="Keyword">
              </div>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-center justify-content-end ">
            <div style="height: 40px; width: 40px;" class="rounded rounded-circle bg-danger me-4"></div>
          </div>
        </div>

        <div>
          {{-- main content --}}
          <div class="col-md-8 mx-auto">
            @if (session()->has('success'))
              <div class="alert alert-success mt-2 col-md-7 mx-auto">{{ session('success') }}</div>
            @endif
            @yield('content')
          </div>
        </div>

        <footer class="position-absolute bottom-0 bg-white py-3 text-center w-100 border-top">
          @coppyright NKT
        </footer>
      </div>
    </div>
  </div>
</body>

</html>
