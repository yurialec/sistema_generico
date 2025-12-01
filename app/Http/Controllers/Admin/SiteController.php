<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SiteService;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $siteService;

    public function __construct(SiteService $siteService)
    {
        $this->siteService = $siteService;
    }

    public function index()
    {
        return view('admin.site.index');
    }

    public function list(Request $request)
    {
        $items = $this->siteService->getAll($request->input('search'));

        if ($items) {
            return response()->json(['status' => true, 'items' => $items], 200);
        }
        return response()->json(['message' => 'Nenhum registro encontrado.', 'status' => 500]);
    }

    public function create()
    {
        return view('admin.site.create');
    }

    public function store(Request $request)
    {
        $item = $this->siteService->create($request->all());

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao cadastrar registro'], 500);
    }

    public function edit($id)
    {
        return view('admin.site.edit', compact('id'));
    }

    public function find($id)
    {
        $item = $this->siteService->find($id);

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Registro não encontrado'], 500);
    }

    public function update(Request $request, string $id)
    {
        $item = $this->siteService->update($id, $request->all());

        if ($item) {
            return response()->json(['status' => true, 'item' => $item], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao atualizar registro'], 500);
    }

    public function delete(string $id)
    {
        $deleted = $this->siteService->delete($id);

        if ($deleted) {
            return response()->json(['status' => true, 'message' => 'Registro excluído com sucesso'], 200);
        }
        return response()->json(['status' => false, 'message' => 'Erro ao excluir registro'], 500);
    }
}