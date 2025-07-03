<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Log;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all($term)
    {
        try {
            return $this->user
                ->when($term, function ($query) use ($term) {
                    return $query->where('name', 'like', '%' . $term . '%');
                })
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar usuários', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->user->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar usuário', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->user->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar usuários', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $user = $this->user->find($id);
            $user->update($data);
            return $user;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar usuário', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $user = $this->user->find($id);
            $user->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar usuário', [$err->getMessage()]);
            return false;
        }
    }
}
