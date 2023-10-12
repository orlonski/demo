<?php

namespace Database\Factories;

use App\Models\PedidoAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoAddressFactory extends Factory
{
    protected $model = PedidoAddress::class;

    public function definition(): array
    {
        return [
            'street' => $this->faker->streetAddress(),
            'state' => $this->faker->state(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
        ];
    }
}
