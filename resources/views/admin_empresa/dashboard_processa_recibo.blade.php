<!DOCTYPE html>

<html>

<head>
    <link href="{{ asset('assets/img/brand/favicon.png') }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/b4b9e9fb10.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .receipt {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #38414A;
            border: 1px solid #ccc;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .info {
            text-align: right;
        }

        .details {
            margin-top: 10px;
            border-top: 1px solid #ccc;
            padding: 10px 0;
        }

        .total {
            text-align: center;
            margin-top: 20px;
        }

        .hide-on-pdf {
            display: none;
        }
    </style>
</head>

<body>
    <form action="{{ route('empresa_cadastro_emitindo_recibo', ['empresa' => $empresa->name, 'id' => $cliente->id]) }}"
        method="POST">
        @csrf
        <div class="receipt" style="background-color: #38414A; color: white;">
            <div class="header">
                <img class="logo"
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logos_empresas/' . $logo))) }}">
                <div class="info">
                    <p><strong>Associação Coração Acolhedor</strong></p>
                    <p><strong>CNPJ 29.450.986/0001-83</strong></p>
                    <p><strong>(34) 3268-1758</strong></p>
                    <p><strong>(34) 99680-9115</strong></p>
                    <p><strong>Rua 22 com 23 e 25, n° 1329 - Ituiutaba-MG</strong></p>
                </div>
            </div>
            <h1 class="header text-white">RECIBO</h1>
            <div class="details">
                <p style="font-size: 30px;"><strong>Recebemos de:<br></strong> {{ $cliente->name }}</p>
                <p><strong>Endereço:</strong>
                    {{ $cliente->bairro . ' - ' . $cliente->rua . ' - ' . $cliente->numero . ' - ' . $cliente->cidade }}</p>
                <p><strong>Celular:</strong> {{ $cliente->celular }}</p>
                <p><strong>Data/Hora:</strong> {{ $data }}</p>
            </div>
            <div class="details">
                <p><strong>Referente a:</strong></p>
                <p>Doação</p>
                <p style="font-size: 30px;"><strong>Valor Total: R$ {{ $cliente->valor }}</strong></p>
            </div>

                <button type="submit"
                    class="btn bg-gradient-success text-white col-12 mt-2 @if (isset($isPdf) && $isPdf) hide-on-pdf @endif">GERAR
                    RECIBO</button>
                <a href="{{ route('Empresa_cadastro_cliente', ['empresa' => $empresa->name]) }}"><button type="button"
                        class="btn bg-gradient-danger text-white col-12 mt-2 @if (isset($isPdf) && $isPdf) hide-on-pdf @endif">VOLTAR</button></a>

        </div>
</body>

</html>
