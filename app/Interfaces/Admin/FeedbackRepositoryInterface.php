<?php

namespace App\Interfaces\Admin;

interface FeedbackRepositoryInterface
{
    public function all($term);
    public function find($id);
    public function downloadEvidence($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    public function updateStatus(object $feedback);
}