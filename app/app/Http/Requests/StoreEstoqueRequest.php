<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstoqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produto_id'     => 'required|integer|exists:produtos,id', // Mantido, pois é importante validar a existência do produto
            'valorDeCompra'  => 'required|numeric', // Removido o mínimo de 0
            'valorDeVenda'   => 'required|numeric|gte:valorDeCompra', // Permite qualquer valor maior ou igual a valorDeCompra
            'validade'       => 'required|date', // Removido o requisito de data futura
            'quantidade'     => 'required|integer', // Removido o mínimo de 0
        ];
    }
}
