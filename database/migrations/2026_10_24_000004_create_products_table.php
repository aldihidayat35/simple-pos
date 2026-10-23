<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('name');
            $table->string('normalized_name')->index();
            $table->string('category')->default('Sembako');
            $table->string('base_uom')->default('Pcs'); // Satuan terkecil: Kg, Pcs, Liter, Ikat
            $table->decimal('current_hpp', 14, 2)->default(0); // HPP berjalan dinamis
            $table->decimal('floor_price_margin', 5, 2)->default(10.00); // Batas margin minimum di atas HPP
            $table->decimal('min_market_price', 14, 2)->default(0); // Harga bawah pasar (Toko)
            $table->decimal('max_market_price', 14, 2)->default(0); // Harga atas pasar (Toko)
            $table->decimal('stock_gudang', 12, 2)->default(0); // Stok gudang dalam base_uom
            $table->decimal('stock_toko', 12, 2)->default(0); // Stok toko dalam base_uom
            $table->decimal('min_stock_alert', 12, 2)->default(10); // Ambang peringatan stok menipis
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
