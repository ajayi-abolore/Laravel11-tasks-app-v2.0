<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {

        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        // Define more roles as needed
        

    }
}
