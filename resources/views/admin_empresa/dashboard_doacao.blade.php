@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<div class="container mt-5">
    <h3>Transações de Doações</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-gradient-success text-white">
                <tr>
                    <th class="rounded-left">ID</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Tipo</th>
                    <th class="rounded-right">Data da Doação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doacoes as $doacao)
                    <tr>
                        <td>{{ $doacao->id }}</td>
                        <td>{{ $doacao->cliente->name }}</td>
                        <td>R$ {{ $doacao->valor }}</td>
                        <td>{{ $doacao->tipo }}</td>
                        <td>{{ $doacao->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('Empresa_cadastro_cliente', ['empresa' => $empresa->name]) }}" class="btn bg-gradient-success text-white col-12 mt-5">Voltar</a>
</div>

@endsection
