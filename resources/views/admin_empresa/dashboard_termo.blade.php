<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GERANDO</title>
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
    .hide-on-pdf {
        display: none;
    }
</style>
<div class="container mt-4" style="color: black!important;">
    <p>
        <strong>TERMO DE AUTORIZAÇÃO DE CONTRIBUIÇÃO</strong>
    </p>
    <p><strong>ID: 2024{{ $cliente->id}}</strong></p>
    <p>
        O (A) Sra. <strong>{{ $cliente->name }}</strong> (  ) CPF / (  ) RG Nº ________________, Endereço 
        <strong>{{ $cliente->rua }} - {{ $cliente->numero }}, {{ $cliente->bairro }}, {{ $cliente->cidade }}</strong>, Código de Ligação: ___________________, imóvel
        (___) próprio (___) Alugado, denominado simplesmente DOADOR; a Superintendência de Água e esgoto de
        Ituiutaba — SAE, neste ato denominado simplesmente Intermediária: A obras Sociais da
        Associação Coração acolhedor. CNPJ 29.450.986/0001-83, neste ato denominada BENEFICIÁRIA,
        tendo por base a lei municipal Nº 4800 de 11 de junho de 2021. firmam o presente termo de
        acordo da forma que se segue:
    </p>
    <p>
        I — O DOADOR autoriza a INTERMEDIÁRIA a incluir em sua conta de água e esgotos a contribuição de
        <strong>R$ {{ $cliente->valor }}</strong>, que será repassada mensalmente para a BENEFICIÁRIA, de acordo com as
        disposições contidas neste termo.
    </p>
    <p>
        <strong>PARÁGRAFO ÚNICO.</strong> Sugestões para contribuição: qualquer valor acima de R$ 1,00
    </p>
    <p>
        II - O valor total da arrecadação será repassado pela intermediária. até o dia 05 do mês
        seguinte da arrecadação, à BENEFICIÁRIA, mediante transferência bancária. A BENEFICIÁRIA expedirá,
        mensalmente, no ato de recebimento da transferência dos recursos, documentos da quitação que
        importarão em conferência e exatidão.
    </p>
    <p>
        III — A INTERMEDIÁRIA se responsabiliza tão somente a repassar a contribuição nos termos aqui
        traçados, não existindo qualquer outro vínculo entre ela e a BENEFICIÁRIA.
    </p>
    <p>
        IV - A contribuição autorizada neste ato será recebida pela INTERMEDIÁRIA por tempo
        indeterminado, a contar da assinatura deste termo, resguardado o direito do DOADOR de
        rescindi-la, manifestando-se por escrito, com antecedência mínima de 30 dias.
    </p>
    <p>
        Ituiutaba, <strong>{{ $cliente->created_at->format('d/m/Y') }}</strong>, Doador <strong>{{ $cliente->name }}</strong><br>
        Obras Sociais de Associação Coração Acolhedor
    </p>


    <div class="container p-3" style="border: 0.5px solid black; font-size: 12px!important;">
        <div class="row">
            <div class="col-md-6">
                <strong>
                    <p>VIA CLIENTE</p>
                    <p>Doador: {{ $cliente->name }}</p>
                    <p>Endereço: {{ $cliente->rua }} - {{ $cliente->numero }}, {{ $cliente->bairro }}, {{ $cliente->cidade }}</p>
                    <p>Valor: R$ {{ $cliente->valor }}</p>
                    <p>ID: 2024{{ $cliente->id}}</p>
                </strong>
            </div>
    
            <div class="col-md-6">
                <div class="info">
                    <p><strong>Associação Coração Acolhedor</strong></p>
                    <p><strong>CNPJ 29.450.986/0001-83</strong></p>
                    <p><strong>associacaocoracaoacolhedor@gmail.com</strong></p>
                    <p><strong>WhatsApp: (34) 99680-9115</strong></p>
                    <p><strong>Av. Geraldo Alves Tavares. 1991, Bairro Universitário - CEP 38.302-223 - Ituiutaba-MG</strong></p>
                </div>
            </div>
        </div>
    </div>

    </strong>
    <form action="{{ route('empresa_gerando_termo_sae', ['empresa'=>$empresa->name, 'id'=>$cliente->id ])}}" method="POST">
        @csrf
        <button type="submit" class="btn bg-gradient-primary text-white col-12 mt-3 @if (isset($isPdf) && $isPdf) hide-on-pdf @endif">GERAR TERMO SAE</button>
    </form>
    <a href="{{ route('Empresa_cadastro_cliente', ['empresa' => $empresa->name]) }}"><button type="button"
        class="btn bg-gradient-danger text-white col-12 mt-2 mb-5 @if (isset($isPdf) && $isPdf) hide-on-pdf @endif">VOLTAR</button></a>
</div>