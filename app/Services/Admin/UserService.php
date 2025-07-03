<?php

namespace App\Services\Admin;

use App\Repositories\Admin\UserRepository;
use Hash;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($term)
    {
        return $this->userRepository->all($term);
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser($data)
    {
        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id']
        ];

        return $this->userRepository->create($data);
    }

    public function updateUser($id, $data)
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id']
        ];

        if (isset($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return Auth::id() != $id ? $this->userRepository->delete($id) : false;
    }
}
