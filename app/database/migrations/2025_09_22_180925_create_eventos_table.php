<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('evento');
            $table->date('dataDoEvento');
            $table->foreignId('estoque_id');
            $table->integer('quantidade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
