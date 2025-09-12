<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('valorDeCompra', 10, 2);
            $table->decimal('valorDeVenda', 10, 2);
            $table->foreignId('fornecedor_id')->constrained('fornecedors');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
