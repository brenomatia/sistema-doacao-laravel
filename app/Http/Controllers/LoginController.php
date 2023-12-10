<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function home_login(Request $request)
    {
        return view("home.login");
    }
    public function home_cadastro(Request $request)
    {
        return view("home.cadastro");
    }
    public function add_cadastro(Request $request)
    {
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
    public function login_access(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Credenciais inválidas. Verifique seu e-mail e senha e tente novamente.');
    }

    public function dashboard_home(Request $request)
    {
        return view('admin.dashboard');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home_login');
    }
    public function dashboard_cadastrar_empresa(Request $request)
    {
        $empresas = Empresa::all();
        return view('admin.dasboard_cadastro_empresa', compact('empresas'));
    }

}