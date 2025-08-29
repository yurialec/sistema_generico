<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\FeedbackRepositoryInterface;
use App\Models\Admin\Feedback;
use Exception;
use Illuminate\Support\Facades\Log;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    protected $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function all($term)
    {
        try {
            return $this->feedback->with('user')
                ->when($term, function ($query) use ($term) {
                    return $query->where('title', 'like', '%' . $term . '%');
                })
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar registros Feedback', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->feedback->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar registro Feedback', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {

            if (isset($data['image'])) {
                $createData['image_path'] = $data['image'];
            }

            if (isset($data['title'])) {
                $createData['title'] = $data['title'];
            }

            if (isset($data['description'])) {
                $createData['description'] = $data['description'];
            }

            if (isset($data['user_id'])) {
                $createData['user_id'] = $data['user_id'];
            }

            return $this->feedback->create($createData);
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar Feedback', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, array $data)
    {
        try {
            $item = $this->feedback->find($id);
            $item->update($data);
            return $item;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar Feedback', [$err->getMessage()]);
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $item = $this->feedback->find($id);
            $item->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao excluir Feedback', [$err->getMessage()]);
            return false;
        }
    }
}