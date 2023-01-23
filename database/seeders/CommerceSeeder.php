<?php

namespace Database\Seeders;

use App\Models\Commerce;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class CommerceSeeder extends Seeder
{

    public function run()
    {
        $faker = app(Generator::class);
        $users_owners = [1,2,3];

        for($i=0 ; $i<3 ; $i++)
        {
            Commerce::create([
                'user_id'=>$users_owners[$i]+1,
                'name_commerce' => $faker->company()
            ]);
        } 
    }
}
