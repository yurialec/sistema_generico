<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Desenvolvedor',
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'Admin',
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'Auxiliar',
        ]);

        DB::table('roles')->insert([
            'id' => 4,
            'name' => 'Cliente',
        ]);
    }
}
