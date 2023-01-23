<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductOrder;
use Faker\Generator;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductOrderSeeder extends Seeder
{
    public function run()
    {

        $faker = app(Generator::class);

		foreach(range(1, 5) as $index)
		{
            $productos=Product::all();

            $client_id = User::whereHas(
                'role', function($q){
                    $q->where('name', 'client');
                }
            )->select('id')->pluck('id')->first();   

            $array=Product::select('id')->pluck('id');
            
			ProductOrder::create([
                'user_id'=>$faker->numberBetween($min = 5, $max = 9),
                'product_id' =>Product::select('id')->pluck('id')->random() //default
			]);
		}         
    }
}
