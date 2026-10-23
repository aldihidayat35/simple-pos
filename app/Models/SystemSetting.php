<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
        'description',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function getVal(string $key, mixed $default = null): mixed
    {
        return static::get($key, $default);
    }

    public static function set(string $key, mixed $value, ?string $group = 'general', ?string $label = null, ?string $description = null): static
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group ?? 'general',
                'label' => $label,
                'description' => $description,
            ]
        );
    }
}
