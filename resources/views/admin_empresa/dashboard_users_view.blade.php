@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')


    <div class="container mt-5">

        <form action="{{ route('empresa_update_user', ['empresa'=>$empresa->name,'id'=>$cliente->id])}}" method="POST">
            @csrf
            <div class="form-floating mb-3">
                <div class="input-group">
                    <span class="input-group-text input-icon bg-gradient-success text-white"><i
                            class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="inputnome" name="user_name" value="{{ $cliente->name }}"
                        style="padding: 0px 10px;">
                </div>
            </div>

            <div class="form-floating mb-3">
                <div class="input-group">
                    <span class="input-group-text input-icon bg-gradient-success text-white"><i
                            class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="inputemail" name="user_email"
                        value="{{ $cliente->email }}" style="padding: 0px 10px;">
                </div>
            </div>

            <div class="form-floating mb-3">
                <div class="input-group">
                    <span class="input-group-text input-icon bg-gradient-success text-white"><i
                            class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="inputpassword" name="user_password"
                        placeholder="password" style="padding: 0px 10px;">
                </div>
            </div>

            <div class="form-floating mb-5">
                <div class="input-group">
                    <span class="input-group-text input-icon bg-gradient-success text-white"><i
                            class="fas fa-lock"></i></span>
                    <select class="form-control" id="tipo" name="user_tipo">
                        <option value="admin" {{ $cliente->tipo === 'admin' ? 'selected' : '' }}>Administrador(a)</option>
                        <option value="func" {{ $cliente->tipo === 'func' ? 'selected' : '' }}>Funcionário(a)</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn bg-gradient-success text-white col-12">
                Atualizar cliente
            </button>
            <a href="{{ route('empresa_usuarios', ['empresa' => $empresa->name]) }}">
                <button type="button" class="btn bg-gradient-dark text-white col-12 mt-3">
                    Voltar
                </button>
            </a>
        </form>


    </div>



@endsection
