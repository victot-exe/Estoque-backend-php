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

    public function getAll()
    {
        $fornecedores = Fornecedor::with([
            'produtos:id,title,fornecedor_id',
            'produtos.estoques:id,produto_id,validade,valorDeCompra,valorDeVenda,quantidade'
        ])->get(['id', 'nome']);

        $result = $fornecedores->map(function ($f) {
            $produtos = $f->produtos->map(function ($p) {
                $grupos = $p->estoques
                    ->sortBy([['validade', 'asc'], ['valorDeCompra', 'asc'], ['valorDeVenda', 'asc']])
                    ->groupBy(fn($e) => $e->validade->toDateString())
                    ->map(function ($byValidade, $validade) {
                        return [
                            'validade' => $validade,
                            'grupos_compra' => $byValidade->groupBy('valorDeCompra')
                                ->map(function ($byCompra, $valorCompra) {
                                    return [
                                        'valorDeCompra' => $valorCompra,
                                        'grupos_venda' => $byCompra->groupBy('valorDeVenda')
                                            ->map(function ($byVenda, $valorVenda) {
                                                return [
                                                    'valorDeVenda' => $valorVenda,
                                                    'quantidade_total' => $byVenda->sum('quantidade'),
                                                    'itens' => $byVenda->map->only([
                                                        'id',
                                                        'validade',
                                                        'valorDeCompra',
                                                        'valorDeVenda',
                                                        'quantidade'
                                                    ])->values(),
                                                ];
                                            })->values(),
                                    ];
                                })->values(),
                        ];
                    })->values();

                return [
                    'produto_id' => $p->id,
                    'produto'    => $p->title,
                    'estoque'    => $grupos,
                ];
            });

            return [
                'fornecedor_id' => $f->id,
                'fornecedor'    => $f->nome,
                'produtos'      => $produtos,
            ];
        });

        return $result;
    }
}