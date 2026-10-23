<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHppAccess
{
    /**
     * PRD: Sembunyikan seluruh informasi HPP dan Laba dari role Staf Gudang, Staf Toko, Sales, dan B2B.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->canViewHpp()) {
            if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses Terbatas: Role Anda tidak memiliki izin untuk melihat informasi HPP dan Laba.',
                ], 403);
            }

            return redirect()->route('dashboard')->with('error', 'Akses Terbatas: Role Anda tidak memiliki izin melihat HPP dan Laba.');
        }

        return $next($request);
    }
}
