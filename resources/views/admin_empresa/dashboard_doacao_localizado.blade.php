@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')
    <style>
        .custom-input {
            padding: 0px 10px!important;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #f5f5f5;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .custom-input:focus {
            border-color: #2DCEAB;
            box-shadow: 0 0 5px rgba(126, 95, 228, 0.5);
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #2DCEAB;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2DCEAB;
        }

        .modal-title {
            color: #2DCEAB;
        }

        .modal-body {
            background-color: #f5f5f5;
        }

        .modal-footer {
            background-color: #f5f5f5;
        }

        .modal-footer .btn {
            border-radius: 5px;
            font-weight: bold;
        }

        .modal-footer .btn-success {
            background-color: #67C23A;
            color: #fff;
        }

        .modal-footer .btn-success:hover {
            background-color: #56B92D;
        }

        .modal-footer .btn-danger {
            background-color: #F56C6C;
            color: #fff;
        }

        .modal-footer .btn-danger:hover {
            background-color: #2DCEAB;
        }

        .table {
            background-color: #fff;
        }

        .table thead th {
            background-color: #2DCEAB;
            color: #fff;
            border: none;
        }

        .table tbody tr {
            background-color: #f5f5f5;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #e0e0e0;
        }
    </style>

    <div class="container mt-5 col-12">
        <!-- Botão para abrir o modal -->
        <button type="button" class="btn bg-gradient-success text-white" data-toggle="modal" data-target="#myModal">
            + Clientes
        </button>

        <form action="{{ route('empresa_doações_localizar', ['empresa' => $empresa->name ]) }}" method="POST">
            @csrf
        <!-- Campo de input para buscar cliente com ícone de lupa -->
        <div class="input-group mt-3 mb-3">
            <input type="text" class="form-control" placeholder="Buscar cliente" name="search">
            <div class="input-group-append">
                <span class="input-group-text bg-gradient-success text-white">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </div>
            <button type="submit" class="btn bg-gradient-success text-white col-12">Buscar cliente</button>
            <a href="{{ route('Empresa_cadastro_cliente', ['empresa' => $empresa->name]) }}"><button type="button" class="btn bg-gradient-dark text-white col-12 mt-2">Voltar</button></a>
        </form>

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                <strong>Sucesso!</strong> {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
                <strong>Error!</strong> {{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Tabela responsiva -->
        <div class="table-responsive col-12" style="margin-top: 30px; padding: 1%;">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th class="rounded-left text-center">Nome cliente</th>
                        <th class="text-center">Endereço</th>
                        <th class="text-center">Celular</th>
                        <th class="text-center">Tipo de doação</th>
                        <th class="text-center">Valor doação</th>
                        <th class="text-center">Data vencimento</th>
                        <th class="rounded-right text-center">Opções</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td class="align-middle text-center">{{ $cliente->name }}</td>
                            <td class="align-middle text-center">
                                {{ $cliente->bairro . ' - ' . $cliente->rua . ' - ' . $cliente->numero }}</td>
                            <td class="align-middle text-center">{{ $cliente->celular }}</td>
                            <td class="align-middle text-center">{{ $cliente->tipo_pagamento }}</td>
                            <td class="align-middle text-center">R$ {{ $cliente->valor }}</td>
                            <td class="align-middle text-center">{{ $cliente->created_at->format('d/m/Y') }}</td>
                            <td class="align-middle text-center">
                                @if($cliente->situacao != "PRIMEIRA")
                                    <form action="{{ route('empresa_cadastro_cliente_primeira', ['empresa' => $empresa->name,'id' => $cliente->id]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-dark">PRIMEIRA EMISSÃO</button>
                                    </form>
                                @endif
                                <a style="display: inline-block; margin-left: 9px;" class="btn btn-primary"
                                href="{{ route('Empresa_cadastro_cliente_view', ['empresa' => $empresa->name,'id' => $cliente->id]) }}"><i class="fa-solid fa-eye"></i></a>

                                <a style="display: inline-block; margin-left: 9px;" class="btn bg-gradient-warning text-white"
                                href="{{ route('empresa_doações', ['empresa' => $empresa->name,'id' => $cliente->id]) }}"><i class="fa-solid fa-rectangle-list"></i></a>

                                <form action="{{ route('Empresa_cadastro_cliente_deletar', ['empresa' => $empresa->name, 'id' => $cliente->id]) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar novo cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('Empresa_cadastro_cliente_add', ['empresa' => $empresa->name]) }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_nome" name="cliente_nome" placeholder="Nome completo" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-map-marked-alt"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_endereco" name="cliente_endereco" placeholder="Rua" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-building"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_numero" name="cliente_numero" placeholder="N°" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-phone"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_telefone" name="cliente_telefone" placeholder="Celular" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-home"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_bairro" name="cliente_bairro" placeholder="Bairro" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-city"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_cidade" name="cliente_cidade" placeholder="Cidade" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-money-bill-wave"></i>
                                        </span>
                                        <input type="number" class="form-control custom-input" id="valor_doacao" name="valor_doacao" placeholder="Valor da Doação" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <strong>R$</strong>
                                        </span>
                                        <select class="form-select custom-input" id="pagamento" name="cliente_pagamento">
                                            <option value="MENSAL">MENSAL</option>
                                            <option value="ÚNICA">ÚNICA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Data vencimento:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-regular fa-calendar"></i>
                                        </span>
                                    <input type="date" class="form-control custom-input" id="data_doacao" name="vencimento" required>
                                </div>
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger text-white" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn bg-gradient-success text-white">Cadastrar</button>
                        </div>
                    </form>
                    
            </div>
        </div>
    </div>

@endsection
