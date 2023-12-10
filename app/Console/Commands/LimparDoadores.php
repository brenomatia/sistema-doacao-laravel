<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LimparDoadores extends Command
{
    protected $signature = 'limpar:doadores';
    protected $description = 'Esvazia os campos doador da tabela clientes';

    public function handle()
    {
        $empresas = DB::table('empresas')->get();

        foreach ($empresas as $empresa) {
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

            // Atualiza o campo 'doador' para NULL na tabela 'clientes'
            DB::table('clientes')->update(['doador' => null]);
            Log::info("==============================================================");
            Log::info("Empresa: {$empresa->name} - limpeza doador com sucesso.");

            $this->info("Empresa: {$empresa->name} - limpeza doador com sucesso.");
            // Retorna para a conexão padrão após terminar as operações com a empresa atual.
            DB::setDefaultConnection('mysql');
        }

    }
}