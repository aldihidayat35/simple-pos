<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request checking allowed roles.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (empty($roles) || in_array($user->role, $roles, true)) {
            return $next($request);
        }

        if ($request->expectsJson() || $request->isXmlHttpRequest()) {
            return response()->json([
                'success' => false,
                'message' => 'Akses Terlarang: Anda tidak memiliki izin untuk mengakses modul ini.',
            ], 403);
        }

        return redirect()->route('dashboard')->with('error', 'Akses Terlarang: Role Anda tidak memiliki izin modul ini.');
    }
}
