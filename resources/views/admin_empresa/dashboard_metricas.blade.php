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
            <div class="card">
                <div class="card-header">
                    <h5>Status das Doações em Aberto</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoStatusDoacoesEmAberto" style="width: 400px; height: 400px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Comparação de valores</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoPlanejamentoFuturo" style="width: 400px; height: 220px;"></canvas>
                </div>
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
                                <th class="border-0 bg-gradient-success rounded-right text-center">Contribuição Total (R$)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientesContribuicao as $index => $cliente)
                            <tr>
                                <td class="border-0 text-center">{{ $index + 1 }}°</td>
                                <td class="border-0 text-center">{{ $cliente->name }}</td>
                                <td class="border-0 text-center" style="color: #2DCEAB;">R$ {{ number_format($cliente->contribuicao_total, 2, ',', '.') }}</td>
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
                        label: function(context) {
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
            labels: doacoesPorTipo.map(function(item) {
                return item.tipo;
            }),
            datasets: [{
                data: doacoesPorTipo.map(function(item) {
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
                        label: function(context) {
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
            labels: statusDoacoesEmAberto.map(function(status) {
                return status.status;
            }),
            datasets: [{
                label: 'Quantidade',
                data: statusDoacoesEmAberto.map(function(status) {
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
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
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
