<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Contact\CreateContactRequest;
use App\Services\Site\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.site.contact.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.site.contact.create');
    }

    public function list()
    {
        $contact = $this->contactService->getAll();

        if ($contact) {
            return response()->json([
                'status' => true,
                'contact' => $contact
            ], 200);
        } else {
            return response()->json([
                'message' => 'Nenhum registro encontrado.',
                'status' => 500
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateContactRequest $request)
    {
        $contact = $this->contactService->create($request->all());

        if ($contact) {
            return response()->json([
                'status' => true,
                'contact' => $contact,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar conteúdo de contato'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.site.contact.edit', compact('id'));
    }

    public function find($id)
    {
        $contact = $this->contactService->find($id);
        
        if ($contact) {
            return response()->json([
                'status' => true,
                'contact' => $contact,
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
        $contact = $this->contactService->update($id, $request->all());

        if ($contact) {
            return response()->json([
                'status' => true,
                'contact' => $contact,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar conteudo do contato'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $contact = $this->contactService->delete($id);

        if ($contact) {
            return response()->json([
                'status' => true,
                'message' => 'Conteúdo excluido com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir conteúdo'
            ], 500);
        }
    }
}
