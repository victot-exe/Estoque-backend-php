<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VendaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evento'       => 'required|string|max:255',
            'dataDoEvento' => 'required|date',
            'produto_id'   => 'required|integer|exists:produtos,id',
            'quantidade'   => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $produtoId = $this->input('produto_id');

                    if ($produtoId) {
                        $totalEstoque = \App\Models\Estoque::where('produto_id', $produtoId)->sum('quantidade');

                        if ($value > $totalEstoque) {
                            $fail("A quantidade solicitada ({$value}) é maior que o estoque disponível ({$totalEstoque}).");
                        }
                    }
                },
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação',
            'errors'  => $errors,
        ], 422));
    }
}
