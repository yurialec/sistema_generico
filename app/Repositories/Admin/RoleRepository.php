<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\RoleRepositoryInterface;
use App\Models\Admin\Permissions;
use App\Models\Admin\Roles;
use Exception;
use Illuminate\Support\Facades\Auth;
use Log;

class RoleRepository implements RoleRepositoryInterface
{
    protected $role;
    protected $permissionRoles;
    protected $permissions;

    public function __construct(Roles $role, PermissionsRolesRepository $permissionRoles, Permissions $permissions)
    {
        $this->role = $role;
        $this->permissionRoles = $permissionRoles;
        $this->permissions = $permissions;
    }

    public function all($term)
    {
        try {
            return $this->role
                ->when($term, function ($query) use ($term) {
                    return $query->where('name', 'like', '%' . $term . '%');
                })
                ->where('id', '>=', Auth::user()->role_id)
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar perfis', [$err->getMessage()]);
            return false;
        }

    }

    public function find($id)
    {
        try {
            return $this->role->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar perfil', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->role->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar perfil', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $role = $this->role->find($id);

            $role->update($data);

            if (isset($data['permissions']) && is_array($data['permissions'])) {

                $currentPermissions = $this->permissionRoles->all()->where('role_id', $role->id)->pluck('permission_id')->toArray();

                $permissionsToRemove = array_diff($currentPermissions, $data['permissions']);

                $permissionsToAdd = array_diff($data['permissions'], $currentPermissions);

                foreach ($permissionsToRemove as $permissionId) {
                    $this->permissionRoles->delete($permissionId, $role->id);
                }

                foreach ($permissionsToAdd as $permissionId) {
                    try {
                        $this->permissionRoles->create([
                            'permission_id' => $permissionId,
                            'role_id' => $role->id
                        ]);
                    } catch (Exception $err) {
                        return $err;
                    }
                }
            }

            return $role;
        } catch (Exception $err) {
            Log::error('Erro ao editar perfil', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $role = $this->role->find($id);
            $role->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao deletar perfil', [$err->getMessage()]);
            return false;
        }
    }

    public function listPermissions()
    {
        try {
            return $this->permissions->get();
        } catch (Exception $err) {
            Log::error('Erro listar permissões perfil', [$err->getMessage()]);
            return false;
        }
    }
}
