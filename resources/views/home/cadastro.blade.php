<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Cadastro</title>
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
  <body>
    <style>
        .container {
            margin-top: 10%;
        }

        .input-icon {
            font-size: 1.25rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #007BFF;
            border-color: #007BFF;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form action="{{ route('add_cadastro') }}" method="POST" class="p-4 p-md-5 border rounded-3">
                    @csrf
                    <div class="text-center" style="margin-bottom: 50px;">
                        <img src="{{ asset('img/logo2.png') }}" class="w-75" alt="Logo">
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success text-center p-5 shadow-lg rounded">
                            <i class="fas fa-check-circle fa-3x"></i>
                            <p class="font-weight-bold mt-3 h4">{{ session('success') }}</p>
                            <p class="mb-4">Você pode fazer login agora.</p>
                            <a href="{{ route('home_login') }}" class="btn btn-success btn-lg btn-block">Fazer login</a>
                        </div>
                    @endif
                

                    @if(session('error'))
                        <div class="alert alert-danger text-center p-5 shadow-lg rounded">
                            <i class="fa-solid fa-triangle-exclamation fa-3x"></i>
                            <p class="font-weight-bold mt-3 h4">{{ session('error') }}</p>
                            <p class="mb-4">tente novamente em instantes.</p>
                        </div>
                    @endif

                    <div class="form-floating">
                        <div class="input-group">
                            <span class="input-group-text input-icon bg-gradient-danger text-white"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="inputnome" name="user_name" placeholder="Nome completo" style="padding: 3%;">
                        </div>
                    </div>

                    <div class="form-floating">
                        <div class="input-group">
                            <span class="input-group-text input-icon bg-gradient-danger text-white"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="inputemail" name="user_email" placeholder="E-mail" style="padding: 3%;">
                        </div>
                    </div>

                    <div class="form-floating">
                        <div class="input-group">
                            <span class="input-group-text input-icon bg-gradient-danger text-white"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="inputpassword" name="user_password" placeholder="Password" style="padding: 3%;">
                        </div>
                    </div>

                    <button class="btn bg-gradient-danger text-white col-12 mb-2">CADASTRAR</button>
                    <a href="{{ URL::route('home_login') }}"><button type="button" class="btn bg-gradient-danger text-white col-12">VOLTAR</button></a>
                </form>
                
            </div>
        </div>
    </div>
    
    
    

  <!--   Core   -->
  <script src="{{ asset('assets/js/plugins/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

  </body>
</html>