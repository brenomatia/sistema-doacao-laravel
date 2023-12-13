@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<div class="container mt-5">
    <div class="log-container">

        <a href="{{ route('empresa_logs', ['empresa'=>$empresa->name]) }}"><button type="submit"
                class="btn bg-gradient-success text-white mt-3 mb-4 col-12">VOLTAR</button></a>

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
    </div>
</div>

@endsection