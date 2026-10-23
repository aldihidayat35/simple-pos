<?php

namespace App\Traits;

use App\Services\AuditLogger;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function (Model $model) {
            AuditLogger::log(
                action: 'CREATE',
                description: "Membuat data baru pada " . class_basename($model) . " #{$model->getKey()}",
                model: $model,
                newValues: $model->getAttributes()
            );
        });

        static::updated(function (Model $model) {
            $dirty = $model->getDirty();
            $original = array_intersect_key($model->getOriginal(), $dirty);

            AuditLogger::log(
                action: 'UPDATE',
                description: "Memperbarui data pada " . class_basename($model) . " #{$model->getKey()}",
                model: $model,
                oldValues: $original,
                newValues: $dirty
            );
        });

        static::deleted(function (Model $model) {
            AuditLogger::log(
                action: 'DELETE',
                description: "Menghapus data pada " . class_basename($model) . " #{$model->getKey()}",
                model: $model,
                oldValues: $model->getOriginal()
            );
        });
    }
}
