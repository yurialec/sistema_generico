<?php

namespace App\Services\Admin;

use App\Repositories\Admin\FeedbackRepository;

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

    public function create($data)
    {
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