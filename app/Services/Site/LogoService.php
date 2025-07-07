<?php

namespace App\Services\Site;

use App\Repositories\Site\LogoRepository;
use Illuminate\Support\Facades\Storage;

class LogoService
{
    protected $logoRepository;

    public function __construct(LogoRepository $logoRepository)
    {
        $this->logoRepository = $logoRepository;
    }

    public function getLogo()
    {
        return $this->logoRepository->getLogo();
    }

    public function find($id)
    {
        return $this->logoRepository->find($id);
    }

    public function createLogo($data)
    {
        $image = $data['image'];
        $image_urn = $image->store('site/logo/images', 'public');

        $data['image'] = $image_urn;

        $data = [
            'name' => $data['name'],
            'image' => $data['image'],
        ];

        return $this->logoRepository->create($data);
    }

    public function updateLogo($id, $data)
    {
        return $this->logoRepository->update($id, $data);
    }

    public function deleteLogo($id)
    {
        return $this->logoRepository->delete($id);
    }
}
