@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')


    <div class="container mt-5">

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

        <form action="{{ route('empresa_new_user', ['empresa' => $empresa->name]) }}" method="POST">
            @csrf
            <div class="form-floating mb-3">
                <div class="input-group">
                    <span class="input-group-text input-icon bg-gradient-success text-white"><i
                            class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="inputnome" name="user_name" placeholder="Nome completo"
                        style="padding: 0px 10px;">
                </div>
            </div>

            <div class="form-floating mb-3">
                <div class="input-group">
                    <span class="input-group-text input-icon bg-gradient-success text-white"><i
                            class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="inputemail" name="user_email" placeholder="E-mail"
                        style="padding: 0px 10px;">
                </div>
            </div>

            <div class="form-floating mb-3">
                <div class="input-group">
                    <span class="input-group-text input-icon bg-gradient-success text-white"><i
                            class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="inputpassword" name="user_password"
                        placeholder="Password" style="padding: 0px 10px;">
                </div>
            </div>

            <div class="form-floating mb-5">
                <div class="input-group">
                    <span class="input-group-text input-icon bg-gradient-success text-white"><i
                            class="fas fa-lock"></i></span>
                    <select class="form-control" id="tipo" name="user_tipo">
                        <option value="admin">Administrador(a)</option>
                        <option value="func">Funcionário(a)</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn bg-gradient-success text-white col-12"><i class="fas fa-user-plus"></i>
                Cadastrar</button>
        </form>

        <div class="table-responsive col-12" style="margin-top: 30px; padding: 1%;">
            <table class="table mt-5 mb-5">
                <thead class="bg-gradient-success text-white">
                    <tr>
                        <th class="rounded-left text-center">Nome</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Tipo</th>
                        <th class="rounded-right text-center">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Exemplo de linha na tabela -->
                    @foreach ($users as $user)
                        @if ($user->tipo != 'dev')
                            <tr>

                                <td class="align-middle text-center">{{ $user->name }}</td>
                                <td class="align-middle text-center">{{ $user->email }}</td>
                                <td class="align-middle text-center">{{ $user->tipo }}</td>
                                <td class="align-middle text-center">

                                    <form action="{{ route('empresa_view_user', ['empresa'=>$empresa->name,'id'=>$user->id]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn bg-gradient-success text-white"><i
                                                class="fa-solid fa-eye"></i></button>
                                    </form>

                                    <form action="{{ route('empresa_delete_user', ['empresa'=>$empresa->name,'id'=>$user->id]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn bg-gradient-danger text-white"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>

                                </td>

                            </tr>
                        @endif
                    @endforeach
                    <!-- Adicione mais linhas da tabela para cada usuário -->
                </tbody>
            </table>
        </div>
    </div>



@endsection
