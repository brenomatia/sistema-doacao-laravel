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
    color: #2DCEAB;
    /* Cor desejada */
  }

  .navbar-nav .nav-item .nav-link {
    color: white;
  }
</style>

<body>
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md" id="sidenav-main" style="background-color: #38414A;">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
        aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars bg-gradient-success text-white p-3 rounded"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand pt-0 mt-1" href="{{ route('index', [ 'empresa'=> $empresa->name ]) }}">
        <img src="{{ asset('logos_empresas/' . $empresa->logo) }}" class="navbar-brand-img">
      </a>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="{{ route('index', [ 'empresa'=> $empresa->name ]) }}">
                <img src="{{ asset('logos_empresas/' . $empresa->logo) }}">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('Empresa_dashboard', ['empresa'=>$empresa->name]) }}">
              <i class="fa-solid fa-house"></i> Inicio
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('Empresa_cadastro_cliente', ['empresa' => $empresa->name ]) }}">
              <i class="fa-solid fa-user-plus"></i> Cadastrar cliente
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('empresa_areceber', ['empresa' => $empresa->name ]) }}">
              <i class="fa-solid fa-filter-circle-dollar"></i> A receber
            </a>
          </li>

          @if(Auth::user()->tipo === 'admin' || Auth::user()->tipo === 'dev')

          <li class="nav-item mt-3 mb-3 text-center text-gray">ADMINISTRATIVO</li>

          <li class="nav-item active">
            <a class="nav-link" href="{{ route('empresa_mesatual', ['empresa' => $empresa->name ]) }}">
              <i class="fa-solid fa-calendar-check"></i>
        
                @php
                $nomeMesIngles = \Carbon\Carbon::now()->formatLocalized('%B');
                
                $traducaoMeses = [
                    'January'   => 'Janeiro',
                    'February'  => 'Fevereiro',
                    'March'     => 'Março',
                    'April'     => 'Abril',
                    'May'       => 'Maio',
                    'June'      => 'Junho',
                    'July'      => 'Julho',
                    'August'    => 'Agosto',
                    'September' => 'Setembro',
                    'October'   => 'Outubro',
                    'November'  => 'Novembro',
                    'December'  => 'Dezembro',
                ];
            
                $nomeMes = $traducaoMeses[$nomeMesIngles];
            @endphp
            
        
                O mês de {{ $nomeMes }}
            </a>
        </li>
        

          <li class="nav-item active">
            <a class="nav-link" href="{{ route('empresa_metricas', ['empresa' => $empresa->name ]) }}">
              <i class="fa-solid fa-square-poll-vertical"></i> Métricas
            </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="{{ route('empresa_usuarios', ['empresa' => $empresa->name ]) }}">
              <i class="fa-solid fa-user-plus"></i> Usuários
            </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="{{ route('empresa_baixar', ['empresa' => $empresa->name ]) }}">
              <i class="fa-solid fa-receipt"></i> Baixar recibos
            </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="{{ route('empresa_logs', ['empresa' => $empresa->name ]) }}">
              <i class="fa-solid fa-clipboard-list"></i> Produtividade
            </a>
          </li>

          @endif

          <li class="nav-item">
            <a class="nav-link" href="{{ route('Empresa_logout', ['empresa' => $empresa->name ]) }}">
              <div class="btn bg-gradient-success col-12 text-white d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-right-from-bracket"></i>&nbsp;SAIR
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="main-content">






    <!-- Navbar -->
    <nav class="navbar navbar-expand-md" style="background-color: #38414A;">

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item dropdown justify-content-center">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <i class="fa-solid fa-gears" style="color: #2DCEAB; font-size: 20px;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('Empresa_logout', ['empresa' => $empresa->name ]) }}">
                <i class="fa-solid fa-right-from-bracket" style="color: #2DCEAB;"></i>
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