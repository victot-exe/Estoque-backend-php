<?php
namespace App\Services;

use App\Models\Fornecedor;
use App\Services\Contracts\FornecedorServiceInterface;
use Illuminate\Support\Facades\DB;

class FornecedorService implements FornecedorServiceInterface{

    public function create(array $data): Fornecedor{//TODO implementar o repository

        return DB::transaction(function() use ($data){
            return Fornecedor::create($data);
        });
    }

    public function update(Fornecedor $fornecedor, array $data): Fornecedor{

        return DB::transaction(function() use ($fornecedor, $data){
        
            if($fornecedor->update($data)){
                return $fornecedor;
            }
            return "Não foi possível atualizar o forncedor!";
        });
    }

    public function delete(Fornecedor $fornecedor): void{
        
        DB::transaction(function() use ($fornecedor){
            $fornecedor->delete();
        });
    }
}