<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\StorePermissionReqest;
use App\Http\Requests\Admin\Permission\UpdatePermissionRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Services\Admin\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller
{
    protected $permissionService;
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('admin.permissions.index');
    }

    public function list(Request $request)
    {
        $permission = $this->permissionService->list($request->input('search'));
        if ($permission) {
            return response()->json([
                'status' => true,
                'permission' => $permission
            ], 200);
        } else {
            return response()->json([
                'message' => 'Nenhum registro encontrado.',
                'status' => 500
            ]);
        }
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(StorePermissionReqest $request)
    {
        $permission = $this->permissionService->storePermission($request->all());

        if ($permission) {
            return response()->json([
                'status' => true,
                'permission' => $permission,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar permissão'
            ], 500);
        }
    }

    public function edit(string $id)
    {
        return view('admin.permissions.edit', compact('id'));
    }

    public function find($id)
    {
        $permission = $this->permissionService->find($id);

        if ($permission) {
            return response()->json([
                'status' => true,
                'permission' => $permission,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar permissão'
            ], 500);
        }
    }

    public function update(UpdatePermissionRequest $request, string $id)
    {
        $permission = $this->permissionService->updatePermission($id, $request->all());

        if ($permission) {
            return response()->json([
                'status' => true,
                'permission' => $permission,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar permissão'
            ], 500);
        }
    }

    public function delete(string $id)
    {
        $permission = $this->permissionService->deletePermission($id);
        if ($permission) {
            return response()->json([
                'status' => true,
                'message' => 'Permissão excluio com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir permissão'
            ], 500);
        }
    }
}
