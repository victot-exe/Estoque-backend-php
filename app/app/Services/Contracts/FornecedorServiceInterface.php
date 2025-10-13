<?php
namespace App\Services\Contracts;

use App\Models\Fornecedor;

interface FornecedorServiceInterface{
    public function create(array $data): Fornecedor;
    public function update(Fornecedor $fornecedor, array $data): Fornecedor;
    public function delete(Fornecedor $fornecedor): void;
    public function getAll($perPage);
    function getFornecedorEstoqueById($id);
}