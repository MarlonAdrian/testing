<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        $faker = app(Generator::class);

		foreach(range(1, 15) as $index)
		{
			Feedback::create([
                'user_id'=>$faker->numberBetween($min = 4, $max = 9),
                'product_id' =>$faker->numberBetween($min = 1, $max = 6),
                'score' => $faker->randomElement(['low', 'medium', 'high']),
                'comment' => $faker->realText(200)
			]);
		}          
    }            
}
