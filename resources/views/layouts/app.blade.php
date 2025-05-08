<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Option 1: CoreUI for Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.3.1/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-PDUiPu3vDllMfrUHnurV430Qg8chPZTNhY8RUpq89lq22R3PzypXQifBpcpE1eoB" crossorigin="anonymous">

    <!-- Option 2: CoreUI PRO for Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.12.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-YVHwdj+EKSu6ocFP4DVxSkyLgrlsMf1FJPLZhInu09UMMLHWv0meKLveWYKOHgq9" crossorigin="anonymous"> -->

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        
        /* Mengubah warna latar belakang dan border pagination item yang aktif */
        .card-footer .page-item.active .page-link {
            background-color: #0f0d13;
            border-color: #0f0d13;
            color: white;
        }

        /* Menambahkan efek hover pada pagination item */
        .card-footer .page-link:hover {
            background-color: #646464;
            border-color: #646464;
        }

        /* Styling untuk pagination item yang non-aktif */
        .card-footer .page-item .page-link {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #6c757d;
        }

        /* Styling saat hover untuk pagination item non-aktif */
        .card-footer .page-item:not(.active) .page-link:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
            color: black;
        }
    </style>

  </head>
  <body class="" style="background-color: #f7c6d1;">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0">
            @include('partials.sidebar') <!-- Sidebar kamu -->
        </div>
    
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-3">
            <div class="container py-4">
                <!-- Card Besar untuk Content -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">@yield('title', 'Dashboard')</h4>
                    </div>
                    <div class="card-body">
                        @yield('content') <!-- Konten utama -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: CoreUI for Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.3.1/dist/js/coreui.bundle.min.js" integrity="sha384-8QmUFX1sl4cMveCP2+H1tyZlShMi1LeZCJJxTZeXDxOwQexlDdRLQ3O9L78gwBbe" crossorigin="anonymous"></script>

    <!-- Option 2: CoreUI PRO for Bootstrap Bundle with Popper -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.12.0/dist/js/coreui.bundle.min.js" integrity="sha384-lyJyv3HACWEj3x1TDrchCKec9B+kwP9eeoiEyDRnciadwBN/lHI99UyGTpT21WSN" crossorigin="anonymous"></script>
    -->

    <!-- Option 3: Separate Popper and CoreUI/CoreUI PRO  for Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.3.1/dist/js/coreui.min.js" integrity="sha384-Rj9po7KQz8y0hVoeRgl1LRoQcxYkHxszkpKUdatY+9b5o35FsiENOwOWwxzWfAfF" crossorigin="anonymous"></script>
    or
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.12.0/dist/js/coreui.min.js" integrity="sha384-10xOpxl2MSqyKMNc4hYakRMKvs6G7qFukud815ToVM5thj8k0+jPu8kC6LSKQ3/N" crossorigin="anonymous"></script>
    -->
  </body>
</html>

{{-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html> --}}
