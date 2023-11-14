@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<div class="container mt-5">
    <div class="log-container">
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
