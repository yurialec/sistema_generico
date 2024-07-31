<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CadastrarUsuarioRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $usuario;
    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function list(Request $request)
    {
        $query = $this->usuario->query();

        if ($request->has('search')) {
            $searchTerm = $request->query('search');
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%');
        }

        $usuarios = $query->paginate(15);
        return response()->json($usuarios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CadastrarUsuarioRequest $request): JsonResponse
    {
        $usuario = $this->usuario->create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => (int)$request->role_id,
            'password' => bcrypt('123456'),
        ]);

        if ($usuario) {
            return response()->json($usuario, 201);
        } else {
            return response()->json(['Erro ao incluir registro', 204]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $this->usuario->where('id', $id)->first();
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;

            if ($request->password) {
                $user->password = $request->password;
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Registro não encontrado'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function profileView()
    {
        return view('admin.users.profile');
    }

    public function profile(): JsonResponse
    {
        $profile = Auth::user();

        return response()->json([
            'status' => true,
            'profile' => $profile,
        ], 201);
    }
}
