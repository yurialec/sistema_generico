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

    public function getAll()
    {
        return $this->siteRepository->all();
    }

    public function save($data)
    {
        return $this->siteRepository->save($data);
    }
}