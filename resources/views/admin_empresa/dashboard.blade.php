@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<div class="container col-12 p-3">
    <div class="row">

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card"
                style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35); background-color: #38414A; color: white;">
                <div class="card-body d-flex align-items-center">
                    @if ($clientes_atual == 0)
                    <div
                        class="icon bg-gradient-danger text-white d-flex align-items-center justify-content-center rounded">
                        <i class="fas fa-donate fa-3x"></i>
                    </div>
                    @else
                    <div
                        class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded">
                        <i class="fas fa-donate fa-3x"></i>
                    </div>
                    @endif
                    <div class="ml-auto">
                        <h4 class="card-title text-white" style="font-size: 30px;">{{ $clientes_atual }}</h4>
                        <p class="card-text">
                            Doadores mês atual
                        </p>
                    </div>
                </div>

                <div class="card-footer" style="background-color: #38414A; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">Mês Anterior</p>
                            <span>{{ $clientes_passado }}</span>
                        </div>
                        @if ($clientes_atual == 0)
                        <div class="text-danger">
                            <i class="fas fa-arrow-down"></i> 0%
                        </div>
                        @elseif($clientes_atual == $clientes_passado)

                        @elseif($porcetagem_tiquete_clientes < 0) <div class="text-warning">
                            <i class="fas fa-arrow-up"></i> {{ $porcetagem_tiquete_clientes }} %
                    </div>
                    @else
                    <div class="text-success">
                        <i class="fas fa-arrow-up"></i> {{ $porcetagem_tiquete_clientes }} %
                    </div>
                    @endif
                </div>
            </div>
            <div class="progress" style="height: 10px; margin-left: 10px; margin-right: 10px;">
                @if ($clientes_atual == 0)
                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%;" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100"></div>
                @else
                <div class="progress-bar bg-gradient-success" role="progressbar"
                    style="width: {{ max(0, min(100, $porcetagem_tiquete_clientes)) }}%;"
                    aria-valuenow="{{ max(0, min(100, $porcetagem_tiquete_clientes)) }}" aria-valuemin="0"
                    aria-valuemax="100">
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card"
            style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35); background-color: #38414A; color: white;">
            <div class="card-body d-flex align-items-center">
                @if ($valor_atual == 0)
                <div
                    class="icon bg-gradient-danger text-white d-flex align-items-center justify-content-center rounded">
                    <i class="fa-solid fa-square-poll-vertical fa-3x"></i>
                </div>
                @else
                <div
                    class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded">
                    <i class="fa-solid fa-square-poll-vertical fa-3x"></i>
                </div>
                @endif
                <div class="ml-auto">
                    <h4 class="card-title text-white" style="font-size: 30px;">R$
                        {{ $valor_atual == 0 ? '0.00' : number_format($tiquete_medio_base_atual, 2, ',', '.') }}
                    </h4>

                    <p class="card-text">
                        Tiquete médio mês atual
                    </p>
                </div>
            </div>

            <div class="card-footer" style="background-color: #38414A; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0">Mês Anterior</p>
                        <span>R$ {{ number_format($tiquete_medio_base_passado, 2, ',', '.') }}</span>
                    </div>
                    @if ($valor_atual == 0)
                    <div class="text-danger">
                        <i class="fas fa-arrow-down"></i> 0%
                    </div>
                    @elseif($porcentagem_tiquete < 0) <div class="text-warning">
                        <i class="fas fa-arrow-up"></i> {{ $porcentagem_tiquete }} %
                </div>
                @else
                <div class="text-success">
                    <i class="fas fa-arrow-up"></i> {{ $porcentagem_tiquete }} %
                </div>
                @endif
            </div>
        </div>
        <div class="progress" style="height: 10px; margin-left: 10px; margin-right: 10px;">
            @if ($valor_atual == 0)
            <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%;" aria-valuenow="0"
                aria-valuemin="0" aria-valuemax="100"></div>
            @else
            <div class="progress-bar bg-gradient-success" role="progressbar"
                style="width: {{ max(0, min(100, $porcentagem_tiquete)) }}%;"
                aria-valuenow="{{ max(0, min(100, $porcentagem_tiquete)) }}" aria-valuemin="0" aria-valuemax="100">
            </div>
            @endif
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-6 mb-4">
    <div class="card"
        style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35); background-color: #38414A; color: white;">
        <div class="card-body d-flex align-items-center">
            @if ($valor_atual == 0)
            <div class="icon bg-gradient-danger text-white d-flex align-items-center justify-content-center rounded">
                <i class="fa-solid fa-hand-holding-heart fa-3x"></i>
            </div>
            @else
            <div class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded">
                <i class="fa-solid fa-hand-holding-heart fa-3x"></i>
            </div>
            @endif
            <div class="ml-auto">
                <h4 class="card-title text-white" style="font-size: 30px;">R$
                    {{ $valor_atual == 0 ? '0.00' : number_format($valor_atual, 2, ',', '.') }}
                </h4>

                <p class="card-text">
                    Total Doação mês atual
                </p>
            </div>
        </div>

        <div class="card-footer" style="background-color: #38414A; color: white;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-0">Mês Anterior</p>
                    <span>R$ {{ number_format($valor_passado, 2, ',', '.') }}</span>
                </div>
                @if ($valor_atual == 0)
                <div class="text-danger">
                    <i class="fas fa-arrow-down"></i> 0%
                </div>
                @elseif($porcetagem_tiquete_total < 0) <div class="text-warning">
                    <i class="fas fa-arrow-up"></i> {{ $porcetagem_tiquete_total }} %
            </div>
            @else
            <div class="text-success">
                <i class="fas fa-arrow-up"></i> {{ $porcetagem_tiquete_total }} %
            </div>
            @endif
        </div>
    </div>
    <div class="progress" style="height: 10px; margin-left: 10px; margin-right: 10px;">
        @if ($valor_atual == 0)
        <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%;" aria-valuenow="0"
            aria-valuemin="0" aria-valuemax="100"></div>
        @else
        <div class="progress-bar bg-gradient-success" role="progressbar"
            style="width: {{ max(0, min(100, $porcetagem_tiquete_total)) }}%;"
            aria-valuenow="{{ max(0, min(100, $porcetagem_tiquete_total)) }}" aria-valuemin="0" aria-valuemax="100">
        </div>
        @endif
    </div>
