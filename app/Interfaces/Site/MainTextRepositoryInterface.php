<?php

namespace App\Interfaces\Site;

interface MainTextRepositoryInterface
{
    public function getMainText();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
