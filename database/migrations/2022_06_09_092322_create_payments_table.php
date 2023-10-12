<?php

use App\Models\Shop\Pedido;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('shop_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Pedido::class);

            $table->string('reference');

            $table->string('provider');

            $table->string('method');

            $table->decimal('amount');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shop_payments');
    }
};
