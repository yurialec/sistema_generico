<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class AclMiddleware
{
    protected $except = [
        'users.index',
        'users.create',
        'users.update',
        'roles.index',
        'roles.create',
        'roles.update',
        'permissions.index',
        'permissions.create',
        'permissions.update',
        'profile',
        'profile.view',
        'modules.list',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $routeName = Route::currentRouteName();

        if (in_array($routeName, $this->except)) {
            return $next($request);
        }

        $permissions = $request->user()->role->permissions->pluck('name')->toArray();

        if (!in_array($routeName, $permissions) and $request->user()->role->name != 'Desenvolvedor') {
            return redirect(route('home'))->withErrors(['message' => 'Você não tem permissão para acessar essa funcionalidade']);
        }

        return $next($request);
    }
}
