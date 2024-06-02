<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Yuri Chagas',
            'email' => 'yuri.alec@hotmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 1,
        ]);
    }
}
