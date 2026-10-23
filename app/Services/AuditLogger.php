<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Log a general audit event permanently binding user_id, role, action, and snapshot.
     */
    public static function log(
        string $action,
        ?string $description = null,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $dataSnapshot = null,
        ?User $user = null
    ): AuditLog {
        $actor = $user ?? Auth::user();

        return AuditLog::create([
            'user_id'       => $actor?->id,
            'username'      => $actor?->username ?? $actor?->name ?? 'System',
            'role'          => $actor?->role ?? 'SYSTEM',
            'action'        => strtoupper($action),
            'description'   => $description,
            'model_type'    => $model ? get_class($model) : null,
            'model_id'      => $model?->getKey(),
            'old_values'    => $oldValues,
            'new_values'    => $newValues,
            'data_snapshot' => $dataSnapshot ?? ($model ? $model->toArray() : null),
            'ip_address'    => Request::ip() ?? '127.0.0.1',
            'user_agent'    => Request::userAgent() ?? 'Web Terminal',
        ]);
    }

    public static function logLogin(User $user): AuditLog
    {
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => Request::ip() ?? '127.0.0.1',
        ]);

        return self::log(
            action: 'LOGIN',
            description: "User [{$user->name}] berhasil masuk ke sistem dengan role [{$user->getRoleLabel()}].",
            user: $user
        );
    }

    public static function logLogout(User $user): AuditLog
    {
        return self::log(
            action: 'LOGOUT',
            description: "User [{$user->name}] mengakhiri sesi operasional.",
            user: $user
        );
    }

    public static function logSwitchRole(User $fromUser, User $toUser): AuditLog
    {
        return self::log(
            action: 'SWITCH_ROLE',
            description: "Simulasi beralih peran dari [{$fromUser->getRoleLabel()}] ke [{$toUser->getRoleLabel()}].",
            dataSnapshot: [
                'from_user_id' => $fromUser->id,
                'from_role'    => $fromUser->role,
                'to_user_id'   => $toUser->id,
                'to_role'      => $toUser->role,
            ],
            user: $toUser
        );
    }

    public static function logEmergencyStock(User $user, array $details): AuditLog
    {
        return self::log(
            action: 'EMERGENCY_STOCK',
            description: "Input Stok Emergency tanpa approval: {$details['product_name']} ({$details['quantity']}) senilai Rp " . number_format($details['total_cost'] ?? 0, 0, ',', '.'),
            dataSnapshot: $details,
            user: $user
        );
    }

    public static function logOpnameFinalized(User $user, array $details): AuditLog
    {
        return self::log(
            action: 'OPNAME_FINALIZED',
            description: "Finalisasi Stok Opname {$details['location']}: Selisih Total Rp " . number_format($details['total_loss_value'] ?? 0, 0, ',', '.'),
            dataSnapshot: $details,
            user: $user
        );
    }

    public static function logSystemLock(User $user, string $lockType, array $parameters): AuditLog
    {
        return self::log(
            action: 'PRICE_LOCK_TRIGGER',
            description: "Penguncian Sistem Otomatis dipicu: [{$lockType}]",
            dataSnapshot: $parameters,
            user: $user
        );
    }
}
