<?php

namespace App\Services\Admin;

use App\Enums\FeedbackStatus;
use App\Repositories\Admin\FeedbackRepository;
use Arr;
use Auth;

class FeedbackService
{
    protected $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function getAll($term)
    {
        return $this->feedbackRepository->all($term);
    }

    public function find($id)
    {
        return $this->feedbackRepository->find($id);
    }

    public function create(array $data)
    {
        // Autor do feedback
        $data['user_id'] = Auth::id();

        // Status padrão
        $data['status'] = $data['status'] ?? FeedbackStatus::OPEN->value;

        // Evidências - ARQUIVOS (múltiplos)
        if (!empty($data['evidences_files']) && is_iterable($data['evidences_files'])) {
            $storedEvidenceFiles = [];

            foreach ($data['evidences_files'] as $file) {
                if ($file instanceof UploadedFile) {
                    $storedEvidenceFiles[] = $file->store('admin/feedback/evidences', 'public');
                }
            }

            // Se houveram uploads válidos, substitui pelo array de caminhos
            if (!empty($storedEvidenceFiles)) {
                $data['evidences_files'] = $storedEvidenceFiles;
            } else {
                unset($data['evidences_files']);
            }
        } else {
            unset($data['evidences_files']);
        }

        return $this->feedbackRepository->create($data);
    }

    public function update($id, $data)
    {
        // solicitado: repassar $data sem tratamento
        return $this->feedbackRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->feedbackRepository->delete($id);
    }
}