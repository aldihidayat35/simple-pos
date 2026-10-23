<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Supplier;
use App\Services\AuditLogger;
use App\Services\ProductFuzzyMatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['supplier', 'units'])->orderBy('name', 'asc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(20);
        $suppliers = Supplier::where('is_active', true)->orderBy('name')->get();
        $categories = [
            'Beras & Palawija',
            'Minyak & Bumbu',
            'Telur & Unggas',
            'Daging & Ikan',
            'Sayur & Buah Segar',
            'Gula, Kopi & Teh',
            'Susu & Olahan',
            'Bahan Kue & Roti',
            'Kemasan & Plastik',
        ];

        if ($request->wantsJson() || $request->isXmlHttpRequest()) {
            return response()->json([
                'success' => true,
                'products' => $products,
            ]);
        }

        return view('products.index', compact('products', 'suppliers', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:150',
            'sku'                 => 'nullable|string|max:50|unique:products,sku',
            'barcode'             => 'nullable|string|max:50|unique:products,barcode',
            'category'            => 'required|string|max:100',
            'base_uom'            => 'required|string|max:30',
            'current_hpp'         => 'required|numeric|min:0',
            'floor_price_margin'  => 'nullable|numeric|min:0|max:100',
            'min_market_price'    => 'required|numeric|min:0',
            'max_market_price'    => 'required|numeric|min:0',
            'stock_gudang'        => 'nullable|numeric|min:0',
            'stock_toko'          => 'nullable|numeric|min:0',
            'min_stock_alert'     => 'nullable|numeric|min:0',
            'supplier_id'         => 'nullable|exists:suppliers,id',
            'description'         => 'nullable|string|max:500',
            // Tiered units validation
            'units'               => 'nullable|array',
            'units.*.uom_name'    => 'required_with:units|string|max:50',
            'units.*.conversion_factor' => 'required_with:units|numeric|min:1',
            'units.*.selling_price' => 'nullable|numeric|min:0',
            'units.*.barcode'     => 'nullable|string|max:50',
        ]);

        if (empty($validated['sku'])) {
            $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $validated['category']), 0, 3)) ?: 'PRD';
            $validated['sku'] = $prefix . '-' . strtoupper(Str::random(5));
        }

        $validated['floor_price_margin'] = $validated['floor_price_margin'] ?? 10.0;
        $validated['stock_gudang'] = $validated['stock_gudang'] ?? 0;
        $validated['stock_toko'] = $validated['stock_toko'] ?? 0;
        $validated['min_stock_alert'] = $validated['min_stock_alert'] ?? 10;
        $validated['is_active'] = true;

        $productData = collect($validated)->except('units')->toArray();
        $product = Product::create($productData);

        // Simpan satuan bertingkat (Multi-UOM) jika ada
        if (!empty($validated['units'])) {
            $unitIndex = 1;
            foreach ($validated['units'] as $unitData) {
                if (!empty($unitData['uom_name']) && !empty($unitData['conversion_factor'])) {
                    $slugName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $unitData['uom_name'])) ?: ('U' . $unitIndex);
                    $unitBarcode = !empty($unitData['barcode']) ? $unitData['barcode'] : ($product->sku . '-' . $slugName);

                    $product->units()->create([
                        'uom_name'          => $unitData['uom_name'],
                        'conversion_factor' => $unitData['conversion_factor'],
                        'selling_price'     => $unitData['selling_price'] ?? null,
                        'barcode'           => $unitBarcode,
                    ]);
                    $unitIndex++;
                }
            }
        }

        AuditLogger::log(
            action: 'CREATE_PRODUCT',
            description: "Membuat Master Produk baru [{$product->name}] ({$product->sku}) dengan satuan dasar [{$product->base_uom}].",
            model: $product,
            newValues: $product->load('units')->toArray()
        );

        if ($request->wantsJson() || $request->isXmlHttpRequest()) {
            return response()->json([
                'success' => true,
                'message' => "Produk [{$product->name}] berhasil ditambahkan!",
                'product' => $product->load('units', 'supplier'),
            ]);
        }

        return back()->with('success', "Produk [{$product->name}] ({$product->sku}) berhasil ditambahkan!");
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:150',
            'sku'                 => ['required', 'string', 'max:50', Rule::unique('products')->ignore($product->id)],
            'barcode'             => ['nullable', 'string', 'max:50', Rule::unique('products')->ignore($product->id)],
            'category'            => 'required|string|max:100',
            'base_uom'            => 'required|string|max:30',
            'current_hpp'         => 'required|numeric|min:0',
            'floor_price_margin'  => 'nullable|numeric|min:0|max:100',
            'min_market_price'    => 'required|numeric|min:0',
            'max_market_price'    => 'required|numeric|min:0',
            'stock_gudang'        => 'nullable|numeric|min:0',
            'stock_toko'          => 'nullable|numeric|min:0',
            'min_stock_alert'     => 'nullable|numeric|min:0',
            'supplier_id'         => 'nullable|exists:suppliers,id',
            'description'         => 'nullable|string|max:500',
            'is_active'           => 'required|boolean',
            'units'               => 'nullable|array',
            'units.*.uom_name'    => 'required_with:units|string|max:50',
            'units.*.conversion_factor' => 'required_with:units|numeric|min:1',
            'units.*.selling_price' => 'nullable|numeric|min:0',
            'units.*.barcode'     => 'nullable|string|max:50',
        ]);

        $oldValues = $product->load('units')->toArray();

        $productData = collect($validated)->except('units')->toArray();
        $product->update($productData);

        // Sync satuan bertingkat (Multi-UOM)
        if (isset($validated['units'])) {
            $product->units()->delete();
            $unitIndex = 1;
            foreach ($validated['units'] as $unitData) {
                if (!empty($unitData['uom_name']) && !empty($unitData['conversion_factor'])) {
                    $slugName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $unitData['uom_name'])) ?: ('U' . $unitIndex);
                    $unitBarcode = !empty($unitData['barcode']) ? $unitData['barcode'] : ($product->sku . '-' . $slugName);

                    $product->units()->create([
                        'uom_name'          => $unitData['uom_name'],
                        'conversion_factor' => $unitData['conversion_factor'],
                        'selling_price'     => $unitData['selling_price'] ?? null,
                        'barcode'           => $unitBarcode,
                    ]);
                    $unitIndex++;
                }
            }
        }

        AuditLogger::log(
            action: 'UPDATE_PRODUCT',
            description: "Memperbarui Master Produk [{$product->name}] ({$product->sku}).",
            model: $product,
            oldValues: $oldValues,
            newValues: $product->load('units')->toArray()
        );

        if ($request->wantsJson() || $request->isXmlHttpRequest()) {
            return response()->json([
                'success' => true,
                'message' => "Produk [{$product->name}] berhasil diperbarui!",
                'product' => $product->load('units', 'supplier'),
            ]);
        }

        return back()->with('success', "Produk [{$product->name}] berhasil diperbarui!");
    }

    public function destroy(Product $product)
    {
        $productName = $product->name;
        $productSku = $product->sku;

        // Toggle status nonaktif alih-alih hard delete agar riwayat audit trail tetap utuh
        $product->update(['is_active' => false]);

        AuditLogger::log(
            action: 'DEACTIVATE_PRODUCT',
            description: "Menonaktifkan Master Produk [{$productName}] ({$productSku}).",
            model: $product
        );

        return back()->with('success', "Produk [{$productName}] berhasil dinonaktifkan!");
    }

    /**
     * Endpoint API real-time untuk memeriksa kemiripan nama produk (Fuzzy Matching).
     */
    public function checkSimilarity(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'exclude_id' => 'nullable|integer',
        ]);

        $result = ProductFuzzyMatcher::checkSimilarity($request->name, $request->exclude_id);

        return response()->json($result);
    }
}
