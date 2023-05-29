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
            'firstname' => 'Admin',
            'lastname' => 'Prevención',
            'email' => 'prevencion@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Victor',
            'lastname' => 'Olivares',
            'email' => 'victor.olivares@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Juan Carlos',
            'lastname' => 'López Neciosup',
            'email' => 'juancarlos.lopez@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Andrés',
            'lastname' => 'Arismendis Guerreros',
            'email' => 'luis.arismendis@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Jenson',
            'lastname' => 'Paico Vega',
            'email' => 'jenson.paico@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Karla',
            'lastname' => 'Panez Vega',
            'email' => 'karla.panez@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
