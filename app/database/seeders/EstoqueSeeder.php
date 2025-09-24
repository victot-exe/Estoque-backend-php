<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estoque;

class EstoqueSeeder extends Seeder
{
    public function run(): void
    {
        Estoque::create([
            'produto_id' => 1,
            'valorDeCompra' => 2.50,
            'valorDeVenda' => 5.00,
            'validade' => '2025-12-31',
            'quantidade' => 3000,
        ]);

        Estoque::create([
            'produto_id' => 1,
            'valorDeCompra' => 2.70,
            'valorDeVenda' => 5.50,
            'validade' => '2026-01-15',
            'quantidade' => 2000,
        ]);

        Estoque::create([
            'produto_id' => 2,
            'valorDeCompra' => 3.00,
            'valorDeVenda' => 6.00,
            'validade' => '2026-03-10',
            'quantidade' => 4000,
        ]);
    }
}
