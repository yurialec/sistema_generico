<?php

namespace App\Services\Admin;

use App\Enums\FeedbackStatus;
use App\Repositories\Admin\FeedbackRepository;
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

    public function create($data)
    {
        $data['user_id'] = Auth::id();
        if (empty($data['status'])) {
            $data['status'] = FeedbackStatus::OPEN->value;
        }

        if (!empty($data['image'])) {
            $image = $data['image'];
            $image_urn = $image->store('admin/feedback/images', 'public');

            $data['image'] = $image_urn;
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