<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Logo\StoreLogoRequest;
use App\Services\Site\LogoService;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    protected $logoService;
    public function __construct(LogoService $logoService)
    {
        $this->logoService = $logoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.site.logo.index');
    }

    public function getLogo()
    {
        $logo = $this->logoService->getLogo();

        if ($logo) {
            return response()->json([
                'status' => true,
                'logo' => $logo
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
        return view('admin.site.logo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLogoRequest $request)
    {
        $logo = $this->logoService->createLogo($request->all());

        if ($logo) {
            return response()->json([
                'status' => true,
                'logo' => $logo,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar Logotipo'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.site.logo.edit', compact('id'));
    }

    public function find($id)
    {
        $logo = $this->logoService->find($id);

        if ($logo) {
            return response()->json([
                'status' => true,
                'logo' => $logo,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar Logotipo'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $logo = $this->logoService->updateLogo($id, $request->all());

        if ($logo) {
            return response()->json([
                'status' => true,
                'logo' => $logo,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar logotipo'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $logo = $this->logoService->deleteLogo($id);

        if ($logo) {
            return response()->json([
                'status' => true,
                'message' => 'Logotipo excluido com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir logotipo'
            ], 500);
        }
    }
}
