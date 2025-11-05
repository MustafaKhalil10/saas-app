<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $roles = ['Admin', 'Owner', 'User'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
    }
}



