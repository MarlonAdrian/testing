<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Commerce;
use App\Models\User;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [           
            'code_product' => $this->faker->iban(),
            'name_product' => $this->faker->userAgent(),
            'price' => $this->faker->randomFloat(2, 50, 100),
            'description' => $this->faker->sentence(),
            'stock' => $this->faker->numberBetween($min = 4, $max = 8),
            'path_image'=>'https://picsum.photos/id/'.$this->faker->unique()->numberBetween($min = 1, $max = 6).'/200/300',
        ];
    }
}
