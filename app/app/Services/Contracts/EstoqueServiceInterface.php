<?php
namespace App\Services\Contracts;

use App\Models\Estoque;

interface EstoqueServiceInterface{
    public function create(array $data): Estoque;
    public function update(Estoque $estoque, array $data): Estoque;
    public function delete(Estoque $estoque): void;//TODO talvez não deletar o estoque, apenas zerar, definir regra de negocio
    public function getAllEstoqueGroupByValidadeAndProduto();
}