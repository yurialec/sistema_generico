<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\RoleRepositoryInterface;
use App\Models\Admin\Roles;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    protected $role;

    public function __construct(Roles $role)
    {
        $this->role = $role;
    }

    public function all($term)
    {
        return $this->role
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->where('id', '<>', 1)
            ->paginate(10);
    }

    public function find($id)
    {
        return $this->role->find($id);
    }

    public function create(array $data)
    {
        return $this->role->create($data);
    }

    public function update($id, array $data)
    {
        $role = $this->role->find($id);
        if ($role) {
            $role->update($data);
            return $role;
        }
        return null;
    }

    public function delete($id)
    {
        $role = $this->role->find($id);
        if ($role) {
            $role->delete();
            return true;
        }
        return false;
    }
}
