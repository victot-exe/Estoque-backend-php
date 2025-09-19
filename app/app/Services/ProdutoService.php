<?php
namespace App\Services;

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

    public function showAllInformations()
    {
        $produtos = Produto::with([
            'fornecedor:id,nome',
            'estoques:id,produto_id,validade,valorDeCompra,valorDeVenda,quantidade'
        ])->get(['id', 'title', 'fornecedor_id']);

        $result = $produtos->map(function ($p) {
            $grupos = $p->estoques
                ->sortBy([['validade', 'asc'], ['valorDeCompra', 'asc'], ['valorDeVenda', 'asc']])
                ->groupBy(fn($e) => $e->validade->toDateString()) // garante agrupamento por data
                ->map(function ($byValidade) {
                    return $byValidade->groupBy('valorDeCompra')
                        ->map(function ($byCompra) {
                            return $byCompra->groupBy('valorDeVenda')
                                ->map(function ($byVenda) {
                                    return [
                                        'quantidade_total' => $byVenda->sum('quantidade'),
                                        'itens' => $byVenda->map->only([
                                            'id',
                                            'validade',
                                            'valorDeCompra',
                                            'valorDeVenda',
                                            'quantidade'
                                        ])->values(),
                                    ];
                                });
                        });
                });

            return [
                'produto_id' => $p->id,
                'produto'    => $p->title,
                'fornecedor' => $p->fornecedor->nome ?? null,
                'estoque'     => $grupos,
            ];
        });

        return $result;
    }

}