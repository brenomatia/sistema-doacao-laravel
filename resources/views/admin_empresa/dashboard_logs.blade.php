@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<div class="container mt-5 p-3">
    <div class="row">

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card"
                style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35); background-color: #38414A; color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded"
                        style="font-size: 24px;">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <div class="ml-auto">
                        <h4 class="card-title text-white" style="font-size: 30px;">{{ $totalCadastro }}</h4>
                        <p class="card-text">Total cadastros</p>
                    </div>
                </div>
                <div class="card-footer" style="background-color: #38414A; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">Mês Anterior</p>
                            <span>{{ $totalCadastroMesAnterior }}</span>
                        </div>
                    </div>
                </div>
                @if ($porcentagem_tiquete_clientes < 0)
                    @if($porcentagem_tiquete_clientes == 0)
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> 0 %
                        </div>
                    @else
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> {{ number_format($porcentagem_tiquete_clientes, 2) }} %
                        </div>
                    @endif
                @else
            <div class="text-success ml-2">
                <i class="fas fa-arrow-up"></i> {{ number_format($porcentagem_tiquete_clientes, 2) }} %
            </div>
            @endif
                <div class="progress" style="height: 10px; margin: 10px;">
                    <div class="progress-bar bg-gradient-success" role="progressbar"
                        style="width: {{ max(0, min(100, $porcentagem_tiquete_clientes)) }}%;"
                        aria-valuenow="{{ max(0, min(100, $porcentagem_tiquete_clientes)) }}" aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card"
                style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35); background-color: #38414A; color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded"
                        style="font-size: 24px;">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <div class="ml-auto">
                        <h4 class="card-title text-white" style="font-size: 30px;">{{ $totalFinalizadoMesAtual }}</h4>
                        <p class="card-text">Total finalizados</p>
                    </div>
                </div>
                <div class="card-footer" style="background-color: #38414A; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">Mês Anterior</p>
                            <span>{{ $totalFinalizadoMesAnterior }}</span>
                        </div>
                    </div>
                </div>
                @if ($porcentagem_finalizados < 0)
                    @if($porcentagem_finalizados == 0)
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> 0 %
                        </div>
                    @else
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> {{ number_format($porcentagem_finalizados, 2) }} %
                        </div>
                    @endif
                @else
                <div class="text-success ml-2">
                    <i class="fas fa-arrow-up"></i> {{ number_format($porcentagem_finalizados, 2) }} %
                </div>
                @endif
                <div class="progress" style="height: 10px; margin: 10px;">
                    <div class="progress-bar bg-gradient-success" role="progressbar"
                        style="width: {{ max(0, min(100, $porcentagem_finalizados)) }}%;"
                        aria-valuenow="{{ max(0, min(100, $porcentagem_finalizados)) }}" aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card"
                style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.35); background-color: #38414A; color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="icon bg-gradient-success text-white d-flex align-items-center justify-content-center rounded"
                        style="font-size: 24px;">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <div class="ml-auto">
                        <h4 class="card-title text-white" style="font-size: 30px;">{{ number_format($porcentagem_total, 2) }} %</h4>
                        <p class="card-text">Porcetagem</p>
                    </div>
                </div>
                <div class="card-footer" style="background-color: #38414A; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">Dados com base</p>
                            <span>no mês atual</span>
                        </div>
                    </div>
                </div>
                @if ($porcentagem_total < 0)
                    @if($porcentagem_total == 0)
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> 0 %
                        </div>
                    @else
                        <div class="text-danger ml-2">
                            <i class="fas fa-arrow-down"></i> {{ number_format($porcentagem_total, 2) }} %
                        </div>
                    @endif
                @else
                    <div class="text-success ml-2">
                        <i class="fas fa-arrow-up"></i> {{ number_format($porcentagem_total, 2) }} %
                    </div>
                @endif
                <div class="progress" style="height: 10px; margin: 10px;">
                    <div class="progress-bar bg-gradient-success" role="progressbar"
                        style="width: {{ max(0, min(100, $porcentagem_total)) }}%;"
                        aria-valuenow="{{ max(0, min(100, $porcentagem_total)) }}" aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container">
    <form action="{{ route('empresa_logs_pesquisa', ['empresa'=>$empresa->name])}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="usernameSelect">Selecione o nome do funcionário:</label>
            <select class="form-control" name="id" id="usernameSelect">
                <option value="">Todos</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn bg-gradient-success text-white mt-3 mb-4 col-12">Buscar</button>
    </form>
    <h2 class="mb-5">Registro de atividades</h2>
    <table class="log-table">
        <tbody>
            <tr>
                <td class="log-message">
                    @foreach ($logs as $log)
                    <b>*</b> {{ $log['timestamp'] }} - <b>{{ $log['name'] }}</b> : - {{ $log['message'] }}<br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    <div class="d-flex justify-content-center mb-5">
        {{ $logs_geral->links('pagination::bootstrap-5') }}
    </div>
</div>
</div>

@endsection