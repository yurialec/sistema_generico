<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Menu;
use App\Services\Admin\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuService;
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function menus()
    {
        $menus = Menu::with('children')->whereNull('son')->get();
        return response()->json($menus);
    }

    public function index()
    {
        return view('admin.menus.index');
    }

    public function list(Request $request)
    {
        $menus = $this->menuService->getAllMenus($request->input('search'));

        if ($menus) {
            return response()->json([
                'status' => true,
                'menus' => $menus
            ], 200);
        } else {
            return response()->json([
                'message' => 'Nenhum registro encontrado.',
                'status' => 204
            ]);
        }
    }

    public function edit(string $id)
    {
        $menu = $this->menuService->getMenuById($id);
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, string $id)
    {
        $user = $this->menuService->updateMenu($id, $request->all());

        if ($user) {
            return response()->json([
                'status' => true,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar menu'
            ], 204);
        }
    }
}
