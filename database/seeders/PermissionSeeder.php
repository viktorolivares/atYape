<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Users
        DB::table('permissions')->insert([
            'name' => 'Crear Usuario',
            'slug' => 'users.create',
            'module_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Ver Usuario',
            'slug' => 'users.index',
            'module_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Actualizar Usuario',
            'slug' => 'users.edit',
            'module_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Eliminar Usuario',
            'slug' => 'users.delete',
            'module_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Perfil de Usuario',
            'slug' => 'users.profile',
            'module_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Roles
        DB::table('permissions')->insert([
            'name' => 'Crear Roles',
            'slug' => 'roles.create',
            'module_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Ver Roles',
            'slug' => 'roles.index',
            'module_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Actualizar Roles',
            'slug' => 'roles.edit',
            'module_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Eliminar Roles',
            'slug' => 'roles.delete',
            'module_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Permissions
        DB::table('permissions')->insert([
            'name' => 'Crear Permisos',
            'slug' => 'permissions.create',
            'module_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Ver Permisos',
            'slug' => 'permissions.index',
            'module_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Actualizar Permisos',
            'slug' => 'permissions.edit',
            'module_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Eliminar Permisos',
            'slug' => 'permissions.delete',
            'module_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Transactions
        DB::table('permissions')->insert([
            'name' => 'Crear Transacciones',
            'slug' => 'transactions.create',
            'module_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Ver Transacciones',
            'slug' => 'transactions.index',
            'module_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Actualizar Transacciones',
            'slug' => 'transactions.edit',
            'module_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Eliminar Transacciones',
            'slug' => 'transactions.delete',
            'module_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Yape
        DB::table('permissions')->insert([
            'name' => 'Business',
            'slug' => 'yape.business',
            'module_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Mulfood',
            'slug' => 'yape.mulfood',
            'module_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Teleservicios',
            'slug' => 'yape.teleservicios',
            'module_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Televentas',
            'slug' => 'yape.televentas',
            'module_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //Uilidades
        DB::table('permissions')->insert([
            'name' => 'Dashboard',
            'slug' => 'dashboard.index',
            'module_id' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Dominios',
            'slug' => 'domain.index',
            'module_id' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'DNI',
            'slug' => 'dni.index',
            'module_id' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'IP',
            'slug' => 'ip.index',
            'module_id' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
