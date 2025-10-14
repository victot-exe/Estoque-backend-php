<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Estoque;

class VendaUnitariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evento' => ['required', 'string', 'max:255'],
            'dataDoEvento' => ['required', 'date'],
            'estoque_id' => ['required', 'exists:estoques,id'],
            'quantidade' => ['required', 'integer', 'min:1'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $estoqueId = $this->input('estoque_id');
            $quantidade = $this->input('quantidade');

            if ($estoqueId && $quantidade) {
                $estoque = Estoque::find($estoqueId);

                if ($estoque && $quantidade > $estoque->quantidade) {
                    $validator->errors()->add(
                        'quantidade',
                        "A quantidade do evento não pode ser maior que o disponível no estoque ({$estoque->quantidade})."
                    );
                }
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação',
            'errors'  => $validator->errors(),
        ], 422));
    }
}