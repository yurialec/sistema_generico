<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Models\Admin\Permissions;
use Exception;
use Log;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $permission;

    public function __construct(Permissions $permission)
    {
        $this->permission = $permission;
    }

    public function list($term = null)
    {
        try {
            return $this->permission
                ->when($term, function ($query) use ($term) {
                    return $query->where('name', 'like', '%' . $term . '%')
                        ->orWhere('label', 'like', '%' . $term . '%');
                })
                ->paginate(6);
        } catch (Exception $err) {
            Log::error('Erro ao listar permissões', [$err->getMessage()]);
            return false;
        }

    }

    public function find($id)
    {
        try {
            return $this->permission->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar permissão', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->permission->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadatrar permissão', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, array $data)
    {
        try {
            $permission = $this->permission->find($id);
            $permission->update($data);
            return $permission;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar permissão', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $permission = $this->permission->find($id);
            $permission->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao excluir permissão', [$err->getMessage()]);
            return false;
        }
    }
}
