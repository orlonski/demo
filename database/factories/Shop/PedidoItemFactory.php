<?php

namespace Database\Factories\Shop;

use App\Models\Shop\PedidoItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = PedidoItem::class;

    public function definition(): array
    {
        return [
            'qty' => $this->faker->numberBetween(1, 10),
            'unit_price' => $this->faker->randomFloat(2, 100, 500),
        ];
    }
}
