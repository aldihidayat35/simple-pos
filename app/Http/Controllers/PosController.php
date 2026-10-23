<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $productsInStore = Product::where('stock_toko', '>', 0)->with('units')->get();

        return view('pos.index', compact('productsInStore'));
    }
}
