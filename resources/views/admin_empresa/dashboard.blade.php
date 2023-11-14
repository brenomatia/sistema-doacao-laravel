@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<div class="container col-12 p-3">
    <div class="row d-flex flex-nowrap">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card" style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35);">
                <div class="card-body d-flex align-items-center">
                    @if ($clientes_atual == 0)
                        <div class="icon bg-gradient-danger text-white d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-donate fa-3x"></i>
                        </div>
                    @else
                        <div class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded">
                            <i class="fas fa-donate fa-3x"></i>
                        </div>
                    @endif
                    <div class="ml-auto">
                        <h4 class="card-title">{{ $clientes_atual }}</h4>
                        <p class="card-text text-muted">
                            Doadores mês atual
                        </p>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Mês Anterior</p>
                            <span>{{ $clientes_passado }}</span>
                        </div>
                        @if ($clientes_atual == 0)
                            <div class="text-danger">
                                <i class="fas fa-arrow-down"></i> 0%
                            </div>
                        @elseif($clientes_atual == $clientes_passado)

                        @elseif($porcetagem_tiquete_clientes < 0)
                            <div class="text-warning">
                                <i class="fas fa-arrow-up"></i> {{ $porcetagem_tiquete_clientes }} %
                            </div>
                        @else
                            <div class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $porcetagem_tiquete_clientes }} %
                            </div>
                        @endif
                    </div>
                </div>
                <div class="progress" style="height: 8px;">
                    @if ($clientes_atual == 0)
                        <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    @else
                        <div class="progress-bar bg-gradient-success" role="progressbar"
                            style="width: {{ max(0, min(100, $porcetagem_tiquete_clientes)) }}%;"
                            aria-valuenow="{{ max(0, min(100, $porcetagem_tiquete_clientes)) }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card" style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35);">
                <div class="card-body d-flex align-items-center">
                    @if ($valor_atual == 0)
                        <div class="icon bg-gradient-danger text-white d-flex align-items-center justify-content-center rounded">
                            <i class="fa-solid fa-square-poll-vertical fa-3x"></i>
                        </div>
                    @else
                        <div class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded">
                            <i class="fa-solid fa-square-poll-vertical fa-3x"></i>
                        </div>
                    @endif
                    <div class="ml-auto">
                        <h4 class="card-title">R$
                            {{ $valor_atual == 0 ? '0.00' : number_format($tiquete_medio_base_atual, 2, ',', '.') }}
                        </h4>

                        <p class="card-text text-muted">
                            Tiquete médio mês atual
                        </p>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Mês Anterior</p>
                            <span>R$ {{ number_format($tiquete_medio_base_passado, 2, ',', '.') }}</span>
                        </div>
                        @if ($valor_atual == 0)
                            <div class="text-danger">
                                <i class="fas fa-arrow-down"></i> 0%
                            </div>
                        @elseif($porcentagem_tiquete < 0)
                            <div class="text-warning">
                                <i class="fas fa-arrow-up"></i> {{ $porcentagem_tiquete }} %
                            </div>
                        @else
                            <div class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $porcentagem_tiquete }} %
                            </div>
                        @endif
                    </div>
                </div>
                <div class="progress" style="height: 8px;">
                    @if ($valor_atual == 0)
                        <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    @else
                        <div class="progress-bar bg-gradient-success" role="progressbar"
                            style="width: {{ max(0, min(100, $porcentagem_tiquete)) }}%;"
                            aria-valuenow="{{ max(0, min(100, $porcentagem_tiquete)) }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card" style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35);">
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
                        <h4 class="card-title">R$
                            {{ $valor_atual == 0 ? '0.00' : number_format($valor_atual, 2, ',', '.') }}
                        </h4>

                        <p class="card-text text-muted">
                            Total Doação mês atual
                        </p>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Mês Anterior</p>
                            <span>R$ {{ number_format($valor_passado, 2, ',', '.') }}</span>
                        </div>
                        @if ($valor_atual == 0)
                            <div class="text-danger">
                                <i class="fas fa-arrow-down"></i> 0%
                            </div>
                        @elseif($porcetagem_tiquete_total < 0)
                            <div class="text-warning">
                                <i class="fas fa-arrow-up"></i> {{ $porcetagem_tiquete_total }} %
                            </div>
                        @else
                            <div class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $porcetagem_tiquete_total }} %
                            </div>
                        @endif
                    </div>
                </div>
                <div class="progress" style="height: 8px;">
                    @if ($valor_atual == 0)
                        <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 0%;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    @else
                        <div class="progress-bar bg-gradient-success" role="progressbar"
                            style="width: {{ max(0, min(100, $porcetagem_tiquete_total)) }}%;"
                            aria-valuenow="{{ max(0, min(100, $porcetagem_tiquete_total)) }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
