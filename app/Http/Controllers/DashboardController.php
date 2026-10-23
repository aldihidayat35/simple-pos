<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-authenticate as default OWNER if guest for zero-friction demo
        if (!Auth::check()) {
            $defaultUser = User::where('role', User::ROLE_OWNER)->first()
                ?? User::first();
            if ($defaultUser) {
                Auth::login($defaultUser);
            }
        }

        $activeUser = Auth::user();
        $allRoles = User::ALL_ROLES;
        $demoUsers = User::where('is_active', true)->get();
        $systemSettings = SystemSetting::all()->keyBy('key');
        $recentAuditLogs = AuditLog::with('user')->latest()->take(10)->get();

        $canViewHpp = $activeUser?->canViewHpp() ?? false;
        $canViewProfit = $activeUser?->canViewProfit() ?? false;
        $isReadOnly = $activeUser?->isReadOnly() ?? false;

        return view('dashboard.index', compact(
            'activeUser',
            'allRoles',
            'demoUsers',
            'systemSettings',
            'recentAuditLogs',
            'canViewHpp',
            'canViewProfit',
            'isReadOnly'
        ));
    }
}
