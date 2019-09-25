<?php

namespace App\Http\Controllers\AdminSide;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProduct($productId)
    {
        $product = Product::find($productId);

        return response()->json(
            [
                'status' => true,
                'msg' => 'success',
                'data' => new ProductResource($product)
            ]);
    }

    public function addProduct(AddProductRequest $request)
    {
        $result = Product::create($request->only([
            'board_id',
            'title',
            'description',
            'price',
            'coordinates',
        ]));

        return response()->json(
            [
                'status' => true,
                'msg' => 'success',
                'data' => new ProductResource($result)
            ]);
    }

    public function editProduct($productId, AddProductRequest $request)
    {
        $product = Product::find($productId);

        $result = $product->update($request->only([
            'title',
            'description',
            'price',
            'coordinates',
        ]));

        return $result
            ? response()->json([
                'status' => true,
                'msg' => 'success',
                'data' => new ProductResource($product)
            ])
            : response()->json([
                'status' => false,
                'msg' => 'fail'
            ]);
    }

    public function deleteProduct($productId)
    {
        $product = Product::where('id', $productId)->delete();
        return $product
            ? response()->json([
                'status' => true,
                'msg' => 'success'
            ])
            : response()->json([
                'status' => false,
                'msg' => 'fail'
            ]);
    }
}
