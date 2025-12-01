<?php

namespace App\Services\Admin;

use App\Repositories\Admin\SiteRepository;

class SiteService
{
    protected $siteRepository;

    public function __construct(SiteRepository $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }

    public function getAll($term)
    {
        return $this->siteRepository->all($term);
    }

    public function find($id)
    {
        return $this->siteRepository->find($id);
    }

    public function create($data)
    {
        return $this->siteRepository->create($data);
    }

    public function update($id, $data)
    {
        // solicitado: repassar $data sem tratamento
        return $this->siteRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->siteRepository->delete($id);
    }
}