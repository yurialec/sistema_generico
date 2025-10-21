<?php

namespace App\Repositories\Admin;

use App\Enums\FeedbackStatus;
use App\Interfaces\Admin\FeedbackRepositoryInterface;
use App\Models\Admin\Feedback;
use App\Models\Admin\FeedbackEvidence;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
            return $this->feedback
                ->with('user')
                ->when($term, fn($q) => $q->where('title', 'like', '%' . $term . '%'))
                ->paginate(10);
        } catch (Exception $err) {
            Log::error('Erro ao listar registros Feedback', [$err->getMessage()]);
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->feedback->with(['evidences', 'user'])->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar registro Feedback', [$err->getMessage()]);
            return false;
        }
    }

    public function create(array $feedbackData, array $evidences = [])
    {
        DB::beginTransaction();

        try {
            $feedback = $this->feedback->create([
                'title' => $feedbackData['title'],
                'description' => $feedbackData['description'],
                'user_id' => $feedbackData['user_id'],
                'status' => $feedbackData['status'],
            ]);

            if (!empty($evidences)) {
                foreach ($evidences as $evidence) {
                    $this->evidences->create([
                        'feedback_id' => $feedback->id,
                        'user_id' => $feedbackData['user_id'],
                        'path' => $evidence['path'],
                        'original_name' => $evidence['original_name'],
                        'size' => $evidence['size'],
                        'type' => $evidence['type'],
                    ]);
                }
            }

            DB::commit();

            return $feedback;
        } catch (\Throwable $err) {
            DB::rollBack();
            Log::error('Erro ao criar feedback e evidências', [
                'message' => $err->getMessage(),
                'trace' => $err->getTraceAsString(),
            ]);
            throw $err;
        }
    }

    public function update($id, array $data, array $storedEvidenceFiles = [], array $storedEvidenceTexts = [])
    {
        DB::beginTransaction();

        try {
            $feedback = $this->find($id);
            if (!$feedback) {
                throw new Exception("Feedback #{$id} não encontrado");
            }

            $feedback->fill($data);
            $feedback->save();

            $userId = Auth::id();

            if (!empty($storedEvidenceFiles)) {
                foreach ($storedEvidenceFiles as $fileData) {
                    $this->evidences->create([
                        'feedback_id' => $feedback->id,
                        'user_id' => $userId,
                        'path' => $fileData['path'],
                        'original_name' => $fileData['original_name'] ?? null,
                        'size' => $fileData['size'] ?? null,
                        'type' => $fileData['type'] ?? 'file',
                    ]);
                }
            }

            if (!empty($storedEvidenceTexts)) {
                foreach ($storedEvidenceTexts as $textData) {
                    $this->evidences->create([
                        'feedback_id' => $feedback->id,
                        'user_id' => $userId,
                        'text' => $textData['text'],
                        'type' => $textData['type'] ?? 'text',
                    ]);
                }
            }

            DB::commit();

            return $feedback->load('evidences');
        } catch (\Throwable $err) {
            DB::rollBack();
            Log::error('Erro ao atualizar feedback e evidências', [
                'message' => $err->getMessage(),
                'trace' => $err->getTraceAsString(),
                'feedback_id' => $id,
            ]);
            throw $err;
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

    public function updateStatus($feedback)
    {
        try {
            if ($feedback->status->value == FeedbackStatus::OPEN->value) {
                $feedback->status = FeedbackStatus::DONE->value;
                $feedback->save();
            }

            return $feedback;
        } catch (Exception $err) {
            Log::error('Erro ao atualizar status Feedback', [$err->getMessage()]);
            return false;
        }
    }

    public function downloadEvidence($id)
    {
        try {
            return $this->evidences->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao atualizar status Feedback', [$err->getMessage()]);
            return false;
        }
    }
}
