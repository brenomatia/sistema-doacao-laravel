<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function dashboard_cadastrar_empresa_cadastrando(Request $request)
    {
        //dd($request->all());
        // Valide os dados do formulário
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'endereco' => 'required',
            'database_name' => 'required',
            'database_host' => 'required',
            'database_port' => 'required',
            'database_username' => 'required',
            'database_password' => 'required',
        ]);

        // Salve o logo da empresa na pasta "public/logos"
        $logo_empresa = time() . '.' . $request->file->getClientOriginalExtension();
        $path = $request->file->move(public_path('logos_empresas'), $logo_empresa);

        // Crie uma nova instância do modelo Empresa com os valores preenchidos pelo usuário
        $empresa = new Empresa([
            'logo' => basename($path),
            'name' => $request->input('name'),
            'endereco' => $request->input('endereco'),
            'database_name' => $request->input('database_name'),
            'database_host' => $request->input('database_host'),
            'database_port' => $request->input('database_port'),
            'database_username' => $request->input('database_username'),
            'database_password' => $request->input('database_password'),
        ]);

        // Salve os dados no banco de dados
        $empresa->save();

        return redirect()->route('dashboard_cadastrar_empresa')->with('success', 'Empresa cadastrada com sucesso!');

    }

    public function dashboard_view_empresa(Request $request, $id)
    {
        $empresa = Empresa::find($id);
        return view('admin.dashboard_view', compact('empresa'));
    }

    public function dashboard_view_empresa_atualizar(Request $request, $id)
    {
        // Encontre a empresa com base no ID
        $empresa = Empresa::find($id);

        // Valide os dados do formulário
        $request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'endereco' => 'required',
            'database_name' => 'required',
            'database_host' => 'required',
            'database_port' => 'required',
            'database_username' => 'required',
        ]);

        // Verifique se foi enviado um novo arquivo para o logo
        if ($request->hasFile('file')) {
            // Salve o novo arquivo do logo
            $logo_empresa = time() . '.' . $request->file->getClientOriginalExtension();
            $path = $request->file->move(public_path('logos_empresas'), $logo_empresa);

            // Atualize o nome do arquivo do logo na empresa
            $empresa->update(['logo' => basename($path)]);
        }

        // Atualize os outros campos da empresa com base nos dados do formulário
        $empresa->update([
            'name' => $request->input('name'),
            'endereco' => $request->input('endereco'),
            'database_name' => $request->input('database_name'),
            'database_host' => $request->input('database_host'),
            'database_port' => $request->input('database_port'),
            'database_username' => $request->input('database_username'),
        ]);

        // Verifique se a senha foi fornecida no formulário
        if ($request->filled('database_password')) {
            // Atualize a senha da empresa
            $empresa->update(['database_password' => $request->input('database_password')]);
        }

        return redirect()->route('dashboard_cadastrar_empresa', ['id' => $id])->with('success', 'Cadastro atualizado com sucesso!');
    }

    public function dashboard_deletar_empresa($id)
    {
        $empresa = Empresa::find($id);
        $empresa->delete();
        return redirect()->route('dashboard_cadastrar_empresa')->with('success', 'Empresa deletada do sistema ( base de dados preservada. )');
    }
}