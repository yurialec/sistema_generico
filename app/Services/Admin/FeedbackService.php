<?php

namespace App\Services\Admin;

use App\Enums\FeedbackStatus;
use App\Repositories\Admin\FeedbackRepository;
use Arr;
use Auth;
use Log;
use Storage;

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
        try {
            $data['user_id'] = Auth::id();
            $data['status'] = FeedbackStatus::OPEN->value;

            $storedEvidenceFiles = [];

            if (!empty($data['evidences_files']) && is_iterable($data['evidences_files'])) {
                foreach ($data['evidences_files'] as $file) {
                    $storedEvidenceFiles[] = [
                        'path' => $file->store('admin/feedback/evidences', 'public'),
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'type' => $this->getFileType($file),
                    ];
                }
            }

            return $this->feedbackRepository->create($data, $storedEvidenceFiles);
        } catch (\Throwable $err) {
            Log::error('Erro ao cadastrar Feedback', [
                'message' => $err->getMessage(),
                'trace' => $err->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * Determina o tipo de arquivo com base na extensão/mime type.
     */
    private function getFileType($file)
    {
        $mime = $file->getMimeType();

        if (str_contains($mime, 'image')) {
            return 'image';
        } elseif (str_contains($mime, 'pdf')) {
            return 'pdf';
        } else {
            return 'text';
        }
    }

    public function update($id, array $data)
    {
        try {
            $storedEvidenceFiles = [];

            if (!empty($data['evidences_files']) && is_iterable($data['evidences_files'])) {
                foreach ($data['evidences_files'] as $file) {
                    $storedEvidenceFiles[] = [
                        'path' => $file->store('admin/feedback/evidences', 'public'),
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'type' => $this->getFileType($file),
                    ];
                }
            }

            $storedEvidenceTexts = [];
            if (!empty($data['evidences_text']) && is_array($data['evidences_text'])) {
                foreach ($data['evidences_text'] as $text) {
                    $storedEvidenceTexts[] = [
                        'text' => trim($text),
                        'type' => 'text',
                    ];
                }
            }

            $updateData = Arr::except($data, ['evidences_files', 'evidences_text']);

            return $this->feedbackRepository->update($id, $updateData, $storedEvidenceFiles, $storedEvidenceTexts);
        } catch (\Throwable $err) {
            Log::error('Erro ao atualizar Feedback', [
                'message' => $err->getMessage(),
                'trace' => $err->getTraceAsString(),
                'feedback_id' => $id,
            ]);

            return false;
        }
    }
    public function delete($id)
    {
        return $this->feedbackRepository->delete($id);
    }

    public function updateStatus($feedback)
    {
        return $this->feedbackRepository->updateStatus($feedback);
    }

    public function downloadEvidence($id)
    {
        try {
            $evidence = $this->feedbackRepository->downloadEvidence($id);

            if (!$evidence) {
                abort(404, 'Evidência não encontrada.');
            }

            if (!Storage::disk('public')->exists($evidence->path)) {
                abort(404, 'Arquivo não encontrado.');
            }

            $filename = $evidence->original_name ?? basename($evidence->path);
            return Storage::disk('public')->download($evidence->path, $filename);
        } catch (\Throwable $err) {
            Log::error('Erro ao baixar evidência', [
                'message' => $err->getMessage(),
                'trace' => $err->getTraceAsString(),
                'evidence_id' => $id,
            ]);
            abort(500, 'Erro interno ao tentar baixar o arquivo.');
        }
    }
}