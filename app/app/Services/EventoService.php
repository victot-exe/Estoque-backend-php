<?php

namespace App\Services;

use App\Models\Estoque;
use App\Models\Evento;
use Illuminate\Support\Facades\DB;
use Exception;

class EventoService
{
    public function vender(array $data)
    {
        return DB::transaction(function () use ($data) {
            $quantidadeRestante = (int) $data['quantidade'];
            $produtoId = $data['produto_id'];

            // Busca lotes (estoques) do produto com quantidade > 0, por validade (mais antigo primeiro)
            $estoques = Estoque::where('produto_id', $produtoId)
                ->where('quantidade', '>', 0)
                ->orderBy('validade', 'asc')
                ->lockForUpdate() // trava linhas para evitar concorrência
                ->get();

            // Verifica se tem estoque suficiente
            if ($estoques->sum('quantidade') < $quantidadeRestante) {
                throw new Exception('Estoque insuficiente para atender a venda.');
            }

            $eventosCriados = [];

            foreach ($estoques as $estoque) {
                if ($quantidadeRestante <= 0) break;

                $disponivel = (int) $estoque->quantidade;
                $deduzir = min($disponivel, $quantidadeRestante);

                // cria evento referente a esse lote
                $evento = Evento::create([
                    'evento'       => $data['evento'],
                    'dataDoEvento' => $data['dataDoEvento'],
                    'estoque_id'   => $estoque->id,
                    'quantidade'   => $deduzir,
                ]);

                $eventosCriados[] = $evento;

                // decrementa o estoque
                $estoque->decrement('quantidade', $deduzir);

                // atualiza restante
                $quantidadeRestante -= $deduzir;
            }

            return collect($eventosCriados)->map(function($e) {
                // opcional: carregar relacionamento estoque associado para retorno
                $e->load('estoque.produto');
                return $e;
            })->values();
        });
    }
}
