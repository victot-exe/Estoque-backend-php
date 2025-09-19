<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreEstoqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produto_id'     => 'required|integer|exists:produtos,id',
            'valorDeCompra'  => 'required|numeric|min:0',
            'valorDeVenda'   => 'required|numeric|gte:valorDeCompra',
            'validade'       => 'required|date|after:today',
            'quantidade'     => 'required|integer|min:0',
        ];
    }

    public function messages():array
    {
        return [
        'produto_id.required'    => 'O produto é obrigatório.',
        'produto_id.integer'     => 'O produto informado é inválido.',
        'produto_id.exists'      => 'O produto selecionado não existe.',
        'valorDeCompra.required' => 'O valor de compra é obrigatório.',
        'valorDeCompra.numeric'  => 'O valor de compra deve ser um número.',
        'valorDeCompra.min'      => 'O valor de compra deve ser no mínimo 0.',

        'valorDeVenda.required'  => 'O valor de venda é obrigatório.',
        'valorDeVenda.numeric'   => 'O valor de venda deve ser um número.',
        'valorDeVenda.gte'       => 'O valor de venda deve ser maior ou igual ao valor de compra.',

        'validade.required'      => 'A validade é obrigatória.',
        'validade.date'          => 'A validade deve ser uma data válida.',
        'validade.after'         => 'A validade deve ser uma data futura.',

        'quantidade.required'    => 'A quantidade é obrigatória.',
        'quantidade.integer'     => 'A quantidade deve ser um número inteiro.',
        'quantidade.min'         => 'A quantidade não pode ser negativa.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(
            $validator,
            response()->json([
                'message' => 'Os dados fornecidos são inválidos.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}