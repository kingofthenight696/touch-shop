<?php

namespace App\Http\Controllers\AdminSide;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

class BoardController extends Controller
{
    public function uploadBoard(Request $request)
    {
        $result = false;
        if($request->hasFile('board'))
        {
            $file = $request->file('board');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $sold = time();
            $filename = $sold.'.'.$extension;
            $res = Storage::disk('public')->putFileAs('boards', $file, $filename);

            $image = Image::make(
                Storage::disk('public')->get($res)
            )->encode('jpg', 50);

            $previewFilename = 'preview_'.$filename;

            Storage::disk('public')->put('boards/'.$previewFilename, $image);

            $board = Board::first();
            $board->update([
                'image' => $filename,
                'preview' => $previewFilename,
                ]);

            $result = true;
        }

        return ($result)
            ? response()->json([
                'status' => 'success'
            ])
            : response()->json([
                'status' => 'fail'
            ]);
    }
}
