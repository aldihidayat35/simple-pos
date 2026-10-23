<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'role',
        'action',
        'description',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'data_snapshot',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'data_snapshot' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActionBadgeClass(): string
    {
        return match (strtoupper($this->action ?? '')) {
            'LOGIN'           => 'bg-emerald-100 text-emerald-800',
            'LOGOUT'          => 'bg-slate-100 text-slate-700',
            'SWITCH_ROLE'     => 'bg-amber-100 text-amber-800',
            'CREATE_USER'     => 'bg-blue-100 text-blue-800',
            'UPDATE_USER'     => 'bg-indigo-100 text-indigo-800',
            'UPDATE_SETTINGS' => 'bg-purple-100 text-purple-800',
            'EMERGENCY_STOCK' => 'bg-orange-100 text-orange-800',
            'OPNAME_DIFF'     => 'bg-rose-100 text-rose-800',
            default           => 'bg-gray-100 text-gray-700',
        };
    }
}
