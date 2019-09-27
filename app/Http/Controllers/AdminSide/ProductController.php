<?php

namespace App\Http\Controllers\AdminSide;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

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

    public function download()
    {
        $fileName = time() . '_datafile.json';
        $content = Product::all();

        Storage::disk('local')->put($fileName, $content);

        return response()->download(
            Storage::disk('local')->path($fileName),
            $fileName)
            ->deleteFileAfterSend(true);
    }

    public function upload(Request $request)
    {
            dd($_FILES);
//        if ($request->hasFile('banners')) {
//
//            $data = json_decode($request->payload, true);
//            $rules = [
//                'name' => 'digits:8', //Must be a number and length of value is 8
//                'age' => 'digits:8'
//            ];
//
//            $validator = Validator::make($data, $rules);
//            if ($validator->passes()) {
//                //TODO Handle your data
//            } else {
//                //TODO Handle your error
//                dd($validator->errors()->all());
//            }
//        }
        return $request;
    }
}
