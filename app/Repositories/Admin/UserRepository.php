<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\UserRepositoryInterface;
use App\Models\User;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all($term)
    {
        return $this->user
            ->when($term, function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->paginate(10);
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function update($id, $data)
    {
        $user = $this->user->find($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
