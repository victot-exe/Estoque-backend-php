<?php

namespace App\Http\Controllers;

use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\Estoque;
use App\Models\Evento;
use Illuminate\Support\Facades\File;

class ExportController extends Controller
{
    public function exportarRelatorio()
    {
        $directory = storage_path('app/public');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true);
        }

        File::cleanDirectory($directory);

        $fileName = 'relatorio_' . date('Y-m-d_His') . '.xlsx';
        $path = $directory . '/' . $fileName;

        $writer = SimpleExcelWriter::create($path);

        $estoques = Estoque::with('produto')->where('quantidade', '>', 0)->get();
        $dadosEstoque = [];

        foreach ($estoques as $estoque) {
            $dadosEstoque[] = [
                'Produto' => $estoque->produto->title ?? 'N/A',
                'Fornecedor' => $estoque->produto->fornecedor->nome ?? 'N/A',
                'Qtd' => $estoque->quantidade,
                'Preço de Compra' => $estoque->valorDeCompra,
                'Preço de Venda' => $estoque->valorDeVenda,
                'Validade' => optional($estoque->validade)->format('d/m/Y') ?? 'N/A',
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
                'Validade' => optional($evento->estoque->validade)->format('d/m/Y') ?? 'N/A',
            ];
        }

        $writer->addRows($dadosEventos);
        $writer->close();

        return response()->download($path, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}