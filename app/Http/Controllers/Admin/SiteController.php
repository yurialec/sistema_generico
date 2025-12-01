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

    public function list()
    {
        $items = $this->siteService->getAll();

        if ($items) {
            return response()->json(['status' => true, 'items' => $items], 200);
        }
        return response()->json(['message' => 'Nenhum registro encontrado.', 'status' => 500]);
    }

    public function edit()
    {
        return view('admin.site.edit');
    }

    public function save(Request $request)
    {
        $item = $this->siteService->save($request->all());

        if ($item) {
            return response()->json([
                'status' => true,
                'item' => $item
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Erro ao atualizar registro'
        ], 500);
    }
}