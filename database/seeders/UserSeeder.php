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
            'firstname' => 'PREVENCIÓN',
            'lastname' => 'ONLINE',
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

        DB::table('users')->insert([
            'firstname' => 'LUIS',
            'lastname' => 'VARGAS MADGE',
            'email' => 'luis.vargas@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'JUAN CARLOS',
            'lastname' => 'GUEVARA CARRASCO',
            'email' => 'juancarlos.guevara@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'JEAN PIERRE',
            'lastname' => 'SALAS ROJAS',
            'email' => 'jean.salas@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'MARCELO',
            'lastname' => 'CHÁVEZ GUEVARA',
            'email' => 'marcelo.chavez@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('users')->insert([
            'firstname' => 'EDWARD',
            'lastname' => 'ALCARRAZ CÓRDOVA',
            'email' => 'edward.alcarraz@apuestatotal.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'HERNAN',
            'lastname' => 'LAZO MONTOYA',
            'email' => 'hernan.lazo@apuestatotal.com',
            'password' => Hash::make('42790373'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'CRIS JUSETH',
            'lastname' => 'QUISPE JUNCO',
            'email' => 'cris.quispe@apuestatotal.net',
            'password' => Hash::make('71073894'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('users')->insert([
            'firstname' => 'PABLO JHUNIOR',
            'lastname' => 'MELGAR ALVARADO',
            'email' => 'pablo.melgar@apuestatotal.net',
            'password' => Hash::make('76429256'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'JARICK OSCAR',
            'lastname' => 'CALLIRGOS ANGELES',
            'email' => 'jarick.callirgos@apuestatotal.net',
            'password' => Hash::make('70930681'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'EFFIO CORTEZ',
            'lastname' => 'VERENICE YOHANA',
            'email' => 'verenice.effio@apuestatotal.net',
            'password' => Hash::make('75476427'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('users')->insert([
            'firstname' => 'RICARDO RIVERT',
            'lastname' => 'TAFUR REAP',
            'email' => 'ricardo.tafur@apuestatotal.net',
            'password' => Hash::make('41354125'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'KEVIN',
            'lastname' => 'TAFUR VICTORIO',
            'email' => 'kevin.tafur@apuestatotal.net',
            'password' => Hash::make('48368165'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'TAHIRY SHASURY',
            'lastname' => 'REYES REYES',
            'email' => 'tv.reyes@apuestatotal.net',
            'password' => Hash::make('77804185'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'CLAUDIO VICTOR',
            'lastname' => 'RODRIGUEZ ZAPATA',
            'email' => 'tv.rodriguez@apuestatotal.net',
            'password' => Hash::make('72739432'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'FRANK SAUL',
            'lastname' => 'PACHECO GRANADOS',
            'email' => 'tv.pacheco@apuestatotal.net',
            'password' => Hash::make('71119175'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'JOISSI GABRIEL',
            'lastname' => 'VÁSQUEZ DA COSTA',
            'email' => 'tv.vasquez@apuestatotal.net',
            'password' => Hash::make('78888525'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'PATRICK JAVIER',
            'lastname' => 'ORTEGA KARLOS',
            'email' => 'tv.ortega@apuestatotal.net',
            'password' => Hash::make('70800537'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'KAHEL ALEXANDER',
            'lastname' => 'BOCANEGRA CAMPOS',
            'email' => 'tv.bocanegra@apuestatotal.net',
            'password' => Hash::make('76216010'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'JORDAN RODOLFO',
            'lastname' => 'FRANCISCO DOROTEO',
            'email' => 'tv.francisco@apuestatotal.net',
            'password' => Hash::make('75246621'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'MELANIE ROSE',
            'lastname' => 'DEL AGUILA MORALES',
            'email' => 'tv.delaguila@apuestatotal.net',
            'password' => Hash::make('77520597'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'MANUEL PEDRO',
            'lastname' => 'MATIENZO VEGA',
            'email' => 'tv.matienzo@apuestatotal.net',
            'password' => Hash::make('75128897'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'KRISTELL ALEXANDRA',
            'lastname' => 'MEDINA MORE',
            'email' => 'tv.medina@apuestatotal.net',
            'password' => Hash::make('75357941'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'TATIANA',
            'lastname' => 'LAO MOZOMBITE',
            'email' => 'tv.lao@apuestatotal.net',
            'password' => Hash::make('47297814'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'MARLON BRUCE',
            'lastname' => 'BAEZ CASTELLANO',
            'email' => 'tv.bruce@apuestatotal.net',
            'password' => Hash::make('73666305'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'JULIO CESAR',
            'lastname' => 'MARICAHUA IHUARAQUI',
            'email' => 'tv.maricahua@apuestatotal.net',
            'password' => Hash::make('70161587'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'WENDY GIOVANA',
            'lastname' => 'SILVA CENTENO',
            'email' => 'tv.silva@apuestatotal.net',
            'password' => Hash::make('45783589'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'MICHEL JONATHAN',
            'lastname' => 'RAMIREZ SALAZAR',
            'email' => 'tv.ramirez@apuestatotal.net',
            'password' => Hash::make('46482291'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'MARIA DE LOS ANGELES',
            'lastname' => 'MOLINA MACHICA',
            'email' => 'tv.molina@apuestatotal.net',
            'password' => Hash::make('71299026'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'firstname' => 'ALEJANDRA',
            'lastname' => 'MAYTA MINAYA',
            'email' => 'tv.mayta@apuestatotal.net',
            'password' => Hash::make('47174252'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
