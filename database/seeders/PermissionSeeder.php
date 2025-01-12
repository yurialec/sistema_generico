<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'manter-usuarios', 'label' => 'Adm Usuários'],
            ['name' => 'manter-perfis', 'label' => 'Adm Perfis'],
            ['name' => 'manter-permissoes', 'label' => 'Adm Permissões'],
            ['name' => 'manter-menus', 'label' => 'Adm Menus'],
            ['name' => 'manter-logo', 'label' => 'Adm Logotipo'],
            ['name' => 'manter-texto-principal', 'label' => 'Site Texto Principal'],
            ['name' => 'manter-carousel', 'label' => 'Site Carousel'],
            ['name' => 'manter-sobre', 'label' => 'Site Sobre'],
            ['name' => 'manter-contato', 'label' => 'Site Contato'],
            ['name' => 'manter-midias-sociais', 'label' => 'Site Mídias Sociais'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission['name'],
                'label' => $permission['label'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
