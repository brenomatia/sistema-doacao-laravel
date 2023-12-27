@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

<style>
    .custom-input {
        padding: 0px 10px !important;
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

    /* Remover setinhas para navegadores baseados em Chromium (Chrome, Edge) */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Remover setinhas para o Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>

<div class="container mt-5 col-12">
    <!-- Botão para abrir o modal -->
    <button type="button" class="btn bg-gradient-success text-white" data-toggle="modal" data-target="#myModal">
        + Clientes
    </button>

    <form action="{{ route('empresa_doações_localizar', ['empresa' => $empresa->name]) }}" method="POST">
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
                    <th class="text-center">Observação</th>
                    <th class="text-center">Endereço</th>
                    <th class="text-center">Celular/Telefone</th>
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
                    <td class="align-middle text-center">{{ $cliente->obs }}</td>
                    <td class="align-middle text-center">
                        {{ $cliente->bairro . ' - ' . $cliente->rua . ' - ' . $cliente->numero }}</td>

                    <td class="align-middle text-center">
                        @if($cliente->celular == null)
                        {{ $cliente->telefone_fixo }}
                        @elseif($cliente->celular && $cliente->telefone_fixo )
                        FIXO: {{ $cliente->telefone_fixo }} - CEL: {{ $cliente->celular }}
                        @else
                        {{ $cliente->celular }}
                        @endif
                    </td>

                    @if($cliente->tipo == "SAE")
                    <td class="align-middle text-center"><img src="{{ asset('img/sae.png') }}"
                            style="max-width: 100px;"></td>
                    @else
                    <td class="align-middle text-center">MENSAL</td>
                    @endif
                    <td class="align-middle text-center">R$ {{ $cliente->valor }}</td>
                    <td class="align-middle text-center">{{ $cliente->created_at->format('d/m/Y') }}</td>
                    <td class="align-middle text-center">

                        @if ($cliente->situacao != 'PRIMEIRA')
                        <form
                            action="{{ route('empresa_cadastro_cliente_primeira', ['empresa' => $empresa->name, 'id' => $cliente->id]) }}"
                            method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn" style="background-color: #38414A; color: white;">1°
                                EMISSÃO</button>
                        </form>
                        @endif

                        <button type="button" class="btn bg-gradient-success text-white" data-toggle="modal"
                            data-target="#dadosCliente_{{ $cliente->id }}">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <button type="button" class="btn bg-gradient-success text-white" data-toggle="modal"
                            data-target="#lista_{{ $cliente->id }}">
                            <i class="fa-solid fa-rectangle-list"></i>
                        </button>


                        <a
                            href="{{ route('empresa_termo_sae_route', ['empresa'=>$empresa->name, 'id'=>$cliente->id]) }}"><button
                                type="button" class="btn bg-gradient-primary text-white mr-1"><i
                                    class="fa-solid fa-file-contract"></i></button></a>

                        <button type="button" class="btn bg-gradient-danger text-white" data-toggle="modal"
                            data-target="#delete_{{ $cliente->id }}">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>

                        <div class="modal fade" id="delete_{{ $cliente->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <form
                                                action="{{ route('Empresa_cadastro_cliente_deletar', ['empresa' => $empresa->name, 'id' => $cliente->id]) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <p>Tem certeza de que deseja excluir o cliente
                                                    <strong>{{ $cliente->name }}</strong> do sistema?
                                                </p>
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-dismiss="modal">Cancelar</button>
                                                    <button type="submit"
                                                        class="btn bg-gradient-danger text-white">Remover
                                                        Cliente</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL LISTA DE  -->
                        <div class="modal fade" id="lista_{{ $cliente->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
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
                                                            @if($doacao->cliente_id == $cliente->id)
                                                            <td>{{ $doacao->id }}</td>
                                                            <td>{{ $doacao->cliente->name }}</td>
                                                            <td>R$ {{ $doacao->valor }}</td>
                                                            <td>{{ $doacao->tipo }}</td>
                                                            <td>{{ $doacao->created_at->format('d/m/Y') }}</td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- MODAL DADOS CLIENTE  -->
                        <div class="modal fade" id="dadosCliente_{{ $cliente->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Atualizar dados cliente</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="{{ route('Empresa_cadastro_cliente_att', ['empresa' => $empresa->name, 'id' => $cliente->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <i class="fa-solid fa-user"></i>
                                                            </span>
                                                            <input type="text" class="form-control custom-input"
                                                                id="cliente_nome" name="cliente_nome"
                                                                value="{{ $cliente->name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <i class="fa-solid fa-map-marked-alt"></i>
                                                            </span>
                                                            <input type="text" class="form-control custom-input"
                                                                id="cliente_endereco" name="cliente_endereco"
                                                                value="{{ $cliente->rua }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <i class="fa-solid fa-building"></i>
                                                            </span>
                                                            <input type="text" class="form-control custom-input"
                                                                id="cliente_numero" name="cliente_numero"
                                                                value="{{ $cliente->numero }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <i class="fa-solid fa-phone"></i>
                                                            </span>
                                                            <input type="text" class="form-control custom-input"
                                                                id="cliente_telefone" name="cliente_telefone"
                                                                value="{{ $cliente->celular }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <i class="fa-solid fa-home"></i>
                                                            </span>
                                                            <input type="text" class="form-control custom-input"
                                                                id="cliente_bairro" name="cliente_bairro"
                                                                value="{{ $cliente->bairro }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <i class="fa-solid fa-city"></i>
                                                            </span>
                                                            <input type="text" class="form-control custom-input"
                                                                id="cliente_cidade" name="cliente_cidade"
                                                                value="{{ $cliente->cidade }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <i class="fa-solid fa-money-bill-wave"></i>
                                                            </span>
                                                            <input type="number" class="form-control custom-input"
                                                                id="valor_doacao" name="valor_doacao"
                                                                value="{{ $cliente->valor }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <strong>R$</strong>
                                                            </span>
                                                            <select class="form-select custom-input" id="pagamento"
                                                                name="cliente_pagamento">
                                                                <option value="MENSAL"
                                                                    {{ $cliente->tipo_pagamento === 'MENSAL' ? 'selected' : '' }}>
                                                                    MENSAL</option>
                                                                <option value="ÚNICA"
                                                                    {{ $cliente->tipo_pagamento === 'ÚNICA' ? 'selected' : '' }}>
                                                                    ÚNICA</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label>Data vencimento:</label>
                                                        <div class="input-group">
                                                            <span
                                                                class="input-group-text bg-gradient-success text-white">
                                                                <i class="fa-regular fa-calendar"></i>
                                                            </span>
                                                            <input type="date" class="form-control custom-input"
                                                                id="data_doacao" name="vencimento"
                                                                value="{{ $cliente->created_at->format('Y-m-d') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between mb-4">
                                                    <button type="submit"
                                                        class="btn bg-gradient-success text-white col-12">Atualizar</button>
                                                </div>
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
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control custom-input" id="cliente_nome"
                                        name="cliente_nome" placeholder="Nome completo" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-success text-white">
                                        <i class="fa-solid fa-map-marked-alt"></i>
                                    </span>
                                    <input type="text" class="form-control custom-input" id="cliente_rua_cadastro"
                                        name="cliente_endereco" placeholder="Rua">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-success text-white">
                                        <i class="fa-solid fa-building"></i>
                                    </span>
                                    <input type="text" class="form-control custom-input" id="cliente_numero"
                                        name="cliente_numero" placeholder="N°">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-success text-white">
                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                    </span>
                                    <input type="text" class="form-control custom-input" id="cliente_telefone"
                                        name="cliente_telefone" placeholder="Celular">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-success text-white">
                                        <i class="fa-solid fa-home"></i>
                                    </span>
                                    <input type="text" class="form-control custom-input" id="cliente_bairro_cadastro"
                                        name="cliente_bairro" placeholder="Bairro">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-success text-white">
                                        <i class="fa-solid fa-city"></i>
                                    </span>
                                    <input type="text" class="form-control custom-input" id="cliente_cidade_cadastro"
                                        name="cliente_cidade" placeholder="Cidade">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </span>
                                    <input type="number" class="form-control custom-input" id="valor_doacao"
                                        name="valor_doacao" placeholder="Valor da Doação" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-success text-white">
                                        CEP
                                    </span>
                                    <input type="number" class="form-control" id="cep" name="cep"
                                        style="padding: 0% 2%;" maxlength="8" oninput="buscarCEP()">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Data vencimento:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-regular fa-calendar"></i>
                                    </span>
                                    <input type="date" class="form-control custom-input" id="data_doacao"
                                        name="vencimento" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Telefone fixo:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-gradient-success text-white">
                                        <i class="fa-solid fa-phone"></i>
                                    </span>
                                    <input type="number" class="form-control custom-input" id="cliente_fixo"
                                        name="telefone_fixo">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Observação:</label>
                            <!-- Substitua o input por um textarea -->
                            <textarea class="form-control custom-input" id="observacao" name="observacao" rows="4"
                                required></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-danger text-white"
                                data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn bg-gradient-success text-white">Cadastrar</button>
                        </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function buscarCEP() {
            var cep = $('#cep').val().replace(/\D/g, ''); // Remove non-numeric characters
            if (cep.length !== 8) {
                return; // Invalid CEP length
            }

            // Make an AJAX request to the Viacep API
            $.ajax({
                url: 'https://viacep.com.br/ws/' + cep + '/json/',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log('API Response:', data); // Log the entire data object

                    if (data) {
                        // Check if the expected properties are present in the data object
                        if ('localidade' in data && 'uf' in data && 'bairro' in data && 'logradouro' in data) {
                            // Update the address fields with the retrieved data
                            $('#cliente_cidade_cadastro').val(data.localidade + ' - ' + data.uf); // City + State
                            $('#cliente_bairro_cadastro').val(data.bairro); // Neighborhood
                            $('#cliente_rua_cadastro').val(data.logradouro); // Street
                            og('Incomplete or unexpected data structure received from the API.');
                        }
                    }
                },
                error: function () {
                    console.log('Error fetching address information.');
                }
            });
        }
    </script>


    @endsection