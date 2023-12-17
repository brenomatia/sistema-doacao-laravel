@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="container col-12 p-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: #38414A; color: white;">
                <div class="card-header" style="background-color: #38414A;">
                    <h5 class="text-white">Busca Personalizada:</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('empresa_metricas_pesquisa', ['empresa'=>$empresa->name]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="data_inicio">Data de Início:</label>
                            <input type="date" name="data_inicio" class="form-control" style="color: black;">
                        </div>

                        <div class="form-group">
                            <label for="data_fim">Data de Fim:</label>
                            <input type="date" name="data_fim" class="form-control" style="color: black;">
                        </div>

                        <button type="submit" class="btn bg-gradient-success col-12 text-white">Buscar dados</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="container col-12 mt-5 p-3">
    <div class="row">

        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card"
                style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35); background-color: #38414A; color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded"
                        style="font-size: 24px;">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <div class="ml-auto">
                        <h4 class="card-title text-white" style="font-size: 30px;">{{ $total_cadastros_sae }}</h4>
                        <p class="card-text">Clientes SAE</p>
                    </div>
                </div>
                <div class="card-footer" style="background-color: #38414A; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">Mês Anterior</p>
                            <span>{{ $mesPassado_total_cadastros_sae }}</span>
                        </div>
                    </div>
                </div>
                @if($mesPassado_total_cadastros_sae <= 0)@else
                @if ($porcentagem_crescimento_cadastros_formatada < 0)
                    @if($porcentagem_crescimento_cadastros_formatada == 0)
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> 0 %
                        </div>
                    @else
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> {{ $porcentagem_crescimento_cadastros_formatada }}
                        </div>
                    @endif
                @else
            <div class="text-success ml-2">
                <i class="fas fa-arrow-up"></i> {{ $porcentagem_crescimento_cadastros_formatada }}
            </div>
            @endif
                <div class="progress" style="height: 10px; margin: 10px;">
                    <div class="progress-bar bg-gradient-success" role="progressbar"
                        style="width: {{ max(0, min(100, $porcentagem_crescimento_cadastros_formatada)) }}%;"
                        aria-valuenow="{{ max(0, min(100, $porcentagem_crescimento_cadastros_formatada)) }}" aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            @endif
            </div>
        </div>

        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card"
                style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35); background-color: #38414A; color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded"
                        style="font-size: 24px;">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <div class="ml-auto">
                        <h4 class="card-title text-white" style="font-size: 30px;">R$ {{ number_format($total_valor_sae, 2) }}</h4>
                        <p class="card-text">Valor SAE</p>
                    </div>
                </div>
                <div class="card-footer" style="background-color: #38414A; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">Mês Anterior</p>
                            <span>R$ {{ number_format($mesPassado_total_valor_sae, 2) }}</span>
                        </div>
                    </div>
                </div>
                @if($mesPassado_total_valor_sae <= 0)@else
                @if ($porcentagem_crescimento_valor_formatada < 0)
                    @if($porcentagem_crescimento_valor_formatada == 0)
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> 0 %
                        </div>
                    @else
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> {{ $porcentagem_crescimento_valor_formatada }}
                        </div>
                    @endif
                @else
                <div class="text-success ml-2">
                    <i class="fas fa-arrow-up"></i> {{ $porcentagem_crescimento_valor_formatada }}
                </div>
                @endif
                <div class="progress" style="height: 10px; margin: 10px;">
                    <div class="progress-bar bg-gradient-success" role="progressbar"
                        style="width: {{ max(0, min(100, $porcentagem_crescimento_valor_formatada)) }}%;"
                        aria-valuenow="{{ max(0, min(100, $porcentagem_crescimento_valor_formatada)) }}" aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
                @endif
            </div>
    </div>


    </div>
</div>





<div class="container col-12 p-3">
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">

                <canvas id="graficoReceitasMensais" style="width: 400px; height: 400px;"></canvas>

            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">

                <canvas id="graficoDistribuicaoPorTipo" style="width: 400px; height: 400px;"></canvas>

            </div>
        </div>
    </div>
</div>


<div class="container col-12 p-3">
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">
                <canvas id="graficoStatusDoacoesEmAberto" style="width: 400px; height: 400px;"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <canvas id="graficoPlanejamentoFuturo" style="width: 400px; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="container col-12 p-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: #38414A; color: white;">
                <div class="card-header" style="background-color: #38414A;">
                    <h5 class="text-white">TOP 5 clientes que mais Contribuíram</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border-0 bg-gradient-success rounded-left text-center">Posição</th>
                                <th class="border-0 bg-gradient-success text-center">Nome do Cliente</th>
                                <th class="border-0 bg-gradient-success rounded-right text-center">Contribuição Total
                                    (R$)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientesContribuicao as $index => $cliente)
                            <tr>
                                <td class="border-0 text-center">{{ $index + 1 }}°</td>
                                <td class="border-0 text-center">{{ $cliente->name }}</td>
                                <td class="border-0 text-center" style="color: #2DCEAB;">R$
                                    {{ number_format($cliente->contribuicao_total, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var ctx = document.getElementById('graficoReceitasMensais').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mês Atual', 'Mês Passado'],
            datasets: [{
                label: 'Receitas Mensais',
                data: [@json($doacoesMesAtual), @json($doacoesMesPassado)],
                backgroundColor: [
                    '#2DCEAB',
                    '#38414A',
                ],
                borderColor: [
                    '#2DCEAB',
                    '#38414A',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Torna o gráfico não fixo no aspect ratio
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'R$' + context.parsed.y.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>







<script>
    var ctx = document.getElementById('graficoDistribuicaoPorTipo').getContext('2d');

    // Converte os valores para números no lado do PHP
    var doacoesPorTipo = {!! $doacoesPorTipo !!};

    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: doacoesPorTipo.map(function (item) {
                return item.tipo;
            }),
            datasets: [{
                data: doacoesPorTipo.map(function (item) {
                    return parseFloat(item.total_valor);
                }),
                backgroundColor: [
                    '#2DCEAB',
                    '#38414A',
                ],
                borderColor: [
                    '#2DCEAB',
                    '#38414A',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Torna o gráfico não fixo no aspect ratio
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            var value = context.parsed.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                            return 'R$' + value;
                        }
                    }
                }
            }
        }
    });
</script>





<script>
    var ctx = document.getElementById('graficoStatusDoacoesEmAberto').getContext('2d');

    var statusDoacoesEmAberto = {!! $statusDoacoesEmAberto !!};

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: statusDoacoesEmAberto.map(function (status) {
                return status.status;
            }),
            datasets: [{
                label: 'Quantidade',
                data: statusDoacoesEmAberto.map(function (status) {
                    return status.quantidade;
                }),
                backgroundColor: [
                    '#2DCEAB',
                    '#38414A',
                    // Adicione mais cores conforme necessário
                ],
                borderColor: [
                    '#2DCEAB',
                    '#38414A',
                    // Adicione mais cores conforme necessário
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<script>
    var ctx = document.getElementById('graficoPlanejamentoFuturo').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json(array_column($projecoes, 'data')),
            datasets: [{
                label: 'Projeção de Recebimento',
                data: @json(array_column($projecoes, 'valor')),
                backgroundColor: '#2DCEAB',
                borderColor: '#2DCEAB',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var label = 'R$' + context.parsed.y.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>


@endsection