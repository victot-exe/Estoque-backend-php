<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreFornecedorUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sometimes|required|string|max:255',
            'telefone' => 'sometimes|required|regex:/^\(?\d{2}\)?\s?9?\d{4}-?\d{4}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'     => 'O nome é obrigatório.',
            'nome.string'       => 'O nome deve ser um texto.',
            'nome.max'          => 'O nome deve ter no máximo 255 caracteres.',

            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.regex'    => 'O telefone deve estar em um formato válido, por exemplo: (11) 91234-5678 ou 11912345678.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new ValidationException(
            $validator,
            response()->json([
                'message' => $errors->first(),
                'errors'  => $errors->toArray(),
            ], 422)
        );
    }
}
