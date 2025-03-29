<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\UnidadeEnderecoController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\PessoaEnderecoController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\PessoaController;

// Inicializar proteção CSRF
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
})->middleware('web');

// Login e logout para SPA (baseado em sessão)
Route::post('/login_session', [AuthController::class, 'login_session'])->middleware('web');
Route::post('/logout_session', [AuthController::class, 'logout_session'])->middleware('web');

// Login via API token
Route::post('/login', [AuthController::class, 'login']); // Login via API token
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Logout via API token

// Rota para registro de usuários
Route::post('/register', [AuthController::class, 'register']);

// Rotas protegidas por token
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rotas protegidas para CRUD
    Route::apiResource('enderecos', EnderecoController::class);
    Route::apiResource('cidades', CidadeController::class);
    Route::apiResource('unidade_endereco', UnidadeEnderecoController::class);
    Route::apiResource('lotacoes', LotacaoController::class)->parameters([
        'lotacoes' => 'lotacao', 
    ]);
    Route::apiResource('servidores_efetivos', ServidorEfetivoController::class)->parameters([
        'servidores_efetivos' => 'servidor_efetivo', // Certifique-se de que o parâmetro é 'servidor_efetivo'
    ]);
    Route::get('/servidores_efetivos/unidade/{unid_id}', [ServidorEfetivoController::class, 'getByUnidade']);
    Route::get('/servidores_efetivos/endereco_funcional/{nome}', [ServidorEfetivoController::class, 'getEnderecoFuncional']);
    Route::apiResource('servidores_temporarios', ServidorTemporarioController::class)->parameters([
        'servidores_temporarios' => 'servidor_temporario',
    ]);
    Route::apiResource('pessoa_enderecos', PessoaEnderecoController::class)->parameters([
        'pessoa_enderecos' => 'pessoa_endereco', 
    ]);
    Route::apiResource('fotos_pessoas', FotoPessoaController::class);
    Route::apiResource('unidades', UnidadeController::class)->parameters([
        'unidades' => 'unidade', 
    ]);
    Route::apiResource('pessoas', PessoaController::class)->names([
        'show' => 'pessoa.show', 
    ]);

    // Rota explícita para criar registros (opcional)
    Route::post('/enderecos', [EnderecoController::class, 'store']);
});