<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
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
            'product_name' => Faker::create()->word(),
            'author_name' => Faker::create()->name(),
            'sku' => Faker::create()->word() . rand(10,10000),
        ];
    }
}
