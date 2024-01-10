@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')


    <div class="container mt-5">

        @if (Session::get('success'))
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

        @if (Session::get('fail'))
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

        <form action="{{ route('empresa_baixar_recibos_pesquisa', ['empresa'=>$empresa->name]) }}" method="POST" class="mb-5">
            @csrf
            <!-- Campo de input para buscar cliente com ícone de lupa -->
            <div class="input-group mt-3 mb-3">
                <input type="text" class="form-control" placeholder="Buscar cliente" name="search">
                <div class="input-group-append">
                    <span class="input-group-text bg-gradient-success text-white">
                        <i class="fas fa-search p-1"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn bg-gradient-success text-white col-12">Buscar cliente</button>
            <a href="{{ route('empresa_baixar', ['empresa' => $empresa->name ]) }}"><button type="button" class="btn bg-gradient-danger text-white col-12 mt-2"><i class="fa-solid fa-arrows-rotate"></i></button></a>
        </form>

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
                                            <form
                                                action="{{ route('empresa_dar_baixa_em_recibos', ['empresa' => $empresa->name, 'cliente_id' => $aberto->cliente_id, 'id' => $aberto->id]) }}"
                                                method="POST">
                                                @csrf

                                                <p class="mb-2" style="word-wrap: break-word; font-size: 20px;">
                                                    Tem certeza de que deseja dar baixa nesse recibo no nome de<br>
                                                    <strong>{{ $aberto->nome_cliente }}</strong> no valor de
                                                    <strong>R$ {{ $aberto->valor }}</strong> ?
                                                    <br>
                                                    <strong style="font-size: 12px; color: green;">
                                                        Próxima parcela em
                                                        {{ \Carbon\Carbon::parse($aberto->created_at)->addMonth()->format('d/m/Y') }},
                                                        dentro de
                                                        <a
                                                            href="{{ route('empresa_areceber', ['empresa' => $empresa->name]) }}">a
                                                            receber.</a>
                                                    </strong>
                                                </p>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="new_date">Atualizar data:</label>
                                                        <input type="date" class="form-control" id="new_date"
                                                            name="new_date"
                                                            value="{{ \Carbon\Carbon::parse($aberto->created_at)->addMonth()->format('Y-m-d') }}" />

                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="new_valor">Atualizar Valor:</label>
                                                        <input type="number" class="form-control" id="new_valor"
                                                            name="new_valor" value="{{ $aberto->valor }}" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="metodo_pagamento">Método de pagamento</label>
                                                    <select class="form-control" id="metodo_pagamento"
                                                        name="metodo_pagamento" style="color: black!important;">
                                                        <option value="DINHEIRO">DINHEIRO</option>
                                                        <option value="PIX">PIX</option>
                                                    </select>
                                                </div>

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







                            <button type="button" class="btn bg-gradient-danger text-white" data-toggle="modal" data-target="#Deletar_{{ $aberto->id }}">
                                <i class="fa-solid fa-trash-can"></i>
                              </button>
                            
                              <!-- Modal Bootstrap -->
                              <div class="modal fade" id="Deletar_{{ $aberto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">{{ $aberto->nome_cliente }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      Deseja realmente excluir o registro {{ $aberto->nome_cliente }} ?
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>

                                      <form action="{{ route('empresa_deleta_recibos', ['empresa'=>$empresa->name, 'id'=>$aberto->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn bg-gradient-danger text-white">Excluir</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>





                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $abertos->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
