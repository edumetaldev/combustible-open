<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="manifest" href="{{asset('manifest.json')}}">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://work.smarchal.com/twbscolor/4.0.0/css/051a300d72c3ecf0f1ecdbff0" rel="stylesheet" type="text/css" />
</head>
    <style type="text/css">
    .navbar {
      background-color: #051a30;
    }
    .navbar .navbar-brand {
      color: #ecf0f1;
    }
    .navbar .navbar-brand:hover,
    .navbar .navbar-brand:focus {
      color: #ecdbff;
    }
    .navbar .navbar-text {
      color: #ecf0f1;
    }
    .navbar .navbar-text a {
      color: #ecdbff;
    }
    .navbar .navbar-text a:hover,
    .navbar .navbar-text a:focus {
      color: #ecdbff;
    }
    .navbar .navbar-nav .nav-link {
      color: #ecf0f1;
      border-radius: .25rem;
      margin: 0 0.25em;
    }
    .navbar .navbar-nav .nav-link:not(.disabled):hover,
    .navbar .navbar-nav .nav-link:not(.disabled):focus {
      color: #ecdbff;
    }
    .navbar .navbar-nav .nav-item.active .nav-link,
    .navbar .navbar-nav .nav-item.active .nav-link:hover,
    .navbar .navbar-nav .nav-item.active .nav-link:focus,
    .navbar .navbar-nav .nav-item.show .nav-link,
    .navbar .navbar-nav .nav-item.show .nav-link:hover,
    .navbar .navbar-nav .nav-item.show .nav-link:focus {
      color: #ecdbff;
      background-color: #0d72c3;
    }
    .navbar .navbar-toggle {
      border-color: #0d72c3;
    }
    .navbar .navbar-toggle:hover,
    .navbar .navbar-toggle:focus {
      background-color: #0d72c3;
    }
    .navbar .navbar-toggle .navbar-toggler-icon {
      color: #ecf0f1;
    }
    .navbar .navbar-collapse,
    .navbar .navbar-form {
      border-color: #ecf0f1;
    }
    .navbar .navbar-link {
      color: #ecf0f1;
    }
    .navbar .navbar-link:hover {
      color: #ecdbff;
    }

    @media (max-width: 575px) {
      .navbar-expand-sm .navbar-nav .show .dropdown-menu .dropdown-item {
        color: #051a30;
      }
      .navbar-expand-sm .navbar-nav .show .dropdown-menu .dropdown-item:hover,
      .navbar-expand-sm .navbar-nav .show .dropdown-menu .dropdown-item:focus {
        color: #051a30;
      }
      .navbar-expand-sm .navbar-nav .show .dropdown-menu .dropdown-item.active {
        color: #ecdbff;
        background-color: #051a30;
      }
    }

    @media (max-width: 767px) {
      .navbar-expand-md .navbar-nav .show .dropdown-menu .dropdown-item {
        color: #ecf0f1;
      }
      .navbar-expand-md .navbar-nav .show .dropdown-menu .dropdown-item:hover,
      .navbar-expand-md .navbar-nav .show .dropdown-menu .dropdown-item:focus {
        color: #ecdbff;
      }
      .navbar-expand-md .navbar-nav .show .dropdown-menu .dropdown-item.active {
        color: #ecdbff;
        background-color: #0d72c3;
      }
    }

    @media (max-width: 991px) {
      .navbar-expand-lg .navbar-nav .show .dropdown-menu .dropdown-item {
        color: #ecf0f1;
      }
      .navbar-expand-lg .navbar-nav .show .dropdown-menu .dropdown-item:hover,
      .navbar-expand-lg .navbar-nav .show .dropdown-menu .dropdown-item:focus {
        color: #ecdbff;
      }
      .navbar-expand-lg .navbar-nav .show .dropdown-menu .dropdown-item.active {
        color: #ecdbff;
        background-color: #0d72c3;
      }
    }

    @media (max-width: 1199px) {
      .navbar-expand-xl .navbar-nav .show .dropdown-menu .dropdown-item {
        color: #ecf0f1;
      }
      .navbar-expand-xl .navbar-nav .show .dropdown-menu .dropdown-item:hover,
      .navbar-expand-xl .navbar-nav .show .dropdown-menu .dropdown-item:focus {
        color: #ecdbff;
      }
      .navbar-expand-xl .navbar-nav .show .dropdown-menu .dropdown-item.active {
        color: #ecdbff;
        background-color: #0d72c3;
      }
    }

    .navbar-expand .navbar-nav .show .dropdown-menu .dropdown-item {
      color: #ecf0f1;
    }
    .navbar-expand .navbar-nav .show .dropdown-menu .dropdown-item:hover,
    .navbar-expand .navbar-nav .show .dropdown-menu .dropdown-item:focus {
      color: #ecdbff;
    }
    .navbar-expand .navbar-nav .show .dropdown-menu .dropdown-item.active {
      color: #ecdbff;
      background-color: #0d72c3;
    }
    .fas.fa-bars {
      color:white;
    }
    </style>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel menuAzul sombra transition">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <i class="fas fa-bars fa-2x"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    @guest
                    @else
                    <ul class="navbar-nav mr-auto">
                      @if(Auth()->user()->rol == 'administrador')
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('estaciones') }}">{{ __('Estaciones') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('usuarios') }}">{{ __('Usuarios') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('cuentacorriente') }}">{{ __('Cta. Cte.') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('reportes') }}">{{ __('Reportes') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('consumo') }}">{{ __('Consumo') }}</a>
                      </li>
                      @endif
                      @if(Auth()->user()->rol == 'expendedor')
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('consumo') }}">{{ __('Consumo') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('expendedor/reportes') }}">{{ __('Reportes') }}</a>
                      </li>
                      @endif
                      @if(Auth()->user()->rol == 'cuenta_principal')
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('micuenta',Auth()->user()->id) }}">{{ __('Mi Cuenta') }}</a>
                      </li>
                      @endif

                      @if(Auth()->user()->rol == 'visor_cuentas')
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('cuentacorriente') }}">{{ __('Cta. Cte.') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ url('reportes') }}">{{ __('Reportes') }}</a>
                      </li>
                      @endif


                    </ul>
                    @endguest
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Acceder') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  DNI:  {{ Auth::user()->dni }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="background-color: #051a30;color:white">
                                    <a class="dropdown-item" href="{{ route('logout') }}" style="background-color: #051a30; color:white"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('cambiarclave') }}" style="background-color: #051a30; color:white">
                                        {{ __('Cambiar Contraseña') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
</html>
@yield('js')