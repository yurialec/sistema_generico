<?php

namespace App\Repositories\Site;

use App\Interfaces\Site\SocialMediaRepositoryInterface;
use App\Models\Site\SiteSocialMedia;
use Exception;
use Log;

class SocialMediaRepository implements SocialMediaRepositoryInterface
{
    protected $socialMedia;

    public function __construct(SiteSocialMedia $socialMedia)
    {
        $this->socialMedia = $socialMedia;
    }

    public function all()
    {
        try {
            return $this->socialMedia->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar redes sociais', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->socialMedia->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar redes sociais', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->socialMedia->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar redes sociais', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {        
        try {
            $socialMedia = $this->socialMedia->find($id);
            $socialMedia->update($data);

            return $socialMedia;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar redes sociais', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $socialMedia = $this->socialMedia->find($id);
            $socialMedia->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao deletar redes sociais', [$err->getMessage()]);
            return false;
        }
    }
}
