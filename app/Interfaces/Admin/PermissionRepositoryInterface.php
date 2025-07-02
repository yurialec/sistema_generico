<?php

namespace App\Interfaces\Admin;

interface PermissionRepositoryInterface
{
    public function list($term);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
