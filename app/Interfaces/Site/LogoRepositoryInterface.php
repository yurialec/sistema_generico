<?php

namespace App\Interfaces\Site;

interface LogoRepositoryInterface
{
    public function getLogo();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
