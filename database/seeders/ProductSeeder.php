<?php

namespace Database\Seeders;

use App\Models\Product;

use App\Models\Commerce;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $commerces_products = User::whereHas(
            'role', function($q){
                $q->where('name', 'owner');
            }
        )->get();

        $commerces_products->each(function($product)
        {
            Product::factory()->count(2)->for($product)->create();
        });    
    }
}
