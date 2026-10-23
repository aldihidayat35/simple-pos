<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'uom_name',
        'conversion_factor',
        'selling_price',
        'barcode',
        'is_default_purchase',
    ];

    protected function casts(): array
    {
        return [
            'conversion_factor' => 'float',
            'selling_price' => 'float',
            'is_default_purchase' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
