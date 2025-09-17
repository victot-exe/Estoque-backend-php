<?php
namespace App\Services;

use App\Models\Estoque;
use App\Models\Produto;
use App\Services\Contracts\ProdutoServiceInterface;
use Illuminate\Support\Facades\DB;

class ProdutoService implements ProdutoServiceInterface{

    public function create(array $data): Produto{
        return DB::transaction(function() use($data){
            return Produto::create($data);
        });
    }

    public function update(Produto $produto, array $data): Produto{
        return DB::transaction(function() use($produto, $data){
            if($produto->update($data)){
                return $produto;
            }
            return "Não foi possivel atualizar o forncedor!";
        });
    }
    
    public function delete(Produto $produto): void{
        DB::transaction(function() use($produto){
            $produto->delete();
        });
    }
}