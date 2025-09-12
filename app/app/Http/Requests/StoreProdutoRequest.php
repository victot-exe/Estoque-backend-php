<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest//TODO fazer um de update
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'valorDeCompra' => ['required', 'numeric', 'decimal:0,2', 'min:0'],
            'valorDeVenda' => ['sometimes', 'required', 'numeric', 'decimal:0,2', 'min:0', 'gte:valorDeCompra'],
            'fornecedor_id' => ['required', 'integer', 'exists:fornecedors,id'],
        ];
    }
}
