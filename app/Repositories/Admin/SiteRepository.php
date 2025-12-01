<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SiteRepositoryInterface;
use App\Models\Admin\Site;
use Exception;
use Illuminate\Support\Facades\Log;

class SiteRepository implements SiteRepositoryInterface
{
    protected $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function all($term)
    {
        try {
            return $this->site
                ->when($term, function ($query) use ($term) {
                    // ajuste seus campos de busca aqui
                    return $query->where('id', 'like', '%' . $term . '%');
                })
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar registros Site', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->site->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar registro Site', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->site->create($data);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar Site', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, array $data)
    {
        try {
            $item = $this->site->find($id);
            $item->update($data);
            return $item;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar Site', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $item = $this->site->find($id);
            $item->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao excluir Site', [$err->getMessage()]);
            return false;
        }
    }
}