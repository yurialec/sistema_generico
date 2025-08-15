<?php

namespace App\Repositories\Site;

use App\Interfaces\Site\AboutRepositoryInterface;
use App\Models\Site\SiteAbout;
use Exception;
use Log;

class AboutRepository implements AboutRepositoryInterface
{
    protected $about;

    public function __construct(SiteAbout $about)
    {
        $this->about = $about;
    }

    public function all()
    {
        try {
            return $this->about->first();
        } catch (Exception $err) {
            Log::error('Erro ao localizar sobre', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->about->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar sobre', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            if (isset($data['image'])) {
                $createData['image'] = $data['image'];
            }

            if (isset($data['title'])) {
                $createData['title'] = $data['title'];
            }

            if (isset($data['description'])) {
                $createData['description'] = $data['description'];
            }

            return $this->about->create($createData);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar sobre', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $about = $this->about->find($id);

            $updateData = [
                'title' => null,
                'description' => null,
            ];

            if (isset($data['image_urn'])) {
                $updateData['image'] = $data['image_urn'];
            }

            if (isset($data['title'])) {
                $updateData['title'] = $data['title'];
            }

            if (isset($data['description'])) {
                $updateData['description'] = $data['description'];
            }

            $about->update($updateData);

            return $about;

        } catch (Exception $err) {
            Log::error('Erro ao cadastrar sobre', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $about = $this->about->find($id);
            $about->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar sobre', [$err->getMessage()]);
            return false;
        }
    }
}
