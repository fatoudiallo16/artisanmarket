<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        $allowed = collect($roles)
            ->flatMap(fn (string $role) => str_contains($role, ',') ? explode(',', $role) : [$role])
            ->map(fn (string $role) => trim($role))
            ->filter()
            ->all();

        if (!$user || !$user->role || !in_array($user->role->nom_role, $allowed, true)) {
            abort(403, 'Accès refusé. Connectez-vous avec un compte vendeur ou administrateur.');
        }

        return $next($request);
    }
}
