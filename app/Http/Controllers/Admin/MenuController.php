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

    public function sidebar()
    {
        $sidebar = $this->menuService->sidebar();
        if ($sidebar) {
            return response()->json([
                'status' => true,
                'sidebar' => $sidebar,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao carregar sidebar.'
            ], 500);
        }
    }

    public function index()
    {
        return view('admin.menus.index');
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $menu = $this->menuService->createMenu($request->all());

        if ($menu) {
            return response()->json([
                'status' => true,
                'menu' => $menu,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar menu'
            ], 500);
        }
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
                'status' => 500
            ]);
        }
    }

    public function edit(string $id)
    {
        return view('admin.menus.edit', compact('id'));
    }

    public function find($id)
    {
        $menu = $this->menuService->find($id);
        if ($menu) {
            return response()->json([
                'status' => true,
                'menu' => $menu,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar menu'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $menu = $this->menuService->updateMenu($id, $request->all());

        if ($menu) {
            return response()->json([
                'status' => true,
                'menu' => $menu,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar menu'
            ], 500);
        }
    }

    public function delete(string $id)
    {
        $menu = $this->menuService->deleteMenu($id);

        if ($menu) {
            return response()->json([
                'status' => true,
                'message' => 'Usuário excluio com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir usuário'
            ], 500);
        }
    }

    public function changeOrderMenu($id)
    {
        $changedMenu = $this->menuService->changeOrderMenu($id);
        if ($changedMenu) {

            return response()->json([
                'status' => true,
                'message' => 'Ordem alterada com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao alterar ordem'
            ], 204);
        }
    }
}
