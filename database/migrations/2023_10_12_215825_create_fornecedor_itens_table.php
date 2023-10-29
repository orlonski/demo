<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedor_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fornecedores_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('produto_id')->nullable()->constrained()->cascadeOnDelete();
            $table->decimal('valor', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('fornecedor_itens');
    }
};
