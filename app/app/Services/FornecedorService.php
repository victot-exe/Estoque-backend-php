<?php
namespace App\Services;

use App\Models\Fornecedor;
use App\Services\Contracts\FornecedorServiceInterface;
use Illuminate\Support\Facades\DB;

class FornecedorService implements FornecedorServiceInterface{

    public function create(array $data): Fornecedor{
        return DB::transaction(function() use ($data){
            return Fornecedor::create($data);
        });
    }

    public function update(Fornecedor $fornecedor, array $data): Fornecedor{
        //TODO ver como usa o transaction aqui tambem
        $fornecedor->update($data);

        return $fornecedor;
    }

    public function delete(Fornecedor $fornecedor): void{
        //TODO ver de usar transaction aqui tambem
        $fornecedor->delete();
    }
}