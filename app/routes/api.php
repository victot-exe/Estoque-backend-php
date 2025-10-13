<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\EventoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/hello', function (Request $request) {
    return response()->json(['message' => 'API funcionando!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('fornecedores/all-informations', [FornecedorController::class, 'showAllInformations']);
    Route::get('fornecedores/detail/{id}', [FornecedorController::class, 'getFornecedorEstoqueById']);
    Route::apiResource('fornecedores', FornecedorController::class)
        ->parameters(['fornecedores' => 'fornecedor']);

    Route::get('produtos/all-informations', [ProdutoController::class, 'showAllAgruped']);
    Route::apiResource('produtos', ProdutoController::class);

    Route::get('estoques/por-validade', [EstoqueController::class, 'showGroupByValidade'])
        ->name('estoques.por-validade');
    Route::apiResource('estoques', EstoqueController::class);

    Route::post('eventos/vender', [EventoController::class, 'vender']);
    Route::post('eventos/venda-unitaria', [EventoController::class, 'venderUnitario']);
    Route::get('eventos', [EventoController::class, 'vendasAgrupadas']);
});