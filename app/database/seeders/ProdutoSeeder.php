<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        Produto::create([
            'title' => 'Cerveja Skol',
            'fornecedor_id' => 1,
        ]);

        Produto::create([
            'title' => 'Dopamina',
            'fornecedor_id' => 2,
        ]);
    }
}