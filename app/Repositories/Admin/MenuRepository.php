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

    public function sidebar()
    {
        try {
            return $this->menu
                ->with('children')
                ->whereNull('son')
                ->orderBy('order', 'asc')
                ->get();
        } catch (Exception $err) {
            Log::error('Erro sidebar', ['Erro' => $err->getMessage()]);
            return false;
        }
    }

    public function all($term)
    {
        try {
            return $this->menu
                ->when($term, function ($query) use ($term) {
                    return $query->where('name', 'like', '%' . $term . '%');
                })
                ->whereNull('son')
                ->orderBy('order', 'asc')
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar menus', ['Erro' => $err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->menu
                ->with('children')
                ->where('id', $id)
                ->first();
        } catch (Exception $err) {
            Log::error('Erro ao localizar menu', ['Erro' => $err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->menu->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar menu', ['Erro' => $err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $menu = $this->menu->find($id);
            $menu->update($data);
            return $menu;
        } catch (Exception $err) {
            Log::error('Erro ao editar menu', ['Erro' => $err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $menu = $this->menu->find($id);
            $this->deleteSubmenus($menu);
            $menu->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao excluir menu', ['Erro' => $err->getMessage()]);
            return false;
        }
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
