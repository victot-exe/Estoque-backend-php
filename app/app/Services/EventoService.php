<?php

namespace App\Services;

use App\Models\Estoque;
use App\Models\Evento;
use App\Services\Contracts\EventoServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class EventoService implements EventoServiceInterface
{
    public function vender(array $data)
    {
        return DB::transaction(function () use ($data) {
            $quantidadeRestante = (int) $data['quantidade'];
            $produtoId = $data['produto_id'];

            $estoques = Estoque::where('produto_id', $produtoId)
                ->where('quantidade', '>', 0)
                ->orderBy('validade', 'asc')
                ->lockForUpdate()
                ->get();

            if ($estoques->sum('quantidade') < $quantidadeRestante) {
                throw new Exception('Estoque insuficiente para atender a venda.');
            }

            $eventosCriados = [];

            foreach ($estoques as $estoque) {
                if ($quantidadeRestante <= 0) break;

                $disponivel = (int) $estoque->quantidade;
                $deduzir = min($disponivel, $quantidadeRestante);

                $evento = Evento::create([
                    'evento'       => $data['evento'],
                    'dataDoEvento' => $data['dataDoEvento'],
                    'estoque_id'   => $estoque->id,
                    'quantidade'   => $deduzir,
                ]);

                $eventosCriados[] = $evento;

                $estoque->decrement('quantidade', $deduzir);

                $quantidadeRestante -= $deduzir;
            }

            return collect($eventosCriados)->map(function($e) {
                $e->load('estoque.produto');
                return $e;
            })->values();
        });
    }

    public function getEventosAgrupados()
    {
        $totais = Evento::select(
                'evento',
                'dataDoEvento',
                DB::raw('SUM(quantidade) as quantidadeTotal')
            )
            ->groupBy('evento', 'dataDoEvento')
            ->get();

        $eventos = $totais->map(function ($evento) {
            $estoques = Evento::select(
                    'eventos.id as evento_id',
                    'eventos.estoque_id',
                    'eventos.quantidade',
                    'estoques.produto_id',
                    'estoques.validade',
                    'produtos.title as produto'
                )
                ->join('estoques', 'eventos.estoque_id', '=', 'estoques.id')
                ->join('produtos', 'estoques.produto_id', '=', 'produtos.id')
                ->where('eventos.evento', $evento->evento)
                ->where('eventos.dataDoEvento', $evento->dataDoEvento)
                ->get();

            return [
                'evento' => $evento->evento,
                'dataDoEvento' => $evento->dataDoEvento,
                'quantidadeTotal' => $evento->quantidadeTotal,
                'estoques' => $estoques
            ];
        });

        return $eventos;
    }

    function create(array $data){
            return DB::transaction(function () use ($data) {
            
            $evento = Evento::create($data);

            $estoque = Estoque::findOrFail($data['estoque_id']);

            $novaQuantidade = $estoque->quantidade - $data['quantidade'];

            if ($novaQuantidade < 0) {
                throw new \Exception('Quantidade insuficiente no estoque.');
            }

            $estoque->update(['quantidade' => $novaQuantidade]);

            return $evento;
        });
    }
}