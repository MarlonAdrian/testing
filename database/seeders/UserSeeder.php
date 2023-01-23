<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        $rol_admin = Role::where('name', 'admin')->first();
        // 1 usuario le pertenece el rol administrador
        User::factory()->for($rol_admin)->count(1)->create();


        $rol_owner = Role::where('name', 'owner')->first();
        // 3 usuarios le pertenecen el rol de propietario
        User::factory()->for($rol_owner)->count(3)->create();

        
        $rol_client = Role::where('name', 'client')->first();
        // 5 usuarios que le pertenecen al rol cliente
        User::factory()->for($rol_client)->count(5)->create();

        // $rol_affiliate = Role::where('name', 'affiliate')->first();
        // // 5 usuarios que le pertenecen al rol prisoner
        // User::factory()->for($rol_affiliate)->count(4)->create();


    }
}
