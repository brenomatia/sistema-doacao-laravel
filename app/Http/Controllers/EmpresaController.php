<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Doacao;
use App\Models\User;
use App\Models\Mod;
use App\Models\EmAberto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class EmpresaController extends Controller
{
    public function index(Request $request, $empresa)
    {

        $empresa = Empresa::where("name", $empresa)->first();

        // Cria o banco de dados da empresa
        DB::statement('CREATE DATABASE IF NOT EXISTS ' . $empresa->database_name);

        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        // Executa a migração para criar as tabelas da empresa
        Artisan::call('migrate', [
            '--database' => 'empresa',
            '--path' => 'database/migrations/empresa',
        ]);

        // Retorna a view com os dados da empresa.
        return view('home_empresa.login', compact('empresa'));
    }

    public function Empresa_cadastro(Request $request, $empresa)
    {
        $empresa = Empresa::where("name", $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        return view('home_empresa.cadastro', compact('empresa'));
    }

    public function Empresa_cadastro_new_user(Request $request, $empresa)
    {

        $empresa = Empresa::where("name", $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        $user = User::where('email', request('user_email'))->first();

        if ($user) {
            return back()->with('error', 'O email já está cadastrado.');
        } else {
            $newUser = new User();
            $newUser->name = request('user_name');
            $newUser->email = request('user_email');
            $newUser->tipo = "cliente";
            $newUser->password = bcrypt(request('user_password'));
            $newUser->save();

            if ($newUser) {
                return back()->with('success', 'Cadastro realizado com êxito.');
            } else {
                return back()->with('error', 'Ops, algo deu errado.');
            }
        }

    }
    public function Empresa_login(Request $request, $empresa)
    {

        $empresa = Empresa::where("name", $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {


            if (!$request->user()) {
                return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
            }

            return redirect()->route('Empresa_dashboard', ['empresa' => $empresa->name]); // Redirecionar para a página de destino após o login


        }

        return back()->with('error', 'Credenciais inválidas. Por favor, tente novamente.');
    }
    public function Empresa_dashboard(Request $request, $empresa)
    {

        $empresa = Empresa::where("name", $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        // Total de clientes e valor do mês atual
        $clientes_atual = Cliente::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $valor_atual = EmAberto::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('status', 'FECHADO')
            ->sum('valor');


        // Total de clientes e valor do mês passado
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $clientes_passado = Cliente::whereYear('created_at', $lastMonthStart->year)
            ->whereMonth('created_at', $lastMonthStart->month)
            ->count();
        $valor_passado = EmAberto::whereYear('created_at', $lastMonthStart->year)
            ->whereMonth('created_at', $lastMonthStart->month)
            ->where('status', 'FECHADO')
            ->sum('valor');

        $tiquete_medio_base_atual = 0;
        $tiquete_medio_base_passado = 0;
        $porcentagem_tiquete = 0;

        if ($valor_atual != 0 && $clientes_atual != 0) {
            $tiquete_medio_base_atual = $valor_atual / $clientes_atual;
        }

        if ($valor_passado != 0 && $clientes_passado != 0) {
            $tiquete_medio_base_passado = $valor_passado / $clientes_passado;
        }

        if ($tiquete_medio_base_atual != 0 && $tiquete_medio_base_passado != 0) {
            $tiquete_medio_total = $tiquete_medio_base_atual / $tiquete_medio_base_passado;
            $porcentagem_tiquete = number_format(($tiquete_medio_total - 1) * 100, 2, '.', '');
        }

        $tiquete_cliente = 0;
        $porcetagem_tiquete_clientes = 0;

        if ($clientes_atual != 0 && $clientes_passado != 0) {
            $tiquete_cliente = $clientes_atual / $clientes_passado;
            $porcetagem_tiquete_clientes = number_format(($tiquete_cliente - 1) * 100, 2, '.', '');
        }

        $tiquete_total = 0;
        $porcetagem_tiquete_total = 0;

        if ($valor_atual != 0 && $valor_passado != 0) {
            $tiquete_total = $valor_atual / $valor_passado;
            $porcetagem_tiquete_total = number_format(($tiquete_total - 1) * 100, 2, '.', '');
        }
        $ultimosRegistros = Cliente::latest()->limit(5)->get();
        $ultimosAlteracoes = Mod::latest()->limit(5)->get();
        return view('admin_empresa.dashboard', compact('ultimosAlteracoes', 'ultimosRegistros', 'empresa', 'tiquete_cliente', 'porcetagem_tiquete_total', 'porcetagem_tiquete_clientes', 'tiquete_medio_base_atual', 'tiquete_medio_base_passado', 'porcentagem_tiquete', 'valor_atual', 'valor_passado', 'clientes_atual', 'clientes_passado'));
    }














    public function Empresa_logout(Request $request, $empresa)
    {
        $empresa = Empresa::where("name", $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        Auth::logout();
        return redirect()->route('index', ['empresa' => $empresa->name]);
    }

    public function Empresa_cadastro_cliente(Request $request, $empresa)
    {

        $empresa = Empresa::where("name", $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $clientes = Cliente::orderBy('name')->paginate(10);
        $doacoes = Doacao::paginate(10);

        return view('admin_empresa.dashboard_cadastro_cliente', compact('empresa', 'clientes', 'doacoes'));
    }

    public function Empresa_cadastro_cliente_add(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();

        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $request->validate([
            'cliente_nome' => 'required|string|max:255',
            'valor_doacao' => 'required|numeric',
            'vencimento' => 'required|date',
            'cliente_endereco' => 'nullable|string|max:255',
            'cliente_numero' => 'nullable|string|max:255',
            'cliente_telefone' => 'nullable|string|max:15',
            'cliente_bairro' => 'nullable|string|max:255',
            'cliente_cidade' => 'nullable|string|max:255',
            'telefone_fixo' => 'nullable|string|max:15',
            'observacao' => 'nullable|string|max:255',
        ]);

        $clienteExistente = DB::table('clientes')
            ->whereRaw('LOWER(name) = LOWER(?)', [$request->input('cliente_nome')])
            ->first();

        if ($clienteExistente) {
            return redirect()->back()->with('error', 'Cliente já cadastrado na base de dados.');
        }

        $cliente = new Cliente();
        $cliente->registro_id = Auth::user()->id;
        $cliente->name = $request->input('cliente_nome');
        $cliente->rua = $request->input('cliente_endereco');
        $cliente->numero = $request->input('cliente_numero');
        $cliente->celular = $request->input('cliente_telefone');
        $cliente->bairro = $request->input('cliente_bairro');
        $cliente->telefone_fixo = $request->input('telefone_fixo');
        $cliente->cidade = $request->input('cliente_cidade');
        $cliente->valor = $request->input('valor_doacao');
        $cliente->obs = $request->input('observacao');
        $cliente->created_at = date('Y-m-d', strtotime($request->input('vencimento')));

        $cliente->save();

        $cliente_log = new Mod();
        $cliente_log->name = Auth::user()->name;
        $cliente_log->tipo = "CADASTRO";
        $cliente_log->cliente_id = Auth::user()->id;
        $cliente_log->registro_acao = 'Cadastrou o cliente: ' . $request->input('cliente_nome') . '.';
        $cliente_log->save();

        return redirect()->route('Empresa_cadastro_cliente', ['empresa' => $empresa->name])->with('success', 'Cliente cadastrado(a) com sucesso!');
    }

    public function Empresa_cadastro_cliente_deletar(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $cliente = Cliente::find($id);
        $cliente->delete();

        $historico = Doacao::where('cliente_id', $id);
        $historico->delete();

        return redirect()->route('Empresa_cadastro_cliente', ['empresa' => $empresa->name])->with('success', 'Sucesso, Cliente excluído.');

    }
    public function Empresa_cadastro_cliente_view(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $cliente = Cliente::find($id);

        return view('admin_empresa.dashboard_cadastro_cliente_view', compact('empresa', 'cliente'));
    }

    public function Empresa_cadastro_cliente_att(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        // Recupera o cliente existente pelo ID
        $cliente = Cliente::find($id);
        // Valide os dados do formulário
        $request->validate([
            'cliente_nome' => 'required|string',
            'cliente_endereco' => 'string|nullable',
            'cliente_numero' => 'string|nullable',
            'cliente_telefone' => 'string|nullable',
            'cliente_bairro' => 'string|nullable',
            'cliente_cidade' => 'string|nullable',
            'cliente_pagamento' => 'string|nullable',
        ]);

        // Encontre o cliente pelo ID
        $cliente = Cliente::find($id);

        // Atualize os campos com os dados do formulário
        $cliente->name = $request->input('cliente_nome');
        $cliente->rua = $request->input('cliente_endereco');
        $cliente->numero = $request->input('cliente_numero');
        $cliente->celular = $request->input('cliente_telefone');
        $cliente->bairro = $request->input('cliente_bairro');
        $cliente->cidade = $request->input('cliente_cidade');
        $cliente->tipo_pagamento = $request->input('cliente_pagamento');
        $cliente->created_at = $request->input('vencimento');
        $cliente->telefone_fixo = $request->input('telefone_fixo');
        $cliente->obs = $request->input('observacao');
        $cliente->valor = $request->input('valor_doacao');

        // Salve as alterações no banco de dados
        $cliente->save();

        if ($cliente) {
            return redirect()->route('Empresa_cadastro_cliente', ['empresa' => $empresa->name])->with('success', 'Cliente atualizado(a) com sucesso!');
        } else {
            return redirect()->route('Empresa_cadastro_cliente', ['empresa' => $empresa->name])->with('error', 'Algo deu errado ajuste!');
        }
    }
    public function empresa_gerarecibo(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $cliente = Cliente::find($id);
        $historicos = Doacao::where('id_cliente', $id)->get();

        return view('admin_empresa.dashboard_gerar_recibo', compact('cliente', 'empresa', 'historicos'));
    }

    public function empresa_areceber(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $lastMonth = now()->subMonth(); // Data do mês passado
        $dayOfMonth = $lastMonth->day; // Dia do mês no mês passado

        $clientes = DB::table('clientes')
            ->whereDay('created_at', $dayOfMonth)
            ->whereMonth('created_at', $lastMonth->month)
            ->get();

        return view('admin_empresa.dashboard_areceber', compact('empresa', 'clientes'));

    }


    public function empresa_doadores_localizar(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $searchTerm = $request->input('search');

        $clientes = Cliente::where('name', 'like', "$searchTerm%")
            ->orWhere('celular', 'like', "%$searchTerm%")
            ->orderBy('name')
            ->get();

        $doacoes = Doacao::all();

        return view('admin_empresa.dashboard_doacao_localizado', compact('empresa', 'clientes', 'doacoes'));
    }

    public function empresa_registrar_doacao(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        $doacao = new Doacao();
        $doacao->valor = $request->input('valor_doado');
        $doacao->cliente_id = $id;
        $doacao->data_doacao = now();
        $doacao->save();

        Cliente::where('id', $id)->update([
            'doador' => "Sim",
            'valor' => $request->input('valor_doado'),
        ]);

        return redirect()->route('empresa_doações', ['empresa' => $empresa->name])->with('success', 'Doador registrado com sucesso!');

    }

    public function empresa_areceber_emitir(Request $request, $empresa, $doacao_id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        $cliente = Cliente::find($doacao_id);
        $logo = $empresa->logo;
        $data = now();

        return view('admin_empresa.dashboard_processa', compact('empresa', 'logo', 'cliente', 'data'));
    }

    public function empresa_cadastro_cliente_primeira(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $logo = $empresa->logo;
        $cliente = Cliente::find($id);
        $data = now();

        return view('admin_empresa.dashboard_processa_recibo', compact('empresa', 'logo', 'cliente', 'data'));
    }




































    public function empresa_cadastro_emitindo_recibo(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();

        // Configurar a conexão com o banco de dados da empresa
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        try {

            $cliente = Cliente::find($id);

            //dd($cliente);

            $cliente->situacao = "PRIMEIRAVIA";
            $cliente->save();

            $aberto = new EmAberto();
            $aberto->cliente_id = $cliente->id;
            $aberto->valor = $cliente->valor;
            $aberto->nome_cliente = $cliente->name;
            $aberto->gerou_recibo_id = Auth::user()->id;
            $aberto->end_cliente = $cliente->rua . ' - ' . $cliente->numero . ', ' . $cliente->bairro . ', ' . $cliente->cidade;
            $aberto->status = "ABERTO";
            $aberto->save();

            $cliente_log = new Mod();
            $cliente_log->name = Auth::user()->name;
            $cliente_log->tipo = "GEROU RECIBO";
            $cliente_log->cliente_id = Auth::user()->id;
            $cliente_log->registro_acao = 'Gerou o recibo do cliente: ' . $cliente->name . '.';
            $cliente_log->save();

            // Retorne uma mensagem de sucesso
            //return response()->json(['success' => true, 'message' => 'Impressão concluída com sucesso.']);
            return redirect()->route('Empresa_cadastro_cliente', ['empresa'=>$empresa->name])->with('success', 'Recibo gerado com sucesso!');

        } catch (\Exception $e) {
            // Retorne uma mensagem de erro
            return response()->json(['success' => false, 'message' => 'Erro ao imprimir: ' . $e->getMessage()]);
        }
    }




























































    public function empresa_logs(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $logs_geral = Mod::all();
        $logs = [];

        foreach ($logs_geral as $log) {
            $logs[] = [
                'timestamp' => $log->created_at->format('d/m/Y H:i:s'),
                'name' => $log->name . '',
                'message' => $log->registro_acao,
            ];
        }

        $users = User::all();

        // Intervalo de datas para o mês corrente
        $dataInicio = Carbon::now()->startOfMonth();
        $dataFim = Carbon::now()->endOfMonth();

        // Intervalo de datas para o mês anterior
        $dataInicioMesAnterior = Carbon::now()->subMonth()->startOfMonth();
        $dataFimMesAnterior = Carbon::now()->subMonth()->endOfMonth();

        // Contagem de cadastros
        $totalCadastro = Mod::where('tipo', 'CADASTRO')
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->count();

        $totalCadastroMesAnterior = Mod::where('tipo', 'CADASTRO')
            ->whereBetween('created_at', [$dataInicioMesAnterior, $dataFimMesAnterior])
            ->count();

        // Contagem de finalizados
        $totalFinalizadoMesAtual = Mod::where('tipo', 'FINALIZADO')
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->count();

        $totalFinalizadoMesAnterior = Mod::where('tipo', 'FINALIZADO')
            ->whereBetween('created_at', [$dataInicioMesAnterior, $dataFimMesAnterior])
            ->count();

        // Calcular a porcentagem de crescimento de cadastros
        $porcentagem_tiquete_clientes = ($totalCadastroMesAnterior > 0) ? (($totalCadastro - $totalCadastroMesAnterior) / abs($totalCadastroMesAnterior)) * 100 : 0;

        // Calcular a porcentagem de crescimento de finalizados
        $porcentagem_finalizados = ($totalFinalizadoMesAnterior > 0) ? (($totalFinalizadoMesAtual - $totalFinalizadoMesAnterior) / abs($totalFinalizadoMesAnterior)) * 100 : 0;

        // Calcular outras porcentagens conforme necessário
        $porcentagem_total = ($totalCadastro > 0) ? ($totalFinalizadoMesAtual / $totalCadastro) * 100 : 0;

        return view('admin_empresa.dashboard_logs', compact('porcentagem_total', 'logs', 'empresa', 'users', 'totalCadastro', 'totalCadastroMesAnterior', 'porcentagem_tiquete_clientes', 'totalFinalizadoMesAtual', 'totalFinalizadoMesAnterior', 'porcentagem_finalizados'));


    }

    public function empresa_logs_pesquisa(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');


        //dd($request->all());


        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $user = User::find($request->input('id'));
        $logs_geral = Mod::where('name', $user->name)->get();

        $logs = [];

        foreach ($logs_geral as $log) {
            $logs[] = [
                'timestamp' => $log->created_at->format('d/m/Y H:i:s'),
                'name' => $log->name . '',
                'message' => $log->registro_acao,
            ];
        }
        // Intervalo de datas para o mês corrente
        $dataInicio = Carbon::now()->startOfMonth();
        $dataFim = Carbon::now()->endOfMonth();

        // Intervalo de datas para o mês anterior
        $dataInicioMesAnterior = Carbon::now()->subMonth()->startOfMonth();
        $dataFimMesAnterior = Carbon::now()->subMonth()->endOfMonth();

        // Contagem de cadastros
        $totalCadastro = Mod::where('tipo', 'CADASTRO')
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('cliente_id', $user->id)
            ->count();

        $totalCadastroMesAnterior = Mod::where('tipo', 'CADASTRO')
            ->whereBetween('created_at', [$dataInicioMesAnterior, $dataFimMesAnterior])
            ->where('cliente_id', $user->id)
            ->count();

        // Contagem de finalizados
        $totalFinalizadoMesAtual = Mod::where('tipo', 'FINALIZADO')
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('cliente_id', $user->id)
            ->count();

        $totalFinalizadoMesAnterior = Mod::where('tipo', 'FINALIZADO')
            ->whereBetween('created_at', [$dataInicioMesAnterior, $dataFimMesAnterior])
            ->where('cliente_id', $user->id)
            ->count();

        // Calcular a porcentagem de crescimento de cadastros
        $porcentagem_tiquete_clientes = ($totalCadastroMesAnterior > 0) ? (($totalCadastro - $totalCadastroMesAnterior) / abs($totalCadastroMesAnterior)) * 100 : 0;

        // Calcular a porcentagem de crescimento de finalizados
        $porcentagem_finalizados = ($totalFinalizadoMesAnterior > 0) ? (($totalFinalizadoMesAtual - $totalFinalizadoMesAnterior) / abs($totalFinalizadoMesAnterior)) * 100 : 0;

        // Calcular outras porcentagens conforme necessário
        $porcentagem_total = ($totalCadastro > 0) ? ($totalFinalizadoMesAtual / $totalCadastro) * 100 : 0;

        return view('admin_empresa.dashboard_logs_pesquisa', compact('porcentagem_total', 'logs', 'empresa', 'user', 'totalCadastro', 'totalCadastroMesAnterior', 'porcentagem_tiquete_clientes', 'totalFinalizadoMesAtual', 'totalFinalizadoMesAnterior', 'porcentagem_finalizados'));

    }
































    public function empresa_cadastro_processando_recibo(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();

        // Configurar a conexão com o banco de dados da empresa
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        try {

            $cliente = Cliente::find($id);
            $cliente->doador = "EMITIDO";
            $cliente->created_at = request('proximo_vencimento');
            $cliente->save();

            $aberto = new EmAberto();
            $aberto->cliente_id = $cliente->id;
            $aberto->valor = $cliente->valor;
            $aberto->nome_cliente = $cliente->name;
            $aberto->gerou_recibo_id = Auth::user()->id;
            $aberto->end_cliente = $cliente->rua . ' - ' . $cliente->numero . ', ' . $cliente->bairro . ', ' . $cliente->cidade;
            $aberto->status = "ABERTO";
            $aberto->save();

            $cliente_log = new Mod();
            $cliente_log->name = Auth::user()->name;
            $cliente_log->tipo = "GEROU RECIBO";
            $cliente_log->cliente_id = Auth::user()->id;
            $cliente_log->registro_acao = 'Gerou o recibo do cliente: ' . $cliente->name . '.';
            $cliente_log->save();

            // Retorne uma mensagem de sucesso
            //return response()->json(['success' => true, 'message' => 'Impressão concluída com sucesso.']);
            return back()->with('success', 'Recibo do cliente ' . $cliente->name . ' gerado com sucesso!');
        } catch (\Exception $e) {
            // Retorne uma mensagem de erro
            return response()->json(['success' => false, 'message' => 'Erro ao imprimir: ' . $e->getMessage()]);
        }
    }

































    public function empresa_usuarios(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $users = User::all();
        return view('admin_empresa.dashboard_users', compact('empresa', 'users'));
    }

    public function empresa_new_user(Request $request, $empresa)
    {

        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $users = new User();
        $users->name = $request->input('user_name');
        $users->email = $request->input('user_email');
        $users->tipo = $request->input('user_tipo');
        $users->password = bcrypt($request->input('user_password'));
        $users->save();

        return back()->with('success', 'Cadastro realizado com sucesso!');

    }

    public function empresa_view_user(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $cliente = User::find($id);

        return view('admin_empresa.dashboard_users_view', compact('empresa', 'cliente'));
    }

    public function empresa_update_user(Request $request, $empresa, $id)
    {

        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $newUser = User::find($id);
        $newUser->name = request('user_name');
        $newUser->email = request('user_email');
        $newUser->tipo = request('user_tipo');
        $newUser->password = bcrypt(request('user_password'));
        $newUser->save();

        return redirect()->route('empresa_usuarios', ['empresa' => $empresa->name])->with('success', 'Cliente atualizado com sucesso!');
    }

    public function empresa_delete_user(Request $request, $empresa, $id)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $deleteUser = User::find($id);
        $deleteUser->delete();

        return redirect()->route('empresa_usuarios', ['empresa' => $empresa->name])->with('success', 'Cliente atualizado com sucesso!');
    }

    public function empresa_baixar(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $abertos = EmAberto::where('status', 'ABERTO')
        ->orderBy('nome_cliente', 'asc') // Substitua 'nome_cliente' pelo nome real da coluna que deseja ordenar
        ->paginate(20);    

        return view('admin_empresa.dashboard_recibos', compact('empresa', 'abertos'));
    }



    public function empresa_baixar_recibos_pesquisa(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $searchTerm = request('search');

        $abertos = EmAberto::where('status', 'ABERTO')
            ->where('nome_cliente', 'like', '%' . $searchTerm . '%')
            ->orderBy('nome_cliente', 'asc')
            ->paginate(20);

        return view('admin_empresa.dashboard_recibos_localizado', compact('empresa', 'abertos'));

    }















    public function empresa_dar_baixa_em_recibos(Request $request, $empresa, $cliente_id, $id)
    {

        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        //dd($request->all());

        $tipo_pagamento = request('metodo_pagamento');

        $atualizar_status = EmAberto::find($id);
        $atualizar_status->status = "FECHADO";
        $atualizar_status->save();

        $atualizar_created_at_clientes = Cliente::find($cliente_id);

        $atualizar_created_at_clientes->valor = request('new_valor');

        // Obtenha a data do campo new_date
        $novaData = Carbon::parse($request->input('new_date'));

        // Subtraia um mês da data
        $novaData = $novaData->subMonth();

        // Atualize o campo new_date com a nova data formatada
        $request->merge(['new_date' => $novaData->toDateString()]);

        // Resto do seu código
        $atualizar_created_at_clientes->created_at = request('new_date');

        $atualizar_created_at_clientes->save();

        // PAREI AQUI --------------------------------------------------------------------------------------------------------------
        $cliente_log = new Mod();
        $cliente_log->tipo = "FINALIZADO";
        $cliente_log->name = Auth::user()->name;
        $cliente_log->cliente_id = $atualizar_created_at_clientes->registro_id;

        $user = User::find($atualizar_status->gerou_recibo_id);

        $cliente_log->registro_acao = '( FINALIZADO ) Doador: ' . $atualizar_status->nome_cliente . ' - Funcionário: ' . $user->name;
        $cliente_log->save();

        $registrar_doação = new Doacao();
        $registrar_doação->cliente_id = $cliente_id;
        $registrar_doação->tipo = $tipo_pagamento;
        $registrar_doação->valor = $atualizar_created_at_clientes->valor;
        $registrar_doação->save();


        return redirect()->route('empresa_baixar', ['empresa'=>$empresa->name])->with('success', 'Recibo baixado com sucesso!');

    }

    public function empresa_termo_sae_route(Request $request, $empresa, $id)
    {

        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $cliente = Cliente::find($id);
        return view('admin_empresa.dashboard_termo', compact('empresa', 'cliente'));
    }

    public function empresa_gerando_termo_sae(Request $request, $empresa, $id)
    {

        $empresa = Empresa::where('name', $empresa)->first();
        // Cria uma nova conexão com o banco de dados da empresa.
        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        // Configura a conexão com o banco de dados da empresa para que fique disponível em todo o escopo da aplicação.
        DB::setDefaultConnection('empresa');

        $cliente = Cliente::find($id);
        $cliente->tipo = "SAE";
        $cliente->save();

        $logo = $empresa->logo;
        $data = now();
        $isPdf = true; // Indica que o PDF está sendo gerado

        $dompdf = new Dompdf();

        // Carregue a view e converta para HTML
        $html = view('admin_empresa.dashboard_termo', compact('cliente', 'empresa', 'data', 'logo', 'isPdf'))->render();

        // Carregue o HTML no Dompdf
        $dompdf->loadHtml($html);

        // Renderize o PDF com um nome de arquivo personalizado
        $dompdf->render();
        $filename = $cliente->name . '_termosae.pdf'; // Defina o nome do arquivo com base no nome do cliente

        // Exiba o PDF no navegador com o nome de arquivo personalizado
        return $dompdf->stream($filename);
    }

    public function empresa_metricas(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();

        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $doacoesMesAtual = Doacao::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('valor');

        $doacoesMesPassado = Doacao::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('valor');

        $doacoesPorTipo = Doacao::select('tipo', \DB::raw('SUM(valor) as total_valor'))
            ->groupBy('tipo')
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => $item->tipo,
                    'total_valor' => (float) $item->total_valor,
                ];
            })
            ->unique('tipo'); // Garante tipos de doação únicos

        $clientesContribuicao = Cliente::select(
            'clientes.id',
            'clientes.name',
            DB::raw('SUM(doacoes.valor) as contribuicao_total')
        )
            ->leftJoin('doacoes', 'clientes.id', '=', 'doacoes.cliente_id')
            ->groupBy('clientes.id', 'clientes.name')
            ->orderByDesc('contribuicao_total')
            ->take(5) // Obter apenas os top 5
            ->get();

        $statusDoacoesEmAberto = EmAberto::select(
            'status',
            DB::raw('COUNT(*) as quantidade')
        )
            ->groupBy('status')
            ->get();



        $projecoes = [];

        // Calcular a soma do mês atual
        $dataAtual = now();
        $primeiroDiaMesAtual = $dataAtual->firstOfMonth()->format('Y-m-d');
        $ultimoDiaMesAtual = $dataAtual->lastOfMonth()->format('Y-m-d');

        $somaMesAtual = Cliente::whereBetween('created_at', [$primeiroDiaMesAtual, $ultimoDiaMesAtual])
            ->sum('valor');

        // Calcular projeção para o próximo mês
        $dataProximoMes = now()->addMonth();
        $primeiroDiaProximoMes = $dataProximoMes->firstOfMonth()->format('Y-m-d');
        $ultimoDiaProximoMes = $dataProximoMes->lastOfMonth()->format('Y-m-d');

        $projecaoProximoMes = [
            'data' => $dataProximoMes->format('M Y'),
            'valor' => $somaMesAtual,
        ];

        $projecoes[] = $projecaoProximoMes;

        // Mês atual
        $total_cadastros_sae = Cliente::whereBetween('created_at', [$primeiroDiaMesAtual, $ultimoDiaMesAtual])->where('tipo', 'SAE')->count();
        $total_valor_sae = Cliente::whereBetween('created_at', [$primeiroDiaMesAtual, $ultimoDiaMesAtual])->where('tipo', 'SAE')->sum('valor');

        // Mês passado
        $mesPassado_total_cadastros_sae = Cliente::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->where('tipo', 'SAE')->count();

        $mesPassado_total_valor_sae = Cliente::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->where('tipo', 'SAE')->sum('valor');

        // Calcular a porcentagem de crescimento
        $porcentagem_crescimento_cadastros = ($total_cadastros_sae - $mesPassado_total_cadastros_sae) / ($mesPassado_total_cadastros_sae ?: 1) * 100;
        $porcentagem_crescimento_valor = ($total_valor_sae - $mesPassado_total_valor_sae) / ($mesPassado_total_valor_sae ?: 1) * 100;

        // Formatar a porcentagem para exibição
        $porcentagem_crescimento_cadastros_formatada = sprintf("%.2f%%", $porcentagem_crescimento_cadastros);
        $porcentagem_crescimento_valor_formatada = sprintf("%.2f%%", $porcentagem_crescimento_valor);


        return view('admin_empresa.dashboard_metricas', compact('porcentagem_crescimento_cadastros_formatada', 'porcentagem_crescimento_valor_formatada', 'mesPassado_total_cadastros_sae', 'mesPassado_total_valor_sae', 'total_valor_sae', 'total_cadastros_sae', 'projecoes', 'statusDoacoesEmAberto', 'clientesContribuicao', 'doacoesPorTipo', 'doacoesMesAtual', 'doacoesMesPassado', 'empresa'));
    }

    public function empresa_metricas_pesquisa(Request $request, $empresa)
    {
        $empresa = Empresa::where('name', $empresa)->first();

        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $dataInicio = Carbon::parse($request->input('data_inicio'))->startOfMonth();
        $dataFim = Carbon::parse($request->input('data_fim'))->endOfMonth();

        $doacoesMesAtual = Doacao::whereBetween('created_at', [$dataInicio, $dataFim])->sum('valor');

        $doacoesMesPassado = Doacao::whereBetween('created_at', [Carbon::parse($dataInicio)->subMonth(), Carbon::parse($dataFim)->subMonth()])
            ->sum('valor');

        $doacoesPorTipo = Doacao::whereBetween('created_at', [$dataInicio, $dataFim])
            ->select('tipo', \DB::raw('SUM(valor) as total_valor'))
            ->groupBy('tipo')
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => $item->tipo,
                    'total_valor' => (float) $item->total_valor,
                ];
            })
            ->unique('tipo')
            ->values();

        $clientesContribuicao = Cliente::select(
            'clientes.id',
            'clientes.name',
            DB::raw('SUM(doacoes.valor) as contribuicao_total')
        )
            ->leftJoin('doacoes', 'clientes.id', '=', 'doacoes.cliente_id')
            ->whereBetween('doacoes.created_at', [$dataInicio, $dataFim])
            ->groupBy('clientes.id', 'clientes.name')
            ->orderByDesc('contribuicao_total')
            ->take(5)
            ->get();

        $statusDoacoesEmAberto = EmAberto::whereBetween('created_at', [$dataInicio, $dataFim])
            ->select(
                'status',
                DB::raw('COUNT(*) as quantidade')
            )
            ->groupBy('status')
            ->get();

        $projecoes = [];

        $somaPeriodo = Cliente::whereBetween('created_at', [$dataInicio, $dataFim])
            ->sum('valor');

        $dataProximoMes = $dataFim->copy()->addMonth();
        $projecaoProximoMes = [
            'data' => $dataProximoMes->format('M Y'),
            'valor' => $somaPeriodo,
        ];

        $projecoes[] = $projecaoProximoMes;

        return view('admin_empresa.dashboard_metricas_pesquisa', compact('projecoes', 'statusDoacoesEmAberto', 'clientesContribuicao', 'doacoesPorTipo', 'doacoesMesAtual', 'doacoesMesPassado', 'empresa'));
    }

    public function empresa_deleta_recibos(Request $request, $empresa, $id){
        $empresa = Empresa::where('name', $empresa)->first();

        Config::set('database.connections.empresa', [
            'driver' => 'mysql',
            'host' => $empresa->database_host,
            'port' => $empresa->database_port,
            'database' => $empresa->database_name,
            'username' => $empresa->database_username,
            'password' => $empresa->database_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        DB::setDefaultConnection('empresa');

        if (!$request->user()) {
            return redirect()->route('index', ['empresa' => $empresa->name])->with('error', 'Você precisa fazer login para acessar essa página.');
        }

        $remover = EmAberto::find($id);
        $remover->delete();

        return back()->with('success', 'Recibo removido com sucesso!');
    }


}