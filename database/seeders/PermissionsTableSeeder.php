<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder


{

    
    public function run()
    {
        // Create permissions
        Permission::create(['name' => 'create task']);
        Permission::create(['name' => 'edit task']);
        // Define more permissions as needed
        // Assign permissions to roles

    }
}
