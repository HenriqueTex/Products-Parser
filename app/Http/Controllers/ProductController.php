<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        return response()->json($product);
    }

    public function update(Request $request, $code)
    {
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $properties = Arr::except($request->all(), ['imported_t', 'created_t', 'status']);
        $properties['last_modified_t'] = now()->toISOString();

        $product->fill($properties);

        $product->save();

        return response()->json(['message' => 'Produto atualizado com sucesso']);
    }

    public function delete($code)
    {
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $product->status = ProductStatus::Trash;

        $product->save();

        return response()->json(['message' => 'Status do produto alterado para apagado']);
    }
}
