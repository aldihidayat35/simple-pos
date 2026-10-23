<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // The 8 PRD Roles
    public const ROLE_SUPER_ADMIN   = 'SUPER_ADMIN';
    public const ROLE_OWNER         = 'OWNER';
    public const ROLE_KEPALA_TOKO   = 'KEPALA_TOKO';
    public const ROLE_KEPALA_GUDANG = 'KEPALA_GUDANG';
    public const ROLE_STAF_GUDANG   = 'STAF_GUDANG';
    public const ROLE_STAF_TOKO     = 'STAF_TOKO';
    public const ROLE_SALES         = 'SALES';
    public const ROLE_B2B           = 'B2B';

    public const ALL_ROLES = [
        self::ROLE_SUPER_ADMIN   => 'Super Admin',
        self::ROLE_OWNER         => 'Owner',
        self::ROLE_KEPALA_TOKO   => 'Kepala Toko',
        self::ROLE_KEPALA_GUDANG => 'Kepala Gudang',
        self::ROLE_STAF_GUDANG   => 'Staf Gudang',
        self::ROLE_STAF_TOKO     => 'Staf Toko',
        self::ROLE_SALES         => 'Sales',
        self::ROLE_B2B           => 'Mitra B2B',
    ];

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'location_id',
        'phone',
        'preferred_lang',
        'permissions_json',
        'is_active',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
            'permissions_json'  => 'array',
            'is_active'         => 'boolean',
        ];
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    // Role Checking Helpers
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isOwner(): bool
    {
        return $this->role === self::ROLE_OWNER;
    }

    public function isKepalaToko(): bool
    {
        return $this->role === self::ROLE_KEPALA_TOKO;
    }

    public function isKepalaGudang(): bool
    {
        return $this->role === self::ROLE_KEPALA_GUDANG;
    }

    public function isStafGudang(): bool
    {
        return $this->role === self::ROLE_STAF_GUDANG;
    }

    public function isStafToko(): bool
    {
        return $this->role === self::ROLE_STAF_TOKO;
    }

    public function isSales(): bool
    {
        return $this->role === self::ROLE_SALES;
    }

    public function isB2B(): bool
    {
        return $this->role === self::ROLE_B2B;
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }
        return $this->role === $roles;
    }

    /**
     * PRD: Owner has full Read-Only access across the system.
     */
    public function isReadOnly(): bool
    {
        return $this->isOwner();
    }

    /**
     * PRD: Hide HPP from Staf Gudang, Staf Toko, Sales, and B2B.
     */
    public function canViewHpp(): bool
    {
        return in_array($this->role, [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_OWNER,
            self::ROLE_KEPALA_TOKO,
            self::ROLE_KEPALA_GUDANG,
        ], true);
    }

    /**
     * PRD: Hide HPP & Gross profit from Staf Gudang, Staf Toko, Sales, and B2B.
     */
    public function canViewProfit(): bool
    {
        return in_array($this->role, [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_OWNER,
            self::ROLE_KEPALA_TOKO,
            self::ROLE_KEPALA_GUDANG,
        ], true);
    }

    public function getRoleLabel(): string
    {
        return self::ALL_ROLES[$this->role] ?? $this->role;
    }

    public function getRoleBadgeClass(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN   => 'bg-sidebar text-white',
            self::ROLE_OWNER         => 'bg-movePurple text-white',
            self::ROLE_KEPALA_TOKO   => 'bg-brandOrange text-white',
            self::ROLE_KEPALA_GUDANG => 'bg-brandCyan text-sidebar',
            self::ROLE_STAF_GUDANG   => 'bg-[#EFF6FF] text-[#1E40AF] border border-[#BFDBFE]',
            self::ROLE_STAF_TOKO     => 'bg-[#ECFDF5] text-[#065F46] border border-[#A7F3D0]',
            self::ROLE_SALES         => 'bg-[#FFFBEB] text-[#92400E] border border-[#FDE68A]',
            self::ROLE_B2B           => 'bg-[#F5F3FF] text-[#5B21B6] border border-[#DDD6FE]',
            default                  => 'bg-panelBg text-textMain border border-[#ECEBF4]'
        };
    }
}
