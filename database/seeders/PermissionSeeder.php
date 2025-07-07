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
            ['name' => 'keep-users', 'label' => 'Manter Usuários'],
            ['name' => 'keep-roles', 'label' => 'Manter Perfis'],
            ['name' => 'keep-permissions', 'label' => 'Manter Permissões'],
            ['name' => 'keep-menu', 'label' => 'Manter Menus'],
            ['name' => 'keep-logo', 'label' => 'Manter Logo'],
            ['name' => 'keep-main-text', 'label' => 'Manter Texto Principal'],
            ['name' => 'keep-carousel', 'label' => 'Manter Carrousel'],
            ['name' => 'keep-site-about', 'label' => 'Manter Sobre'],
            ['name' => 'keep-contact', 'label' => 'Manter Contato'],
            ['name' => 'keep-social-media', 'label' => 'Manter Midias Sociais'],
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
