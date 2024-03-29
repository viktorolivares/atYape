<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'Administrador',
            'slug' => 'Responsable de administrar y mantener el sistema.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Analista',
            'slug' => 'Encargado de analizar y procesar datos para obtener información relevante y tomar decisiones estratégicas.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Supervisor',
            'slug' => 'Responsable de supervisar y coordinar las actividades del equipo.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Validador Business',
            'slug' => 'Encargado de validar información y asegurarse de su veracidad. | Business',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Validador Televentas',
            'slug' => 'Encargado de validar información y asegurarse de su veracidad. | Televentas',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Validador Mulfood',
            'slug' => 'Encargado de validar información y asegurarse de su veracidad. | Mulfood',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Validador Teleservicios',
            'slug' => 'Encargado de validar información y asegurarse de su veracidad. | Teleservicios',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Validador Principal',
            'slug' => 'Encargado de validar información y asegurarse de su veracidad.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
