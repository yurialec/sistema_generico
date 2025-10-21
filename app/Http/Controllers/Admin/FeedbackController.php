<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Feedback\StoreFeedbackRequest;
use App\Http\Requests\Admin\Feedback\UpdateFeedbackRequest;
use App\Models\Admin\Feedback;
use App\Models\Admin\FeedbackEvidence;
use App\Services\Admin\FeedbackService;
use Illuminate\Http\Request;
use Log;
use Storage;

class FeedbackController extends Controller
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function index()
    {
        return view('admin.feedback.index');
    }

    public function list(Request $request)
    {
        $items = $this->feedbackService->getAll($request->input('term'));

        if ($items) {
            return response()->json([
                'status' => true,
                'items' => $items
            ], 200);
        }

        return response()->json([
            'message' => 'Nenhum registro encontrado.',
            'status' => 500
        ]);
    }

    public function create()
    {
        return view('admin.feedback.create');
    }

    public function store(StoreFeedbackRequest $request)
    {
        $item = $this->feedbackService->create($request->all());

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Erro ao cadastrar registro'
        ], 500);
    }

    public function edit($id)
    {
        return view('admin.feedback.edit', compact('id'));
    }

    public function find($id)
    {
        $item = $this->feedbackService->find($id);

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Registro não encontrado'
        ], 500);
    }

    public function update(UpdateFeedbackRequest $request, string $id)
    {
        $item = $this->feedbackService->update($id, $request->all());

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao atualizar registro'], 500);
    }

    public function delete(string $id)
    {
        $deleted = $this->feedbackService->delete($id);

        if ($deleted) {
            return response()->json(['status' => true, 'message' => 'Registro excluído com sucesso'], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao excluir registro'], 500);
    }

    public function updateStatusFeedback(Feedback $feedback)
    {
        $item = $this->feedbackService->updateStatus($feedback);

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar registro.'
            ], 500);
        }
    }

    public function downloadEvidence($id)
    {

        $item = $this->feedbackService->downloadEvidence($id);

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao baixar evidencia.'
            ], 500);
        }
    }
}