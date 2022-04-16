<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->word(),
            'author_name' => $this->faker->name(),
            'sku' => $this->faker->word() . rand(10,10000),
        ];
    }
}
