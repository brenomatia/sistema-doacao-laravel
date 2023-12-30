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

        <table class="table table-bordered">
            <thead class="bg-gradient-success text-white">
                <tr>
                    <th class="rounded-left text-center">Nome do Cliente</th>
                    <th class="text-center">Valor a receber</th>
                    <th class="text-center">Vencimento em</th>
                    <th class="rounded-right text-center">Opções</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    @if ($cliente->doador != 'EMITIDO')
                        <tr id="row_{{ $cliente->id }}">
                            @csrf
                            <td class="align-middle text-center">{{ $cliente->name }}</td>
                            <td class="align-middle text-center">
                                R$ {{ $cliente->valor }}
                            </td>
                            <td class="align-middle text-center">
                                <button
                                    class="btn bg-gradient-danger text-white">{{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y') }}</button><br>
                                Proxima parcela: <br>
                                <button
                                    class="btn bg-gradient-success text-white">{{ \Carbon\Carbon::parse($cliente->created_at)->addMonth()->format('d/m/Y') }}</button>
                            </td>
                            <td class="align-middle text-center">

                                <form
                                    action="{{ route('empresa_cadastro_processando_recibo', ['empresa' => $empresa->name, 'id' => $cliente->id]) }}"
                                    method="POST" id="reciboForm_areceber" style="display: none;">
                                    @csrf
                                    <input type="hidden"
                                        value="{{ \Carbon\Carbon::parse($cliente->created_at)->addMonth()->format('Y-m-d') }}"
                                        name="proximo_vencimento">
                                </form>

                                <button type="button" class="btn bg-gradient-danger text-white"
                                    onclick="confirmarEnvioFormulario_{{ $cliente->id }}()"><i
                                        class="fa-solid fa-file-waveform"></i> EMITIR</button>

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
                                            telefone_fixo: "{{ $cliente->telefone_fixo }}",
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
                                            document.getElementById('reciboForm_areceber').submit();

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
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
