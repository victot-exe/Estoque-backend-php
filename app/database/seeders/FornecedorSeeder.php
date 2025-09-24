<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

class FornecedorSeeder extends Seeder
{
    public function run(): void
    {
        Fornecedor::create([
            'nome' => 'Ambev',
            'telefone' => '11999999999',
        ]);

        Fornecedor::create([
            'nome' => 'Imperio',
            'telefone' => '11888888888',
        ]);
    }
}
