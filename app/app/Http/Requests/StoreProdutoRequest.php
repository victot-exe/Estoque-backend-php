<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
