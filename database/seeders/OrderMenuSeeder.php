<?php

namespace Database\Seeders;

use App\Models\Admin\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainMenus = Menu::whereNull('son')->get();
        foreach ($mainMenus as $index => $menu) {
            $menu->order = $index + 1;
            $menu->save();
        }
    }
}
