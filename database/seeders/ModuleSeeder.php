<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::table('modules')->insert([
            'name' => 'Usuarios',
            'created_at' => now(),
            'updated_at' => now()

        ]);

        DB::table('modules')->insert([
            'name' => 'Roles',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('modules')->insert([
            'name' => 'Permisos',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('modules')->insert([
            'name' => 'Transacciones',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('modules')->insert([
            'name' => 'Yape',
            'created_at' => now(),
            'updated_at' => now()

        ]);

        DB::table('modules')->insert([
            'name' => 'Utilidades',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
