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
        $menuCollection = $this->menuRepository->find($id);
        $menu = $menuCollection->first();

        if (!$menu) {
            throw new \Exception("Menu não encontrado.");
        }

        $existingChildren = $menu->children()->get();

        $existingIds = $existingChildren->pluck('id')->toArray();

        $menusToAdd = [];
        $menusToRemove = [];

        foreach ($data['children'] as $childData) {
            if (isset($childData['id']) && in_array($childData['id'], $existingIds)) {
                $child = $existingChildren->where('id', $childData['id'])->first();
                $child->update($childData);
            } else {
                $menusToAdd[] = $childData;
            }
        }

        foreach ($existingChildren as $existingChild) {
            if (!in_array($existingChild->id, array_column($data['children'], 'id'))) {
                $menusToRemove[] = $existingChild->id;
                $existingChild->delete();
            }
        }

        foreach ($menusToAdd as $menuToAdd) {
            $menuToAdd['son'] = $menu->id;
            $menu->children()->create($menuToAdd);
        }

        $menu->update($data);
        return $menu;
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
