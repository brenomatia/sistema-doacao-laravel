@extends('layouts.admin_menu')

@section('title', 'Painel')

@section('content')
    <style>
        .custom-input {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            background-color: #f5f5f5;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .custom-input:focus {
            border-color: #E64D4D;
            box-shadow: 0 0 5px rgba(126, 95, 228, 0.5);
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #E64D4D;
            border: none;
        }

        .btn-primary:hover {
            background-color: #E64D4D;
        }

        .modal-title {
            color: #E64D4D;
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
            background-color: #E64D4D;
        }

        .table {
            background-color: #fff;
        }

        .table thead th {
            background-color: #E64D4D;
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
        <!-- Botão para abrir o modal -->
        <button type="button" class="btn bg-gradient-danger text-white" data-toggle="modal" data-target="#myModal">
            +
        </button>

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
        <div class="table-responsive" style="margin-top: 30px; padding: 1%;">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th class="rounded-left text-center">Brand</th>
                        <th class="text-center">Nome empresa</th>
                        <th class="text-center">Endereço</th>
                        <th class="rounded-right text-center">Opções</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td class="align-middle text-center"><img src="{{ asset('logos_empresas/' . $empresa->logo) }}"
                                    alt="Logo da Empresa" width="100"></td>
                            <td class="align-middle text-center">{{ $empresa->name }}</td>
                            <td class="align-middle text-center">{{ $empresa->endereco }}</td>
                            <td class="align-middle text-center">
                                <form action="{{ route('dashboard_view_empresa', ['id' => $empresa->id])}}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button class="btn btn-warning"><i class="fa-solid fa-eye"></i></button>
                                </form>

                                <a style="display: inline-block; margin-left: 9px;" target="_blank" class="btn btn-primary" href="{{ route('index', ['empresa' => $empresa->name ]) }}"><i class="fa-solid fa-door-open"></i></a>

                                <form action="{{ route('dashboard_deletar_empresa', ['id' => $empresa->id]) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                            <!-- Outras colunas aqui -->
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
                    <!-- Formulário dentro do modal
                    <form>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input" id="nomeCompleto" placeholder="Nome" required >
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-map-marked-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input" id="endereco" placeholder="End" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-building"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input" id="numero" placeholder="N°" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-phone"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input" id="telefone" placeholder="Celular" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="date" style="padding: 0% 3%;" class="form-control custom-input" id="data" placeholder="Data" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input" id="valor" placeholder="Valor" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-home"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input" id="bairro" placeholder="Bairro" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-city"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input" id="cidade" placeholder="Cidade" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    -->


                    <form action="{{ route('dashboard_cadastrar_empresa_cadastrando') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 mb-3 d-flex justify-content-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-image"></i>
                                            </span>
                                        </div>
                                        <input type="file" style="padding: 1% 3%;" class="form-control custom-input"
                                            name="file" id="logoEmpresa" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-building"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input"
                                            name="name" id="nomeEmpresa" placeholder="Nome da Empresa" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-map-marked-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input"
                                            name="endereco" id="enderecoEmpresa" placeholder="Endereço da Empresa"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-database"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input"
                                            name="database_name" id="nomeBancoDados" placeholder="Nome do Banco de Dados"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-server"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input"
                                            name="database_host" id="hostBancoDados" placeholder="Host do Banco de Dados"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-door-open"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input"
                                            name="database_port" id="portaBancoDados"
                                            placeholder="Porta do Banco de Dados" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" style="padding: 0% 3%;" class="form-control custom-input"
                                            name="database_username" id="usuarioBancoDados"
                                            placeholder="Usuário do Banco de Dados" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-danger text-white">
                                                <i class="fa-solid fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" style="padding: 0% 3%;" class="form-control custom-input"
                                            name="database_password" id="senhaBancoDados"
                                            placeholder="Senha do Banco de Dados" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-danger text-white" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn bg-gradient-success text-white">Cadastrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>


@endsection
