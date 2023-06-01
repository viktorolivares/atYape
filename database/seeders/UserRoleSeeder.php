<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_roles = [
            //Admin
            array('user_id' => '1', 'role_id' => '1'),
            //Analistas
            array('user_id' => '2', 'role_id' => '2'),
            array('user_id' => '3', 'role_id' => '2'),
            array('user_id' => '4', 'role_id' => '2'),
            array('user_id' => '5', 'role_id' => '2'),
            array('user_id' => '6', 'role_id' => '2'),
            array('user_id' => '7', 'role_id' => '2'),
            array('user_id' => '8', 'role_id' => '2'),
            array('user_id' => '9', 'role_id' => '2'),
            array('user_id' => '10', 'role_id' => '2'),
            array('user_id' => '11', 'role_id' => '2'),
            //Supervisores
            array('user_id' => '12', 'role_id' => '3'),
            array('user_id' => '13', 'role_id' => '3'),
            array('user_id' => '14', 'role_id' => '3'),
            array('user_id' => '15', 'role_id' => '3'),
            array('user_id' => '16', 'role_id' => '3'),
            array('user_id' => '17', 'role_id' => '3'),
            array('user_id' => '18', 'role_id' => '3'),

        ];

        DB::table('user_roles')->insert($user_roles);
    }
}
