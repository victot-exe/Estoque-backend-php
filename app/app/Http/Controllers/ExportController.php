<?php

namespace App\Http\Controllers;

use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\Estoque;
use App\Models\Evento;

class ExportController extends Controller
{
    public function exportarRelatorio(){

        $fileName = 'relatorio_'. date('Y-m-d_His') .'.xlsx';

        $writer = SimpleExcelWriter::streamDownload($fileName);

        $estoques = Estoque::with('produto')->where('quantidade', '>', 0)->get();
        $dadosEstoque = [];
        
        foreach ($estoques as $estoque) {
            $dadosEstoque[] = [
                'Produto' => $estoque->produto->title ?? 'N/A',
                'Qtd' => $estoque->quantidade,
                'Preço de Compra' => $estoque->valorDeCompra,
                'Preço de Venda' => $estoque->valorDeVenda,
                'Validade' => $estoque->validade->format('d/m/Y'),
            ];
        }

        $writer->addRows($dadosEstoque);

        $writer->addNewSheetAndMakeItCurrent();

        $eventos = Evento::with('estoque.produto')->get();
        $dadosEventos = [];

        foreach ($eventos as $evento) {
            $dadosEventos[] = [
                'Evento' => $evento->evento,
                'Data' => $evento->dataDoEvento,
                'Produto' => $evento->estoque->produto->title ?? 'N/A',
                'Quantidade que vendeu' => $evento->quantidade,
                'Validade' => $evento->estoque->validade->format('d/m/Y') ?? 'N/A',
            ];
        }

        $writer->addRows($dadosEventos);

        return $writer->toBrowser();
    }
}