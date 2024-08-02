<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MenuRepositoryInterface;
use App\Models\Admin\Menu;
use Exception;

class MenuRepository implements MenuRepositoryInterface
{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function all($term)
    {
        return $this->menu
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->whereNull('son')
            ->paginate(10);
    }

    public function find($id)
    {
        return $this->menu
            ->find($id)
            ->with('children')
            ->whereNull('son')
            ->get();
    }

    public function create(array $data)
    {
        return $this->menu->create($data);
    }

    public function update($id, $data)
    {
        $menu = $this->menu->find($id);
        $menu->update($data);
        return $menu;
    }

    public function delete($id)
    {
        $menu = $this->menu->find($id);
        if ($menu) {
            $menu->delete();
            return true;
        }
        return false;
    }
}
