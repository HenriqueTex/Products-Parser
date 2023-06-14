<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $productsPerPage = 30;

        $products = Product::paginate($productsPerPage);

        return response()->json($products);
    }

    public function show($code)
    {
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function update(ProductUpdateRequest $request, $code)
    {

        $product = Product::where('code', $code)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $properties = $request->validated();

        $properties['last_modified_t'] = now()->toISOString();

        $product->fill($properties);

        $product->save();

        return response()->json(['message' => 'Product successful updated']);
    }

    public function delete($code)
    {
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->status = ProductStatus::Trash;

        $product->save();

        return response()->json(['message' => 'Product stats changed to trash']);
    }
}
