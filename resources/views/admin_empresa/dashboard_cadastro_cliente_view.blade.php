@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')
    <style>
        .custom-input {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 0px 10px!important;
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

    <div class="container mt-5">
                    <form action="{{ route('Empresa_cadastro_cliente_att', ['empresa' => $empresa->name, 'id' => $cliente->id ]) }}"
                        method="POST">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_nome" name="cliente_nome" value="{{ $cliente->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-map-marked-alt"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_endereco" name="cliente_endereco" value="{{ $cliente->rua }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-building"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_numero" name="cliente_numero" value="{{ $cliente->numero }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-phone"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_telefone" name="cliente_telefone" value="{{ $cliente->celular }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-home"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_bairro" name="cliente_bairro" value="{{ $cliente->bairro }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-city"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input" id="cliente_cidade" name="cliente_cidade" value="{{ $cliente->cidade }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-money-bill-wave"></i>
                                        </span>
                                        <input type="number" class="form-control custom-input" id="valor_doacao" name="valor_doacao" value="{{ $cliente->valor }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <strong>R$</strong>
                                        </span>
                                        <select class="form-select custom-input" id="pagamento" name="cliente_pagamento">
                                            <option value="MENSAL" {{ $cliente->tipo_pagamento === 'MENSAL' ? 'selected' : '' }}>MENSAL</option>
                                            <option value="ÚNICA" {{ $cliente->tipo_pagamento === 'ÚNICA' ? 'selected' : '' }}>ÚNICA</option>
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
                                        <input type="date" class="form-control custom-input" id="data_doacao" name="vencimento" value="{{ $cliente->created_at->format('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <button type="submit" class="btn bg-gradient-success text-white col-6">Atualizar</button>
                            <a href="{{ route('Empresa_cadastro_cliente', ['empresa' => $empresa->name]) }}" class="btn bg-gradient-dark text-white col-6">Voltar</a>
                        </div>
                        
                        
                    </form>
                </div>
            </div>
@endsection
