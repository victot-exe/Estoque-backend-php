<?php
namespace App\Services\Contracts;

use App\Models\Produto;

interface ProdutoServiceInterface{
    public function create(array $data): Produto;
    public function update(Produto $produto, array $data): Produto;
    public function delete(Produto $produto): void;
    public function showAllInformations();
}
