<?php

use App\Http\Controllers\FornecedorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui você registra as rotas da sua API. Elas são automaticamente
| carregadas pelo RouteServiceProvider e terão o prefixo "/api".
|
*/

Route::middleware('api')->get('/hello', function (Request $request) {
    return response()->json(['message' => 'API funcionando!']);
});

Route::apiResource('tasks', TaskController::class);

Route::apiResource('fornecedores', FornecedorController::class)
->parameters(['fornecedores' => 'fornecedor']);