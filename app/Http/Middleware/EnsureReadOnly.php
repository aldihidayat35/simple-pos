<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureReadOnly
{
    /**
     * PRD: Akun Owner hanya memiliki akses Read-Only untuk pemantauan.
     * Tidak boleh mengeksekusi operasi mutasi (POST, PUT, PATCH, DELETE) selain logout / switch role simulasi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isReadOnly() && !in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'])) {
            // Allow role-switch during testing/demo
            if ($request->routeIs('auth.switch-role') || $request->routeIs('logout')) {
                return $next($request);
            }

            if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses Ditolak: Akun Owner bersifat Read-Only untuk pengawasan dan tidak diperkenankan memodifikasi data operasional.',
                ], 403);
            }

            return back()->with('error', 'Akses Ditolak: Akun Owner bersifat Read-Only untuk pengawasan.');
        }

        return $next($request);
    }
}
