<?php

namespace App\Http\Middleware;

use App\Models\Empresa;
use Closure;
use Illuminate\Http\Request;

class CheckEmpresa
{

    public function handle(Request $request, Closure $next)
    {


        // Busca o registro da empresa na tabela "companies" pelo nome informado na rota.
        $empresa = Empresa::where('name', $request->route('empresa'))->first();

        // Verifica se a empresa foi encontrada.
        if (!$empresa) {
            return redirect()->route('index', ['empresa' => $empresa->name]);
        }

        // Adiciona a empresa ao objeto da requisição para que possa ser acessada pelos controllers.
        $request->empresa = $empresa;

        return $next($request);
    }
}