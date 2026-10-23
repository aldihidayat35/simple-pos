<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\SystemSetting;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::orderBy('id', 'asc')->get();
        $settings = SystemSetting::all();
        $auditLogs = AuditLog::with('user')->latest()->take(25)->get();
        $roles = User::ALL_ROLES;

        return view('admin.users', compact('users', 'settings', 'auditLogs', 'roles'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'username'    => 'required|string|max:50|unique:users,username',
            'email'       => 'nullable|email|max:100|unique:users,email',
            'password'    => 'required|string|min:6',
            'role'        => ['required', Rule::in(array_keys(User::ALL_ROLES))],
            'location_id' => 'required|string|max:50',
            'phone'       => 'nullable|string|max:30',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        $user = User::create($validated);

        AuditLogger::log(
            action: 'CREATE_USER',
            description: "Super Admin membuat user baru [{$user->name}] dengan role [{$user->getRoleLabel()}].",
            model: $user,
            newValues: $user->only(['name', 'username', 'role', 'location_id'])
        );

        return back()->with('success', "User [{$user->name}] berhasil dibuat!");
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => ['nullable', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'role'        => ['required', Rule::in(array_keys(User::ALL_ROLES))],
            'location_id' => 'required|string|max:50',
            'phone'       => 'nullable|string|max:30',
            'is_active'   => 'required|boolean',
            'password'    => 'nullable|string|min:6',
        ]);

        $oldValues = $user->only(['name', 'role', 'location_id', 'is_active', 'phone']);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        AuditLogger::log(
            action: 'UPDATE_USER',
            description: "Super Admin memperbarui data user [{$user->name}].",
            model: $user,
            oldValues: $oldValues,
            newValues: $user->only(['name', 'role', 'location_id', 'is_active', 'phone'])
        );

        return back()->with('success', "Data user [{$user->name}] berhasil diperbarui!");
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'floor_price_margin_percent' => 'required|numeric|min:0|max:100',
            'fuzzy_matching_threshold'   => 'required|numeric|min:50|max:100',
            'default_b2b_credit_limit'   => 'required|numeric|min:0',
            'auto_block_overdue_days'    => 'required|integer|min:1|max:365',
        ]);

        $oldSettings = SystemSetting::all()->pluck('value', 'key')->toArray();

        foreach ($validated as $key => $val) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => (string)$val]
            );
        }

        AuditLogger::log(
            action: 'UPDATE_SETTINGS',
            description: 'Super Admin memperbarui parameter System Lock (Floor Price, Fuzzy Match & B2B Plafon).',
            oldValues: $oldSettings,
            newValues: $validated
        );

        return back()->with('success', 'Parameter pengunci sistem (System Locks) berhasil diperbarui!');
    }
}
