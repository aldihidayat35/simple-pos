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
        Schema::create('product_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('uom_name'); // Nama kemasan bertingkat: Karung 50Kg, Dus 24Pcs, Pack 5Kg
            $table->decimal('conversion_factor', 10, 2); // Pengali ke base_uom (cth: 50.00 untuk 1 Karung = 50 Kg)
            $table->decimal('selling_price', 14, 2)->nullable(); // Harga grosir per kemasan bertingkat
            $table->string('barcode')->nullable(); // Barcode khusus kemasan dus / karung
            $table->boolean('is_default_purchase')->default(false); // Satuan standar saat membuat PO Suplayer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_units');
    }
};
