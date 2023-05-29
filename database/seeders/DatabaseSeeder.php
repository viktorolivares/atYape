<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            ModuleSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserRoleSeeder::class,
            RolePermissionSeeder::class
        ]);

        // \App\Models\User::factory(100)->create();
        // \App\Models\Role::factory(10)->create();

    }
}
