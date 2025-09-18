<?php

use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/hello', function (Request $request) {
    return response()->json(['message' => 'API funcionando!']);
});

Route::apiResource('fornecedores', FornecedorController::class)
->parameters(['fornecedores' => 'fornecedor']);

Route::get('produtos/all-informations', [ProdutoController::class, 'showAllAgruped']);
Route::apiResource('produtos', ProdutoController::class);

Route::get('estoques/por-validade', [EstoqueController::class, 'showGroupByValidade'])
->name('estoques.por-validade');

Route::apiResource('estoques', EstoqueController::class);