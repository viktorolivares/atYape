<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_permissions = [

            //Admin
            array('role_id' => '1', 'permission_id' => '1'),
            array('role_id' => '1', 'permission_id' => '2'),
            array('role_id' => '1', 'permission_id' => '3'),
            array('role_id' => '1', 'permission_id' => '4'),
            array('role_id' => '1', 'permission_id' => '5'),
            array('role_id' => '1', 'permission_id' => '6'),
            array('role_id' => '1', 'permission_id' => '7'),
            array('role_id' => '1', 'permission_id' => '8'),
            array('role_id' => '1', 'permission_id' => '9'),
            array('role_id' => '1', 'permission_id' => '10'),
            array('role_id' => '1', 'permission_id' => '11'),
            array('role_id' => '1', 'permission_id' => '12'),
            array('role_id' => '1', 'permission_id' => '13'),
            array('role_id' => '1', 'permission_id' => '14'),
            array('role_id' => '1', 'permission_id' => '15'),
            array('role_id' => '1', 'permission_id' => '16'),
            array('role_id' => '1', 'permission_id' => '17'),
            array('role_id' => '1', 'permission_id' => '18'),
            array('role_id' => '1', 'permission_id' => '19'),
            array('role_id' => '1', 'permission_id' => '20'),
            array('role_id' => '1', 'permission_id' => '21'),
            array('role_id' => '1', 'permission_id' => '22'),
            array('role_id' => '1', 'permission_id' => '23'),

            //Analistas
            array('role_id' => '2', 'permission_id' => '5'),
            array('role_id' => '2', 'permission_id' => '11'),
            array('role_id' => '2', 'permission_id' => '18'),
            array('role_id' => '2', 'permission_id' => '19'),
            array('role_id' => '2', 'permission_id' => '20'),
            array('role_id' => '2', 'permission_id' => '21'),
            array('role_id' => '2', 'permission_id' => '22'),

            //Supervisores
            array('role_id' => '3', 'permission_id' => '1'),
            array('role_id' => '3', 'permission_id' => '2'),
            array('role_id' => '3', 'permission_id' => '3'),
            array('role_id' => '3', 'permission_id' => '4'),
            array('role_id' => '3', 'permission_id' => '5'),
            array('role_id' => '3', 'permission_id' => '10'),
            array('role_id' => '3', 'permission_id' => '11'),
            array('role_id' => '3', 'permission_id' => '12'),
            array('role_id' => '3', 'permission_id' => '13'),
            array('role_id' => '3', 'permission_id' => '14'),
            array('role_id' => '3', 'permission_id' => '18'),

            //Validador Business
            array('role_id' => '4', 'permission_id' => '5'),
            array('role_id' => '4', 'permission_id' => '14'),
            array('role_id' => '4', 'permission_id' => '18'),

            //Validador Televentas
            array('role_id' => '5', 'permission_id' => '5'),
            array('role_id' => '5', 'permission_id' => '17'),
            array('role_id' => '5', 'permission_id' => '18'),

            //Validador Mulfood
            array('role_id' => '6', 'permission_id' => '5'),
            array('role_id' => '6', 'permission_id' => '15'),
            array('role_id' => '6', 'permission_id' => '18'),

            //Validador Teleservicios
            array('role_id' => '7', 'permission_id' => '5'),
            array('role_id' => '7', 'permission_id' => '16'),
            array('role_id' => '7', 'permission_id' => '18'),

            //Validador Principal
            array('role_id' => '8', 'permission_id' => '5'),
            array('role_id' => '8', 'permission_id' => '14'),
            array('role_id' => '8', 'permission_id' => '15'),
            array('role_id' => '8', 'permission_id' => '16'),
            array('role_id' => '8', 'permission_id' => '17'),
            array('role_id' => '8', 'permission_id' => '18'),

        ];

        DB::table('role_permissions')->insert($role_permissions);
    }
}
