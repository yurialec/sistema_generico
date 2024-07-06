<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Models\Admin\Roles;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $role;
    public function __construct(Roles $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        return view('admin.roles.index');
    }

    public function list(Request $request)
    {
        $query = $this->role->query();
        if ($request->has('search')) {
            $searchTerm = $request->query('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $role = $query->paginate(15);
        return response()->json($role);
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(CreateRoleRequest $request)
    {
        $role = $this->role->create([
            'name' => $request->name,
        ]);

        if ($role) {
            return response()->json($role, 201);
        } else {
            return response()->json(['Erro ao incluir registro', 204]);
        }
    }

    public function edit(string $id)
    {
        $role = Roles::where('id', $id)->first();
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, string $id)
    {
        $role = Roles::where('id', $id)->first();
        if ($role) {
            $role->name = $request->name;

            if ($role->save()) {
                return response()->json($role, 201);
            } else {
                return response()->json(['Erro ao atualizar registro', 204]);
            }
        } else {
            return response()->json(['Erro ao localizar registro', 204]);
        }
    }

    public function delete(string $id)
    {
        $role = Roles::where('id', $id)->first();
        if ($role) {
            if ($role->delete()) {
                return response()->json([
                    'message' => 'Registro excluido com sucesso.',
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Erro ao excluir registro.',
                    'status' => 204
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Nenhum resultado encontrado.',
                'status' => 204
            ]);
        }
    }
}
