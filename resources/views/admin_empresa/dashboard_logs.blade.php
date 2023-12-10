@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<div class="container mt-5">
    <div class="log-container">
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
        <h2 class="mb-5">Log de Ações</h2>
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
    </div>
</div>

@endsection
