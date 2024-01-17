@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')


    <div class="container-fluid p-3">
        <div class="row d-flex align-items-center justify-content-center">

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-gradient-success"
                    style="border-radius: 15px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); color: white; width: 100%;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon text-white d-flex align-items-center justify-content-center rounded">
                            <i class="fa-solid fa-user-plus fa-3x"></i>
                        </div>
                        <div class="ml-auto">
                            <h4 class="card-title text-white" style="font-size: 30px;">{{ $totalCadastros }}</h4>
                            <p class="card-text">
                                Doadores no mês atual
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card bg-gradient-success"
                    style="border-radius: 15px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); color: white; width: 100%;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon text-white d-flex align-items-center justify-content-center rounded">
                            <i class="fa-solid fa-user-plus fa-3x"></i>
                        </div>
                        <div class="ml-auto">
                            <h4 class="card-title text-white" style="font-size: 30px;">R$ {{ $totalValorArrecadado }}</h4>
                            <p class="card-text">

                                @php
                                    $nomeMesIngles = \Carbon\Carbon::now()->formatLocalized('%B');

                                    $traducaoMeses = [
                                        'January' => 'Janeiro',
                                        'February' => 'Fevereiro',
                                        'March' => 'Março',
                                        'April' => 'Abril',
                                        'May' => 'Maio',
                                        'June' => 'Junho',
                                        'July' => 'Julho',
                                        'August' => 'Agosto',
                                        'September' => 'Setembro',
                                        'October' => 'Outubro',
                                        'November' => 'Novembro',
                                        'December' => 'Dezembro',
                                    ];

                                    $nomeMes = $traducaoMeses[$nomeMesIngles];
                                @endphp

                                Total arrecadado em {{ $nomeMes }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <table class="table table-bordered">
                <thead class="bg-gradient-success text-white">
                    <tr>
                        <th class="rounded-left text-center">Nome</th>
                        <th class="text-center">Celular/Fixo</th>
                        <th class="text-center">Endereço</th>
                        <th class="rounded-right text-center">Valor</th>
                        <!-- Adicione mais colunas conforme necessário -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totalRegistrosMesAtual as $registro)
                        <tr>
                            <td class="text-center">{{ $registro->name }}</td>
                            <td class="text-center">
                                @if ($registro->celular == null)
                                    {{ $registro->telefone_fixo }}
                                @elseif($registro->celular && $registro->telefone_fixo)
                                    Telefone fixo: {{ $registro->telefone_fixo }}<br>Celular: {{ $registro->celular }}
                                @else
                                    {{ $registro->celular }}
                                @endif
                            </td>
                            <td class="text-center">{{ $registro->rua . ', ' . $registro->bairro . ', ' . $registro->cidade }}</td>
                            <td class="text-center">R$ {{ $registro->valor }}</td>
                            <!-- Adicione mais colunas conforme necessário -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $totalRegistrosMesAtual->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>

@endsection
