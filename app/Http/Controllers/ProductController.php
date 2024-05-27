<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity_in_stock' => 'required|integer',
            'price_per_item' => 'required|numeric',
        ]);

        $product = Product::create([
            'product_name' => $request->product_name,
            'quantity_in_stock' => $request->quantity_in_stock,
            'price_per_item' => $request->price_per_item,
        ]);

        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity_in_stock' => 'required|integer',
            'price_per_item' => 'required|numeric',
        ]);

        $product->update([
            'product_name' => $request->product_name,
            'quantity_in_stock' => $request->quantity_in_stock,
            'price_per_item' => $request->price_per_item,
        ]);
        return response()->json($product);
    }
}
