<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $totalSkuGudang = Product::where('stock_gudang', '>', 0)->count();
        $suppliersCount = Supplier::where('is_active', true)->count();
        $recentProducts = Product::with(['supplier', 'units'])->latest()->take(10)->get();

        return view('warehouse.index', compact('totalSkuGudang', 'suppliersCount', 'recentProducts'));
    }
}
