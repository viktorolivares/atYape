<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'firstname' => 'Prevención',
            'lastname' => 'Online',
            'email' => 'prevencion@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'VICTOR',
            'lastname' => 'OLIVARES',
            'email' => 'victor.olivares@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'JUAN CARLOS',
            'lastname' => 'LÓPEZ NECIOSUP',
            'email' => 'juancarlos.lopez@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'ANDRÉS',
            'lastname' => 'ARISMENDIS GUERREROS',
            'email' => 'luis.arismendis@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'JENSON',
            'lastname' => 'PAICO VEGA',
            'email' => 'jenson.paico@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'KARLA',
            'lastname' => 'PANEZ VEGA',
            'email' => 'karla.panez@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
