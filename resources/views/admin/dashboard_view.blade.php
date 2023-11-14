@extends('layouts.admin_menu')

@section('title', 'Painel')

@section('content')

    <div class="container">

        <form action="{{ route('dashboard_view_empresa_atualizar', ['id' => $empresa->id ]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div>
                            <label>Logo cadastrada:</label>
                            <div style="padding: 10px; display: inline-block;">
                                <img src="{{ asset('logos_empresas/' . $empresa->logo) }}" alt="Logo da Empresa"
                                    width="150">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-3 d-flex justify-content-center">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-gradient-danger text-white">
                                    <i class="fa-solid fa-image"></i>
                                </span>
                            </div>
                            <input type="file" style="padding: 1% 3%;" class="form-control custom-input" name="file"
                                id="logoEmpresa">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="nomeEmpresa">Nome da Empresa</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-building"></i>
                                    </span>
                                </div>
                                <input type="text" style="padding: 0% 3%;" class="form-control" name="name"
                                    id="nomeEmpresa" value="{{ $empresa->name }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="enderecoEmpresa">Endereço da Empresa</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-map-marked-alt"></i>
                                    </span>
                                </div>
                                <input type="text" style="padding: 0% 3%;" class="form-control" name="endereco"
                                    id="enderecoEmpresa" value="{{ $empresa->endereco }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="nomeBancoDados">Nome do Banco de Dados</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-database"></i>
                                    </span>
                                </div>
                                <input type="text" style="padding: 0% 3%;" class="form-control" name="database_name"
                                    id="nomeBancoDados" value="{{ $empresa->database_name }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="hostBancoDados">Host do Banco de Dados</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-server"></i>
                                    </span>
                                </div>
                                <input type="text" style="padding: 0% 3%;" class="form-control" name="database_host"
                                    id="hostBancoDados" value="{{ $empresa->database_host }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="portaBancoDados">Porta do Banco de Dados</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-door-open"></i>
                                    </span>
                                </div>
                                <input type="text" style="padding: 0% 3%;" class="form-control" name="database_port"
                                    id="portaBancoDados" value="{{ $empresa->database_port }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="usuarioBancoDados">Usuário do Banco de Dados</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" style="padding: 0% 3%;" class="form-control"
                                    name="database_username" id="usuarioBancoDados"
                                    value="{{ $empresa->database_username }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="senhaBancoDados">Senha do Banco de Dados</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-danger text-white">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                </div>
                                <input type="password" style="padding: 0% 3%" class="form-control"
                                    name="database_password" id="senhaBancoDados">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('dashboard_cadastrar_empresa') }}"><button type="button" class="btn bg-gradient-danger text-white">Voltar</button></a>
                <button type="submit" class="btn bg-gradient-danger text-white">Atualizar</button>
            </div>
        </form>
    </div>
@endsection
