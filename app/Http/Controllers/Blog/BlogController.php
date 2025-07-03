<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Services\Blog\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blogService;
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.blog.index');
    }

    public function list()
    {
        $blogs = $this->blogService->getAll();

        if ($blogs) {
            return response()->json([
                'status' => true,
                'blogs' => $blogs
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
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = $this->blogService->create($request->all());

        if ($blog) {
            return response()->json([
                'status' => true,
                'blog' => $blog,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar blog'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.blog.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = $this->blogService->update($id, $request->all());

        if ($blog) {
            return response()->json([
                'status' => true,
                'blog' => $blog,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar blog'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $blog = $this->blogService->delete($id);

        if ($blog) {
            return response()->json([
                'status' => true,
                'message' => 'Blog excluido com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir Blog'
            ], 500);
        }
    }
}
