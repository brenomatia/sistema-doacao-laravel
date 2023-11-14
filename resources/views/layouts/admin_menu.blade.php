<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title')</title>
  <!-- Favicon -->
  <link href="{{ asset('assets/img/brand/favicon.png') }}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/b4b9e9fb10.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link href="{{ asset('assets/css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />
</head>
<style>
  /* Estilo do ícone quando o link está ativo */
.navbar-nav .nav-item.active a i {
  color: #e64d4d; /* Cor desejada */
}

</style>

<body>
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light " id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon text-white"></span>
      </button>

      <!-- Brand -->
      <a class="navbar-brand pt-0 mt-1" href="{{ route('dashboard_home') }}">
        <img src="{{ asset('img/logo2.png') }}" class="navbar-brand-img">
      </a>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="{{ route('dashboard_home') }}">
                <img src="{{ asset('img/logo2.png') }}">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('dashboard_home') }}">
              <i class="fa-solid fa-house"></i> Inicio
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('dashboard_cadastrar_empresa') }}">
              <i class="fa-solid fa-building"></i> Cadastrar empresa
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">
              <div class="btn bg-gradient-danger col-12 text-white d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-right-from-bracket"></i>
              </div>
            </a>
          </li>
        </ul>
        
      </div>
    </div>
  </nav>
  <div class="main-content">






    <!-- Navbar -->
    <nav class="navbar navbar-expand-md">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item dropdown justify-content-center">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-gears" style="color: #e64d4d; font-size: 20px;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}">
                <i class="fa-solid fa-right-from-bracket" style="color: #e64d4d;"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>

        </ul>
      </div>
    </nav>
    <!-- End Navbar -->









    <!-- Header -->
    <div class="header">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">


            @yield('content')



          </div>
        </div>
      </div>
    </div>
  </div>




  <!--   Core   -->
  <script src="{{ asset('assets/js/plugins/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!--   Optional JS   -->
  <script src="{{ asset('assets/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
  <!--   Argon JS   -->
  <script src="{{ asset('assets/js/argon-dashboard.min.js?v=1.1.2') }}"></script>

</body>

</html>