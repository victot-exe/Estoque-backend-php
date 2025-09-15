<?php

use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::middleware('api')->get('/hello', function (Request $request) {
    return response()->json(['message' => 'API funcionando!']);
});

Route::apiResource('tasks', TaskController::class);

Route::apiResource('fornecedores', FornecedorController::class)
->parameters(['fornecedores' => 'fornecedor']);

Route::apiResource('produtos', ProdutoController::class);