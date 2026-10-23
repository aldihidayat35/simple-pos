<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $demoUsers = User::all();
        return view('auth.login', compact('demoUsers'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt login by username or email
        $user = User::where('username', $credentials['username'])
            ->orWhere('email', $credentials['username'])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            if (!$user->is_active) {
                return back()->withErrors(['username' => 'Akun dinonaktifkan oleh Super Admin.']);
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            AuditLogger::logLogin($user);

            return redirect()->intended(route('dashboard'))
                ->with('success', "Selamat datang kembali, {$user->name} ({$user->getRoleLabel()})!");
        }

        return back()->withErrors([
            'username' => 'Username atau kata sandi tidak cocok dengan data kami.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            AuditLogger::logLogout($user);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sesi.');
    }

    /**
     * Instant Role Switcher for seamless testing and operational handover.
     */
    public function switchRole(Request $request)
    {
        $request->validate([
            'role' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $currentUser = Auth::user();

        if ($request->filled('user_id')) {
            $targetUser = User::findOrFail($request->user_id);
        } elseif ($request->filled('role')) {
            $targetUser = User::where('role', $request->role)->first();
        } else {
            return back()->with('error', 'Parameter role atau user_id tidak valid.');
        }

        if (!$targetUser) {
            return back()->with('error', 'Akun untuk role tersebut tidak ditemukan.');
        }

        if ($currentUser) {
            AuditLogger::logSwitchRole($currentUser, $targetUser);
        }

        Auth::login($targetUser);
        $request->session()->regenerate();

        if ($request->expectsJson() || $request->isXmlHttpRequest()) {
            return response()->json([
                'success' => true,
                'message' => "Beralih peran ke {$targetUser->getRoleLabel()} ({$targetUser->name})",
                'user' => [
                    'id' => $targetUser->id,
                    'name' => $targetUser->name,
                    'username' => $targetUser->username,
                    'role' => $targetUser->role,
                    'role_label' => $targetUser->getRoleLabel(),
                    'can_view_hpp' => $targetUser->canViewHpp(),
                    'can_view_profit' => $targetUser->canViewProfit(),
                    'is_readonly' => $targetUser->isReadOnly(),
                ],
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', "Beralih peran aktif ke {$targetUser->getRoleLabel()} ({$targetUser->name})!");
    }
}
