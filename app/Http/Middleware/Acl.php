<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
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
                'message' => 'Você não tem permissão para acessar essa funcionalidade'
            ]);
    }
}
