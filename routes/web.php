<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTES LOGIN - PROJETO
|--------------------------------------------------------------------------
*/

Route::get('/', [LoginController::class, "home_login"])->name("home_login");
Route::get('/cadastro', [LoginController::class, "home_cadastro"])->name("home_cadastro");
Route::post('/cadastro/user_add', [LoginController::class, "add_cadastro"])->name("add_cadastro");
Route::post('/login', [LoginController::class, "login_access"])->name("login_access");

/*
|--------------------------------------------------------------------------
| PAINEL ADMIN - PROJETO
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [LoginController::class, "dashboard_home"])->name('dashboard_home')->middleware('auth');
Route::get('/dashboard/cadastro/empresa', [LoginController::class, "dashboard_cadastrar_empresa"])->name('dashboard_cadastrar_empresa')->middleware('auth');
Route::post('/dashboard/cadastro/empresa/cadastrando', [SystemController::class, "dashboard_cadastrar_empresa_cadastrando"])->name('dashboard_cadastrar_empresa_cadastrando')->middleware('auth');
Route::post('/dashboard/cadastro/empresa/view/{id}', [SystemController::class, "dashboard_view_empresa"])->name('dashboard_view_empresa')->middleware('auth');
Route::post('/dashboard/cadastro/empresa/view/{id}/atualizar', [SystemController::class, "dashboard_view_empresa_atualizar"])->name('dashboard_view_empresa_atualizar')->middleware('auth');
Route::delete('/dashboard/cadastro/empresa/deletar/{id}', [SystemController::class, "dashboard_deletar_empresa"])->name('dashboard_deletar_empresa')->middleware('auth');

/*
|--------------------------------------------------------------------------
| PAINEL EMPRESA - PROJETO
|--------------------------------------------------------------------------
*/

