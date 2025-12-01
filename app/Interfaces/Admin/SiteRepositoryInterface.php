<?php

namespace App\Interfaces\Admin;

interface SiteRepositoryInterface
{
    public function all();
    public function save(array $data);
}