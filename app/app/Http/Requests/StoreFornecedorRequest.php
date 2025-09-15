<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFornecedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'sometimes|required|string|max:255',
            'telefone' => 'sometimes|required|regex:/^\(?\d{2}\)?\s?9?\d{4}-?\d{4}$/',
        ];
    }
}
