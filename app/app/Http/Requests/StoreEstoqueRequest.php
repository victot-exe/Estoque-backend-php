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
            'produto_id' => ['required', 'integer', 'exists:produtos,id'],
            'validade' => ['required', 'date', 'after_or_equal:today'],
            'quantidade' => ['required', 'integer', 'min:0'],
        ];
    }
}
