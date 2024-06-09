<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            'dashboard' => [
                'label' => 'Dashboard',
                'icon' => 'fa-solid fa-gauge-high',
                'url' => '/helpdesk/dashboard/',
                'active' => 0,
                'son' => 0,
            ],
            'usuarios' => [
                'label' => 'Usuários',
                'icon' => 'fa-solid fa-users-gears',
                'url' => '/helpdesk/usuarios/',
                'active' => 0,
                'son' => 0,
            ],
            'perfis' => [
                'label' => 'Perfis',
                'icon' => 'fa-solid fa-id-badge',
                'url' => '/helpdesk/perfis/',
                'active' => 0,
                'son' => 0,
            ],
            'permissoes' => [
                'label' => 'Permissões',
                'icon' => 'fa-solid fa-key',
                'url' => '/helpdesk/permissoes/',
                'active' => 0,
                'son' => 0,
            ],
        ];

        foreach ($menus as $key => $menu) {
            DB::table('menus')->insert([
                'label' => $menu['label'],
                'icon' => $menu['icon'],
                'url' => $menu['url'],
                'active' => $menu['active'],
                'son' => $menu['son'],
            ]);
        }
    }
}
