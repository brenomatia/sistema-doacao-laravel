@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')


<div class="container mt-5">

    @if(Session::get('success'))
    <div class="alert alert-success mt-3">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-check-circle fa-3x mr-3"></i>
            <div>
                <h4 class="alert-heading">Sucesso!</h4>
                <p class="mb-0">{{ Session::get('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(Session::get('fail'))
    <div class="alert alert-danger mt-3">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-exclamation-triangle fa-3x mr-3"></i>
            <div>
                <h4 class="alert-heading">Erro!</h4>
                <p class="mb-0">{{ Session::get('fail') }}</p>
            </div>
        </div>
    </div>
    @endif

    <table class="table table-bordered">
        <thead class="bg-gradient-success text-white">
            <tr>
                <th class="rounded-left text-center">#Recibo ID</th>
                <th class="text-center">Nome do Cliente</th>
                <th class="text-center">Valor a receber</th>
                <th class="rounded-right text-center">Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($abertos as $aberto)
            <tr>

                <td class="align-middle text-center">{{ $aberto->cliente_id }}</td>
                <td class="align-middle text-center">{{ $aberto->nome_cliente }}</td>
                <td class="align-middle text-center">R$ {{ $aberto->valor }}</td>
                <td class="align-middle text-center">

                    <button type="button" class="btn bg-gradient-success text-white" data-toggle="modal"
                        data-target="#BaixarRecibo_{{ $aberto->id }}">
                        BAIXAR RECIBO
                    </button>

                    <div class="modal fade" id="BaixarRecibo_{{ $aberto->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Baixar Recibo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <form
                                            action="{{ route('empresa_dar_baixa_em_recibos', ['empresa'=>$empresa->name, 'cliente_id'=>$aberto->cliente_id, 'id'=>$aberto->id]) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf

                                            <p class="mb-2" style="word-wrap: break-word; font-size: 20px;">Tem certeza
                                                de que deseja dar baixa nesse recibo no nome de<br>
                                                <strong>{{ $aberto->nome_cliente }}</strong> no valor de <strong>R$
                                                    {{ $aberto->valor }}</strong> ?<br>
                                                <strong style="font-size: 12px; color: green;">proxima parcela em
                                                    {{ \Carbon\Carbon::parse($aberto->created_at)->addMonth()->format('d/m/Y') }},
                                                    dentro de <a
                                                        href="{{ route('empresa_areceber', ['empresa'=>$empresa->name]) }}">a
                                                        receber.</a><strong>
                                            </p>

                                            <label>Método de pagamento</label>
                                            <select class="form-control mb-5" style="color: black!important;"
                                                id="metodo_pagamento" name="metodo_pagamento">
                                                <option value="DINHEIRO">DINHEIRO</option>
                                                <option value="PIX">PIX</option>
                                            </select>

                                            <div class="text-right">
                                                <button type="button" class="btn btn-outline-danger"
                                                    data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn bg-gradient-success text-white">Baixar
                                                    Recibo</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection