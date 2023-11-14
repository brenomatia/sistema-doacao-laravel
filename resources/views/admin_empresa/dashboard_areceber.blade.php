@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<div class="container mt-5">
    <table class="table table-bordered">
        <thead class="bg-gradient-success text-white">
            <tr>
                <th class="rounded-left text-center">Nome do Cliente</th>
                <th class="text-center">Valor a receber</th>
                <th class="text-center">Vencimento em</th>
                <th class="rounded-right text-center">Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
            <tr>
                
                        <form action="{{ route('empresa_areceber_emitir', ['empresa' => $empresa->name, 'doacao_id' => $cliente->id]) }}" method="POST">
                            @csrf
                            <td class="align-middle text-center">{{ $cliente->name }}</td>
                            <td class="align-middle text-center">
                                 R$ {{ $cliente->valor }}
                            </td>
                            <td class="align-middle text-center">
                                <button class="btn bg-gradient-danger text-white">{{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y') }}</button><br>
                                Proxima parcela: <br>
                                <button class="btn bg-gradient-success text-white">{{ \Carbon\Carbon::parse($cliente->created_at)->addMonth()->format('d/m/Y') }}</button>
                            </td>
                            <td class="align-middle text-center">
                                <input type="hidden" value="{{ $cliente->valor }}" name="valor_doador">
                                <input type="hidden" value="{{ \Carbon\Carbon::parse($cliente->created_at)->addMonth()->format('Y-m-d') }}" name="proximo_vencimento">
                                <button class="btn bg-gradient-danger text-white"><i class="fa-solid fa-file-waveform"></i> EMITIR</button>
                            </td>
                        </form>
                

                
            </tr>
        @endforeach

        </tbody>
    </table>
</div>



@endsection
