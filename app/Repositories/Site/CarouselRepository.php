<?php

namespace App\Repositories\Site;

use App\Interfaces\Site\CarouselRepositoryInterface;
use App\Models\Site\SiteCarousel;
use Exception;
use Log;

class CarouselRepository implements CarouselRepositoryInterface
{
    protected $carousel;

    public function __construct(SiteCarousel $carousel)
    {
        $this->carousel = $carousel;
    }

    public function all()
    {
        try {
            return $this->carousel->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar carousel', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->carousel->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar carousel', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            $createData['image'] = $data['image'];
            return $this->carousel->create($createData);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar carousel', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $carousel = $this->carousel->find($id);

            $updateData = [];

            if (isset($data['image_urn'])) {
                $updateData['image'] = $data['image_urn'];
            }

            $carousel->update($updateData);

            return $carousel;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar carousel', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $carousel = $this->carousel->find($id);
            $carousel->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar carousel', [$err->getMessage()]);
            return false;
        }
    }
}
