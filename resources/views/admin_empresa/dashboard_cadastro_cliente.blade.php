@extends('layouts.admin_empresa_menu')

@section('title', 'Painel')

@section('content')

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>


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
                                @if ($cliente->celular == null)
                                    {{ $cliente->telefone_fixo }}
                                @elseif($cliente->celular && $cliente->telefone_fixo)
                                    FIXO: {{ $cliente->telefone_fixo }} - CEL: {{ $cliente->celular }}
                                @else
                                    {{ $cliente->celular }}
                                @endif
                            </td>

                            @if ($cliente->tipo == 'SAE')
                                <td class="align-middle text-center"><img src="{{ asset('img/sae.png') }}"
                                        style="max-width: 100px;"></td>
                            @else
                                <td class="align-middle text-center">MENSAL</td>
                            @endif
                            <td class="align-middle text-center">R$ {{ $cliente->valor }}</td>
                            <td class="align-middle text-center">{{ $cliente->created_at->format('d/m/Y') }}</td>
                            <td class="align-middle text-center">

                                @if ($cliente->situacao != 'PRIMEIRA')

                                <form action="{{ route('empresa_cadastro_emitindo_recibo', ['empresa' => $empresa->name, 'id' => $cliente->id]) }}" method="POST" id="reciboForm" style="display: none;">
                                @csrf
                                </form>
                            
                            <button type="button" class="btn" style="background-color: #38414A; color: white;" onclick="confirmarEnvioFormulario_{{ $cliente->id }}()">
                                1° RECIBO
                            </button>

                                <script>
                                    function imprimirRecibo_{{ $cliente->id }}() {
                                        // Dados do cliente e empresa (substitua pelos dados reais)
                                        var cliente = {
                                            name: "{{ $cliente->name }}",
                                            rua: "{{ $cliente->rua }}",
                                            numero: "{{ $cliente->numero }}",
                                            bairro: "{{ $cliente->bairro }}",
                                            cidade: "{{ $cliente->cidade }}",
                                            celular: "{{ $cliente->celular }}",
                                            telefone_fixo: "{{ $cliente->fixo }}",
                                            created_at: new Date(),
                                            obs: "{{ str_replace("\n", '<br>', addslashes($cliente->obs)) }}",
                                            id: "{{ $cliente->id }}",
                                            valor: "{{ $cliente->valor }}"
                                        };
                                
                                        var empresa = {
                                            name: "Associação Coração Acolhedor",
                                            cnpj: "29.450.986/0001-83",
                                            email: "associacaocoracaoacolhedor@gmail.com",
                                            whatsapp: "(34) 99680-9115",
                                            endereco: "Av. Geraldo Alves Tavares. 1991, Bairro Universitário - CEP 38.302-223 - Ituiutaba-MG"
                                        };
                                
                                        var htmlRecibo = `
                                            <div style="width: 58mm; text-align: left; font-family: 'Arial', sans-serif; font-size: 12px; line-height: 1.5;">
                                                <p style="font-weight: bold; font-size: 14px; text-align: center;">${empresa.name}</p>
                                                <p>CNPJ ${empresa.cnpj}</p>
                                                <p style="font-size: 12px;">${empresa.email}</p>
                                                <p>WhatsApp: ${empresa.whatsapp}</p>
                                                <p>${empresa.endereco}</p>
                                                <hr>
                                                <p style="font-weight: bold;">Recebemos de:</p>
                                                <p>${cliente.name}</p>
                                                <p style="font-weight: bold;">Endereço:</p>
                                                <p>${cliente.bairro} - ${cliente.rua} - ${cliente.numero} - ${cliente.cidade}</p>
                                                <p>Celular: ${cliente.celular}</p>
                                                <p>Fixo: ${cliente.telefone_fixo}</p>
                                                <p>Data/Hora: ${cliente.created_at.toLocaleDateString()}</p>
                                                <hr>
                                                <p style="font-weight: bold;">Observação:</p>
                                                <p>${cliente.obs}</p>
                                                <hr>
                                                <p style="font-weight: bold;">Referente a doação para a instituição:</p>
                                                <p>${empresa.name}</p>
                                                <p style="font-weight: bold;">Recibo ID:</p>
                                                <p>${cliente.id}</p>
                                                <p style="font-weight: bold;">Valor Total: R$ ${parseFloat(cliente.valor).toFixed(2)}</p>
                                                <hr>
                                            </div>
                                        `;
                                
                                        // Crie um iframe temporário
                                        var iframe = document.createElement('iframe');
                                        iframe.style.display = 'none';
                                        document.body.appendChild(iframe);
                                
                                        // Abra o documento do iframe
                                        var doc = iframe.contentWindow.document;
                                        doc.open();
                                        doc.write(htmlRecibo);
                                        doc.close();
                                
                                        // Adicione um ouvinte de evento para verificar quando a impressão for concluída
                                        iframe.contentWindow.addEventListener('afterprint', function() {
                                            // Após a impressão, redirecione para a rota desejada
                                            document.getElementById('reciboForm').submit();

                                        });
                                
                                        // Imprima o conteúdo do iframe
                                        iframe.contentWindow.print();
                                    }
                                
                                    function confirmarEnvioFormulario_{{ $cliente->id }}() {
                                        // Exibe um alerta de confirmação
                                        var confirmacao = confirm("Deseja realmente emitir o recibo?");
                                        
                                        // Se o usuário confirmar, envia o formulário
                                        if (confirmacao) {
                                            imprimirRecibo_{{ $cliente->id }}();
                                        }
                                    }
                                </script>
                                
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
                                    href="{{ route('empresa_termo_sae_route', ['empresa' => $empresa->name, 'id' => $cliente->id]) }}"><button
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
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Fechar">
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
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Fechar">
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
                                                                        @if ($doacao->cliente_id == $cliente->id)
                                                                            <td>{{ $doacao->id }}</td>
                                                                            <td>{{ $doacao->cliente->name }}</td>
                                                                            <td>R$ {{ $doacao->valor }}</td>
                                                                            <td>{{ $doacao->tipo }}</td>
                                                                            <td>{{ $doacao->created_at->format('d/m/Y') }}
                                                                            </td>
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
                                <div class="modal fade" id="dadosCliente_{{ $cliente->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Atualizar dados cliente
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Fechar">
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
                                                                    <input type="text"
                                                                        class="form-control custom-input"
                                                                        id="cliente_nome" name="cliente_nome"
                                                                        value="{{ $cliente->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <div class="input-group">
                                                                    <span
                                                                        class="input-group-text bg-gradient-success text-white">
                                                                        <i class="fa-solid fa-map-marked-alt"></i>
                                                                    </span>
                                                                    <input type="text"
                                                                        class="form-control custom-input"
                                                                        id="cliente_endereco" name="cliente_endereco"
                                                                        value="{{ $cliente->rua }}">
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
                                                                    <input type="text"
                                                                        class="form-control custom-input"
                                                                        id="cliente_numero" name="cliente_numero"
                                                                        value="{{ $cliente->numero }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <div class="input-group">
                                                                    <span
                                                                        class="input-group-text bg-gradient-success text-white">
                                                                        <i class="fa-solid fa-phone"></i>
                                                                    </span>
                                                                    <input type="text"
                                                                        class="form-control custom-input"
                                                                        id="cliente_telefone" name="cliente_telefone"
                                                                        value="{{ $cliente->celular }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <div class="input-group">
                                                                    <span
                                                                        class="input-group-text bg-gradient-success text-white">
                                                                        <i class="fa-solid fa-home"></i>
                                                                    </span>
                                                                    <input type="text"
                                                                        class="form-control custom-input"
                                                                        id="cliente_bairro" name="cliente_bairro"
                                                                        value="{{ $cliente->bairro }}">
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
                                                                    <input type="text"
                                                                        class="form-control custom-input"
                                                                        id="cliente_cidade" name="cliente_cidade"
                                                                        value="{{ $cliente->cidade }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 mb-3">
                                                                <div class="input-group">
                                                                    <span
                                                                        class="input-group-text bg-gradient-success text-white">
                                                                        <i class="fa-solid fa-money-bill-wave"></i>
                                                                    </span>
                                                                    <input type="number"
                                                                        class="form-control custom-input"
                                                                        id="valor_doacao" name="valor_doacao"
                                                                        value="{{ $cliente->valor }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label>Data vencimento:</label>
                                                                <div class="input-group">
                                                                    <span
                                                                        class="input-group-text bg-gradient-success text-white">
                                                                        <i class="fa-regular fa-calendar"></i>
                                                                    </span>
                                                                    <input type="date"
                                                                        class="form-control custom-input" id="data_doacao"
                                                                        value="{{ $cliente->created_at->format('Y-m-d') }}"
                                                                        name="vencimento">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label>Telefone fixo:</label>
                                                                <div class="input-group">
                                                                    <span
                                                                        class="input-group-text bg-gradient-success text-white">
                                                                        <i class="fa-solid fa-phone"></i>
                                                                    </span>
                                                                    <input type="number"
                                                                        class="form-control custom-input"
                                                                        id="cliente_fixo"
                                                                        value="{{ $cliente->telefone_fixo }}"
                                                                        name="telefone_fixo">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-3">
                                                            <label>Observação:</label>
                                                            <textarea class="form-control custom-input" id="observacao" name="observacao" rows="4">{{ $cliente->obs }}</textarea>
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

                    <form action="{{ route('Empresa_cadastro_cliente_add', ['empresa' => $empresa->name]) }}"
                        method="POST">
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
                                        <input type="text" class="form-control custom-input"
                                            id="cliente_bairro_cadastro" name="cliente_bairro" placeholder="Bairro">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-gradient-success text-white">
                                            <i class="fa-solid fa-city"></i>
                                        </span>
                                        <input type="text" class="form-control custom-input"
                                            id="cliente_cidade_cadastro" name="cliente_cidade" placeholder="Cidade">
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
                                <textarea class="form-control custom-input" id="observacao" name="observacao" rows="4" required></textarea>
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
                    success: function(data) {
                        console.log('API Response:', data); // Log the entire data object

                        if (data) {
                            // Check if the expected properties are present in the data object
                            if ('localidade' in data && 'uf' in data && 'bairro' in data && 'logradouro' in data) {
                                // Update the address fields with the retrieved data
                                $('#cliente_cidade_cadastro').val(data.localidade + ' - ' + data
                                .uf); // City + State
                                $('#cliente_bairro_cadastro').val(data.bairro); // Neighborhood
                                $('#cliente_rua_cadastro').val(data.logradouro); // Street
                                og('Incomplete or unexpected data structure received from the API.');
                            }
                        }
                    },
                    error: function() {
                        console.log('Error fetching address information.');
                    }
                });
            }
        </script>


    @endsection