</div>

</div>
</div>




<div class="row">
    <div class="col-lg-5 col-md-5 mb-4">
        <div class="card border-0 shadow-lg" style="border-radius: 10px; background-color: #38414A; color: white;">

            <div class="card-header border-0" style="background-color: #38414A; color: white;">
                <h5 class="card-title text-white mb-0" style="font-size: 25px;">Últimos Registros</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="bg-gradient-success text-white rounded-left border-0"
                                    style="font-size: 14px;">NOME CLIENTE</th>
                                <th class="bg-gradient-success text-white border-0"
                                    style="font-size: 14px;">VALOR</th>
                                <th class="bg-gradient-success text-white rounded-right border-0"
                                    style="font-size: 14px;">Data/Hora</th>
                                <!-- Adicione mais colunas conforme necessário -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ultimosRegistros as $registro)
                            <tr>
                                <td class="border-0" style="font-size: 14px;">{{ $registro->name }}</td>
                                <td class="border-0" style="font-size: 14px; color: #2DCEAB;">R$ {{ $registro->valor }}</td>
                                <td class="border-0" style="font-size: 14px; color: #2DCEAB;">{{ $registro->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center border-0">Nenhum registro encontrado</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 col-md-7 mb-4">
        <div class="card border-0 shadow-lg" style="border-radius: 10px; background-color: #38414A; color: white;">

            <div class="card-header border-0" style="background-color: #38414A; color: white;">
                <h5 class="card-title text-white mb-0" style="font-size: 25px;">Últimas Logs</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="bg-gradient-success text-white rounded-left border-0"
                                    style="font-size: 14px;">Nome user</th>
                                <th class="bg-gradient-success text-white border-0"
                                    style="font-size: 14px;">Alteração</th>
                                <th class="bg-gradient-success text-white rounded-right border-0"
                                    style="font-size: 14px;">Data/Hora</th>
                                <!-- Adicione mais colunas conforme necessário -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ultimosAlteracoes as $alteracoes)
                            <tr>
                                <td class="border-0" style="font-size: 14px;">{{ $alteracoes->name }}</td>
                                <td class="border-0" style="font-size: 14px; color: #2DCEAB;">{{ $alteracoes->registro_acao }}</td>
                                <td class="border-0" style="font-size: 14px; color: #2DCEAB;">{{ $alteracoes->created_at->format('d/m/Y - H:i:s') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center border-0">Nenhum registro encontrado</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


</div>

@endsection