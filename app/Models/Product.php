<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'barcode',
        'name',
        'normalized_name',
        'category',
        'base_uom',
        'current_hpp',
        'floor_price_margin',
        'min_market_price',
        'max_market_price',
        'stock_gudang',
        'stock_toko',
        'min_stock_alert',
        'supplier_id',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'current_hpp' => 'float',
            'floor_price_margin' => 'float',
            'min_market_price' => 'float',
            'max_market_price' => 'float',
            'stock_gudang' => 'float',
            'stock_toko' => 'float',
            'min_stock_alert' => 'float',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            $product->normalized_name = static::normalizeName($product->name);
        });
    }

    public static function normalizeName(string $name): string
    {
        // Lowercase, remove symbols/punctuation, normalize multiple spaces
        $clean = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', mb_strtolower($name));
        return trim(preg_replace('/\s+/', ' ', $clean));
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(ProductUnit::class)->orderBy('conversion_factor', 'desc');
    }

    /**
     * Hitung Floor Price mutlak sistem = HPP + Floor Margin %.
     */
    public function getFloorPrice(): float
    {
        return round($this->current_hpp * (1 + ($this->floor_price_margin / 100)), 2);
    }

    public function getTotalStock(): float
    {
        return $this->stock_gudang + $this->stock_toko;
    }

    public function isLowStock(): bool
    {
        return $this->getTotalStock() <= $this->min_stock_alert;
    }

    /**
     * Format tampilan stok bertingkat (contoh: 125 Kg -> 2 Karung 50Kg + 25 Kg).
     */
    public function getFormattedStock(float $qty): string
    {
        $primaryUnit = $this->units->first();
        if (!$primaryUnit || $primaryUnit->conversion_factor <= 1 || $qty < $primaryUnit->conversion_factor) {
            return number_format($qty, 0, ',', '.') . ' ' . $this->base_uom;
        }

        $largeUnitCount = floor($qty / $primaryUnit->conversion_factor);
        $remainder = $qty - ($largeUnitCount * $primaryUnit->conversion_factor);

        $text = "{$largeUnitCount} {$primaryUnit->uom_name}";
        if ($remainder > 0) {
            $text .= " + " . number_format($remainder, 0, ',', '.') . " {$this->base_uom}";
        }

        return "{$text} (" . number_format($qty, 0, ',', '.') . " {$this->base_uom})";
    }
}
