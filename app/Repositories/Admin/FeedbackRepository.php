<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\FeedbackRepositoryInterface;
use App\Models\Admin\Feedback;
use App\Models\Admin\FeedbackEvidence;
use Exception;
use Illuminate\Support\Facades\Log;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    protected $feedback;
    protected $evidences;

    public function __construct(Feedback $feedback, FeedbackEvidence $evidences)
    {
        $this->feedback = $feedback;
        $this->evidences = $evidences;
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
            return $this->feedback->with('user')->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar registro Feedback', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $data)
    {
        try {
            $feedbackData = [];
            $feedbackEvidenceData = [];

            if (isset($data['title'])) {
                $feedbackData['title'] = $data['title'];
            }

            if (isset($data['description'])) {
                $feedbackData['description'] = $data['description'];
            }

            if (isset($data['user_id'])) {
                $feedbackData['user_id'] = $data['user_id'];
            }

            if (isset($data['status'])) {
                $feedbackData['status'] = $data['status'];
            }


            if (isset($data['evidences_files'])) {
                $feedbackData['evidences_files'] = $data['evidences_files'];
            }
            
            $feedback = $this->feedback->create($feedbackData);
    
            if ($feedback) {
                
            }

        } catch (\Throwable $err) {
            Log::error('Erro ao cadastrar Feedback', [
                'message' => $err->getMessage(),
                'trace' => $err->getTraceAsString(),
            ]);
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