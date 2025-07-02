<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AclMiddleware
{
    public function handle(Request $request, Closure $next, $permission = null)
    {
        $user = Auth::user();
        if ($user->role->name === 'Desenvolvedor') {
            return $next($request);
        }

        $userPermissions = Auth::user()->role->permissions->toArray();
        foreach ($userPermissions as $up) {
            if (in_array($permission, $up)) {
                return $next($request);
            }
        }

        return redirect()
            ->route('home')
            ->withErrors([
                'message' => 'Você não tem permissão para acessar essa funcionalidade.'
            ]);
    }
}
