<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'fornecedor_id' => ['required', 'integer', 'exists:fornecedors,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'O título é obrigatório.',
            'title.string'          => 'O título deve ser um texto.',
            'title.max'             => 'O título deve ter no máximo 255 caracteres.',
            'fornecedor_id.required'=> 'O fornecedor é obrigatório.',
            'fornecedor_id.integer' => 'O fornecedor informado é inválido.',
            'fornecedor_id.exists'  => 'O fornecedor selecionado não existe.',
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
