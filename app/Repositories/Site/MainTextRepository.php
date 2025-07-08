<?php

namespace App\Repositories\Site;

use App\Interfaces\Site\MainTextRepositoryInterface;
use App\Models\Site\MainText;
use Exception;
use Log;

class MainTextRepository implements MainTextRepositoryInterface
{
    protected $mainText;

    public function __construct(MainText $mainText)
    {
        $this->mainText = $mainText;
    }

    public function getMainText()
    {
        try {
            return $this->mainText->first();
        } catch (Exception $err) {
            Log::error('Erro o listar texto pricipal', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->mainText->find($id);
        } catch (Exception $err) {
            Log::error('Erro o listar texto pricipal', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->mainText->create($data);
        } catch (Exception $err) {
            Log::error('Erro o cadastrar texto pricipal', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $mainText = $this->mainText->find($id);
            $mainText->update($data);
            return $mainText;
        } catch (Exception $err) {
            Log::error('Erro o editar texto pricipal', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $mainText = $this->mainText->find($id);
            $mainText->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro o editar texto pricipal', [$err->getMessage()]);
            return false;
        }
    }

}
