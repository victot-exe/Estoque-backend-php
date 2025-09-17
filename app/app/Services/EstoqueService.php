<?php
namespace App\Services;

use App\Services\Contracts\EstoqueServiceInterface;
use App\Models\Estoque;
use Illuminate\Support\Facades\DB;

class EstoqueService implements EstoqueServiceInterface{
    
    public function create(array $data): Estoque{
        var_dump($data);
        
        return DB::transaction(function() use($data){
            return Estoque::create($data);
        });
    }
    public function update(Estoque $estoque, array $data): Estoque{
        return DB::transaction(function() use($estoque, $data){
            if($estoque->update($data)){
                return $estoque;
            }
            return "Não foi possível atualizar o estoque";
        });
    }
    public function delete(Estoque $estoque): void{//TODO talvez não deletar o estoque, apenas zerar, definir regra de negocio
        DB::transaction(function() use($estoque){
            $estoque->delete();
        });
    }

    public function getAllEstoqueGroupByValidadeAndProduto(){
        return Estoque::query()
        ->select('produto_id','validade',DB::raw('SUM(quantidade) as quantidade'))
        ->groupBy('produto_id', 'validade')
        ->orderBy('validade')
        ->get();
    }
}