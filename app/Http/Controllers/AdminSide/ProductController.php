<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(AddProductRequest $request)
    {
        $product = new ProductResource(
            Product::create($request->only([
                'board_id',
                'title',
                'description',
                'price',
            ])));

        return response()->json(
            [
                'status' => true,
                'msg'=>'success',
                'data' => new ProductResource($product)
            ]);
    }

    public function editProduct($productId, AddProductRequest $request)
    {
        $product = Product::find($productId);

        $result = $product->update($request->only([
            'board_id',
            'title',
            'description',
            'price',
        ]));

        return $product
            ? response()->json([
                    'status' => true,
                    'msg'=>'success',
                    'data' => new ProductResource($result)
                ])
            : response()->json([
                'status' => false,
                'msg' => 'fail'
            ]);
    }

    public function removeProduct($productId)
    {
        $product = Product::where('id', $productId)->delete();
        return $product
            ? response()->json([
                'status' => true,
                'msg'=>'success'
            ])
            : response()->json([
                'status' => false,
                'msg' => 'fail'
            ]);
    }
}
