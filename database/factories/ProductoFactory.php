<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_prod' => $this->faker->sentence(2),
            'unidad' => 'Piezas',
            'stock_min' => $this->faker->randomNumber(3),
            'categoria_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'area' => 'DX17', 
            'subarea' => 'DX17X', 
            'existencias' => $this->faker->randomNumber(6), 
            'photo_prod' => 'iconProduct.png'
        ];
    }
}
