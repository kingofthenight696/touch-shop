<?php

namespace App\Http\Controllers\AdminSide;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Board;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
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
        $content = Product::get([
            'coordinates',
            'title',
            'description',
            'price',
        ]);

        Storage::disk('local')->put($fileName, $content);

        return response()->download(
            Storage::disk('local')->path($fileName),
            $fileName)
            ->deleteFileAfterSend(true);
    }

    public function upload(Request $request)
    {
        $result = false;
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            if($file->isReadable()) {
                $res = $file->openFile('r');
                $contents = $res->fread($res->getSize());

                $json = json_decode($contents, true);

                $board = Board::first();
                foreach ($json as &$item){
                    $item['coordinates'] = json_encode($item['coordinates']);
                    $item['board_id'] = $board->id;
                }

                Product::insert($json);
                $result = true;
            } else {
                throw new Exception('File is not readable');
            }
        }

        return $result
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