Route::middleware(['check-empresa'])->group(function () {
    Route::get('/instituição/{empresa}', [EmpresaController::class, 'index'])->name('index');
    Route::get('/instituição/{empresa}/cadastro', [EmpresaController::class, 'Empresa_cadastro'])->name('Empresa_cadastro');
    Route::post('/instituição/{empresa}/cadastro/new_user', [EmpresaController::class, 'Empresa_cadastro_new_user'])->name('Empresa_cadastro_new_user');
    Route::post('/instituição/{empresa}/login', [EmpresaController::class, 'Empresa_login'])->name('Empresa_login');
    Route::get('/instituição/{empresa}/dashboard', [EmpresaController::class, 'Empresa_dashboard'])->name('Empresa_dashboard');
    Route::get('/instituição/{empresa}/cadastro_cliente', [EmpresaController::class, 'Empresa_cadastro_cliente'])->name('Empresa_cadastro_cliente');
    Route::post('/instituição/{empresa}/cadastro_cliente/adicionar', [EmpresaController::class, 'Empresa_cadastro_cliente_add'])->name('Empresa_cadastro_cliente_add');
    Route::delete('/instituição/{empresa}/cadastro_cliente/{id}/deletar_doador', [EmpresaController::class, 'Empresa_cadastro_cliente_deletar'])->name('Empresa_cadastro_cliente_deletar');
    Route::get('/instituição/{empresa}/cadastro_cliente/{id}', [EmpresaController::class, 'Empresa_cadastro_cliente_view'])->name('Empresa_cadastro_cliente_view');
    Route::post('/instituição/{empresa}/cadastro_cliente/{id}/atualizar', [EmpresaController::class, 'Empresa_cadastro_cliente_att'])->name('Empresa_cadastro_cliente_att');

    Route::post('/instituição/{empresa}/doadores/localizar', [EmpresaController::class, 'empresa_doadores_localizar'])->name('empresa_doadores_localizar');


    Route::post('/instituição/{empresa}/doações/registrar/{id}', [EmpresaController::class, 'empresa_registrar_doacao'])->name('empresa_registrar_doacao');
    Route::get('/instituição/{empresa}/areceber', [EmpresaController::class, 'empresa_areceber'])->name('empresa_areceber');
    Route::post('/instituição/{empresa}/areceber/{doacao_id}', [EmpresaController::class, 'empresa_areceber_emitir'])->name('empresa_areceber_emitir');
    Route::post('/instituição/{empresa}/cadastro_cliente/primeira/{id}', [EmpresaController::class, 'empresa_cadastro_cliente_primeira'])->name('empresa_cadastro_cliente_primeira');
    Route::post('/instituição/{empresa}/cadastro_cliente/primeira/{id}/emitindo_recibo', [EmpresaController::class, 'empresa_cadastro_emitindo_recibo'])->name('empresa_cadastro_emitindo_recibo');
    Route::post('/instituição/{empresa}/cadastro_cliente/primeira/{id}/processando_recibo', [EmpresaController::class, 'empresa_cadastro_processando_recibo'])->name('empresa_cadastro_processando_recibo');
    Route::post('/instituição/{empresa}/cadastro_cliente/atualiza_baixa/{id}', [EmpresaController::class, 'empresa_atualiza_recibo_baixado'])->name('empresa_atualiza_recibo_baixado');
    
    Route::get('/instituição/{empresa}/logs', [EmpresaController::class, 'empresa_logs'])->name('empresa_logs');

    Route::post('/instituição/{empresa}/logs/pesquisa', [EmpresaController::class, 'empresa_logs_pesquisa'])->name('empresa_logs_pesquisa');

    Route::get('/instituição/{empresa}/usuarios', [EmpresaController::class, 'empresa_usuarios'])->name('empresa_usuarios');
    Route::post('/instituição/{empresa}/usuarios/new_user', [EmpresaController::class, 'empresa_new_user'])->name('empresa_new_user');
    Route::post('/instituição/{empresa}/usuarios/view/{id}', [EmpresaController::class, 'empresa_view_user'])->name('empresa_view_user');
    Route::post('/instituição/{empresa}/usuarios/view/{id}/atualizar', [EmpresaController::class, 'empresa_update_user'])->name('empresa_update_user');
    Route::post('/instituição/{empresa}/usuarios/{id}/delete_user', [EmpresaController::class, 'empresa_delete_user'])->name('empresa_delete_user');

    Route::get('/instituição/{empresa}/baixar_recibos', [EmpresaController::class, 'empresa_baixar'])->name('empresa_baixar');
    Route::post('/instituição/{empresa}/baixar_recibos/{id}/deletar', [EmpresaController::class, 'empresa_deleta_recibos'])->name('empresa_deleta_recibos');
    Route::post('/instituição/{empresa}/baixar_recibos/{cliente_id}/{id}', [EmpresaController::class, 'empresa_dar_baixa_em_recibos'])->name('empresa_dar_baixa_em_recibos');

    Route::post('/instituição/{empresa}/baixar_recibos/pesquisa', [EmpresaController::class, 'empresa_baixar_recibos_pesquisa'])->name('empresa_baixar_recibos_pesquisa');


    Route::get('/instituição/{empresa}/termo_sae/{id}', [EmpresaController::class, 'empresa_termo_sae_route'])->name('empresa_termo_sae_route');
    Route::post('/instituição/{empresa}/termo_sae/{id}/gerando_termo', [EmpresaController::class, 'empresa_gerando_termo_sae'])->name('empresa_gerando_termo_sae');

    Route::get('/instituição/{empresa}/metricas', [EmpresaController::class, 'empresa_metricas'])->name('empresa_metricas');
    Route::post('/instituição/{empresa}/metricas/pesquisa_personalizada', [EmpresaController::class, 'empresa_metricas_pesquisa'])->name('empresa_metricas_pesquisa');

    Route::get('/instituição/{empresa}/mesatual', [EmpresaController::class, 'empresa_mesatual'])->name('empresa_mesatual');

    /*
    |--------------------------------------------------------------------------
    | GERAL LOGOUT EMPRESA
    |--------------------------------------------------------------------------
    */
    Route::get('/instituição/{empresa}/logout', [EmpresaController::class, 'Empresa_logout'])->name('Empresa_logout');
});

/*
|--------------------------------------------------------------------------
| GERAL LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/logout', [LoginController::class, "logout"])->name('logout')->middleware('auth');