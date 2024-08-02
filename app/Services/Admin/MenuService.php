<?php

namespace App\Services\Admin;

use App\Repositories\Admin\MenuRepository;

class MenuService
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getAllMenus($term)
    {
        return $this->menuRepository->all($term);
    }

    public function getMenuById($id)
    {
        return $this->menuRepository->find($id);
    }

    public function createMenu($data)
    {
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
}
