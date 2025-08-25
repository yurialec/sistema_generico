<?php

namespace App\Services\Admin;

use App\Models\Admin\Menu;
use App\Repositories\Admin\MenuRepository;

class MenuService
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function sidebar()
    {
        return $this->menuRepository->sidebar();
    }

    public function getAllMenus($term)
    {
        return $this->menuRepository->all($term);
    }

    public function find($id)
    {
        return $this->menuRepository->find($id);
    }

    public function createMenu($data)
    {
        $data = [
            'label' => $data['label'],
            'icon' => $data['icon'],
            'url' => $data['url'] ? $data['url'] : '#',
            'active' => 1,
            'son' => null,
            'order' => Menu::whereNull('son')->max('order') + 1,
            'created_at' => now(),
            'updated_at' => now()
        ];

        return $this->menuRepository->create($data);
    }

    public function updateMenu($id, $data)
    {
        return $this->menuRepository->update($id, $data);
    }

    public function deleteMenu($id)
    {
        return $this->menuRepository->delete($id);
    }

    public function changeOrderMenu($id)
    {
        return $this->menuRepository->changeOrderMenu($id);
    }
}
