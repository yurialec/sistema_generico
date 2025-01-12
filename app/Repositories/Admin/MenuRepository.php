<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MenuRepositoryInterface;
use App\Models\Admin\Menu;
use Exception;
use Log;

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
            ->where('id', $id)
            ->get();
    }

    public function create(array $data)
    {
        return $this->menu->create([
            'label' => $data['label'],
            'icon' => $data['icon'],
            'url' => '#',
            'active' => 1,
            'son' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function update($id, $data)
    {
        $menu = $this->menu->find($id);

        if (isset($data['children'])) {
            foreach ($data['children'] as $childData) {
                $child = $this->menu->children()->find($childData['id'] ?? null);
                if ($child) {
                    $child->update($childData);
                } else {
                    $menu->children()->create($childData);
                }
            }
        }

        return $menu;
    }

    public function delete($id)
    {
        $menu = $this->menu->find($id);

        if ($menu) {
            $this->deleteSubmenus($menu);
            $menu->delete();

            return true;
        }

        return false;
    }

    protected function deleteSubmenus(Menu $menu)
    {
        foreach ($menu->children as $submenu) {
            $this->deleteSubmenus($submenu);
            $submenu->delete();
        }
    }

    public function changeOrderMenu($menuId)
    {
        try {
            $actualMenu = $this->menu->find($menuId);
            if (!$actualMenu) {
                throw new Exception("Menu com ID $menuId não encontrado.");
            }

            $menuToChange = $this->menu
                ->where('order', $actualMenu->order - 1)
                ->first();

            if ($menuToChange) {
                $menuToChange->order += 1;
                $menuToChange->save();
            }

            $actualMenu->order -= 1;
            $actualMenu->save();

            return true;

        } catch (Exception $err) {
            Log::error('Erro ao alterar ordem dos menus', [
                'message' => $err->getMessage(),
                'menu_id' => $menuId,
            ]);
            return false;
        }
    }
}
