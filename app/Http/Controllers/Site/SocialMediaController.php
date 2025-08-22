<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Site\SocialMediaService;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    protected $socialMediaService;
    public function __construct(SocialMediaService $socialMediaService)
    {
        $this->socialMediaService = $socialMediaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.site.socialmedia.index');
    }

    public function list()
    {
        $socialMedia = $this->socialMediaService->getAll();

        if ($socialMedia) {
            return response()->json([
                'status' => true,
                'socialMedia' => $socialMedia
            ], 200);
        } else {
            return response()->json([
                'message' => 'Nenhum registro encontrado.',
                'status' => 500
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.site.socialmedia.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $media = $this->socialMediaService->create($request->all());

        if ($media) {
            return response()->json([
                'status' => true,
                'media' => $media,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar rede social'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.site.socialmedia.edit', compact('id'));
    }

    public function find($id)
    {
        $socialmedia = $this->socialMediaService->find($id);

        if ($socialmedia) {
            return response()->json([
                'status' => true,
                'socialmedia' => $socialmedia,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao localizar informações de contato',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $media = $this->socialMediaService->update($id, $request->all());

        if ($media) {
            return response()->json([
                'status' => true,
                'media' => $media,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar rede social'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $media = $this->socialMediaService->delete($id);

        if ($media) {
            return response()->json([
                'status' => true,
                'message' => 'Conteúdo excluído com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir conteúdo',
            ], 400);
        }
    }
}
