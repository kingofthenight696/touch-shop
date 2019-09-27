<?php

namespace App\Http\Controllers\AdminSide;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoardController extends Controller
{
    public function uploadBoard(Request $request)
    {
        $result = false;
        if($request->hasFile('board'))
        {
            $file = $request->file('board');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time().'.'.$extension;

            Storage::disk('public')->putFileAs('boards', $file, $filename);

            $board = Board::first();
            $board->path = $filename;
            $result = $board->save();
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
