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
        Schema::create('shop_categoria_produto', function (Blueprint $table) {
            $table->primary(['shop_categoria_id', 'shop_produto_id']);
            $table->foreignId('shop_categoria_id')->nullable();
            $table->foreignId('shop_produto_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_categoria_produto');
    }
};
