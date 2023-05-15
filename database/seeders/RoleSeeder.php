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
            'slug' => 'Responsable de administrar y mantener el sistemas.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Validador',
            'slug' => 'Encargado de validar información y asegurarse de su veracidad y precisión.',
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
            'name' => 'Analista',
            'slug' => 'Encargado de analizar y procesar datos para obtener información relevante y tomar decisiones estratégicas.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
